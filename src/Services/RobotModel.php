<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/22
 * Time: 下午3:04
 */

namespace Yyg\Robot\Services;

use Yyg\Robot\Configuration\RobotServerConfiguration;

class RobotModel
{
    //物品购买上限(0为无上限)
    const _maxtime = 1000;

    //机器人开启时
    public static function sync_first_order_time($country)
    {
        // 获取所有商品的最后一单时间
        $time_sql = "select * from (select goods_id, pay_time from sp_order_list  where goods_id in ( select gid from sp_rt_regular where enable = 1 group by `gid` ) and success_num > 0 order by pay_time desc ) as tmp group by goods_id order by `goods_id`
";
        $db    = self::GetDbByCountry($country);
        $times = $db->fetchRowMany($time_sql);

        if(count($times) > 0)
        {
            foreach($times as $time)
            {
                $condition['gid']          = $time['goods_id'];
                $exec_time = substr($time['pay_time'], 0 , 10) + mt_rand(3600 , 3600 * 2);
                $now = time();

                if($exec_time < $now)
                {
                    $exec_time = $now + mt_rand(60, 1800);
                }
                $up_data['exec_time'] = $exec_time;

                $db->update('sp_rt_regular', $condition, $up_data);
            }
        }
    }


    /*
     * 将每条任务以key_taskid 为key保存到memcache
     * @return task ids
     */
    public static function GetTaskIDs($country, $hour = 0)
    {
        //$task_sql = "select p.*, g.price, g.unit_price from sp_rt_regular p right join sp_goods g on p.gid = g.id where run_hour = :hour and enable = 1 order by exec_time";
        $task_sql = "select p.*, g.price, g.unit_price from sp_rt_regular p right join sp_goods g on p.gid = g.id where run_hour = :hour and enable = 1 order by rand()";

        $cache_time = \Yyg\Robot\Configuration\RobotServerConfiguration::instance()->cache_time;

        $ids = MemcachedService::Get($country . "_task_ids");

        if (!$ids) {
            $db = self::GetDbByCountry($country);

            $tasks = $db->fetchRowMany($task_sql, ["hour" => $hour]);

            if (count($tasks) > 0) {
                foreach ($tasks as $task) {
                    $ids[] = $task['id'];
                }

                MemcachedService::Set($country . "_task_ids", serialize($ids), $cache_time);

                return $ids;
            }
            else {
                return [];
            }
        }

        return unserialize($ids);

    }

    public static function getZeroHourIdByTaskId($country, $task_id)
    {
        $sql = "select gid from sp_rt_regular where id = :id";
        $db  = self::GetDbByCountry($country);
        $gid = $db->fetchRow($sql, ["id" => $task_id])['gid'];

        $zero_sql = "select id, exec_time from sp_rt_regular where gid = :gid and run_hour=0";
        $info     = $db->fetchRow($zero_sql, ["gid" => $gid]);

        return ['gid' => $gid, 'exec_time' => $info['exec_time'], 'id' => $info['id']];
    }

    public static function GetTaskInfoById($country, $id)
    {
        $zero_info = self::getZeroHourIdByTaskId($country, $id);
        $task_sql  = "select p.*, g.price, g.unit_price from sp_rt_regular p right join sp_goods g on p.gid = g.id where p.id = :id and p.enable = 1 ";

        $cache_time = \Yyg\Robot\Configuration\RobotServerConfiguration::instance()->cache_time;

        $info      = MemcachedService::Get($country . "_" . $id);
        $exec_time = MemcachedService::Get($country . "_exec_time_" . $zero_info['gid']);
        if (!$exec_time) {
            MemcachedService::Set($country . "_exec_time_" . $zero_info['gid'], $zero_info['exec_time'], $cache_time);
        }

        if (!$info) {
            $db = self::GetDbByCountry($country);

            $task = $db->fetchRowMany($task_sql, ["id" => $id]);

            $task = self::deals_data($task[0], $country);

            MemcachedService::Set($country . "_" . $id, serialize($task), $cache_time);

            return $task;
        }

        return unserialize($info);

    }

    public static function GetRobot($country)
    {
        $robot_sql = "select id, nick_name from sp_users where type = -1 and status = 1";

        $cache_time = \Yyg\Robot\Configuration\RobotServerConfiguration::instance()->cache_time;

        $ret = MemcachedService::Get($country . "_robot_list");

        if (!$ret) {
            $db   = self::GetDbByCountry($country);
            $list = $db->fetchRowMany($robot_sql);

            MemcachedService::Set($country . "_robot_list", serialize($list), $cache_time);
        }
        else {
            $list = unserialize($ret);
        }

        return $list;
    }

    public static function deals_data($data, $country)
    {
        //获取执行时间
        $exec_time = $data['exec_time'];
        if ($exec_time == 0) {
            //初始化执行时间
            $data['exec_time'] = self::init_exec_time($data, $country);

        }
        $data['buy_times'] = self::get_buy_times($data);

        return $data;
    }

    //初始化任务执行时间
    private static function init_exec_time($data, $country)
    {
        $time = time();
        $time = intval(rand($data['min_time'], $data['max_time']) / $data['speed_x']) + (int)$time;

        $db                   = self::GetDbByCountry($country);
        $conds['id']          = $data['id'];
        $up_data['exec_time'] = $time;
        $db->update('sp_rt_regular', $conds, $up_data);

        return $time;

    }

    //获取购买次数
    private static function get_buy_times($data)
    {
        $max  = $data['max_buy_times'] * $data['money_x'];
        $min  = $data['min_buy_times'];
        $time = (int)ceil(mt_rand($min, $max));
        //若设置购买上限则最大购买次数为购买上限设置的数值
        if (self::_maxtime !== 0 && $time > self::_maxtime) {
            $time = self::_maxtime;
        }

        return $time;
    }

    public static function sync_task($data, $country)
    {
        $up_data['exec_time']         = self::init_exec_time($data, $country);
        $up_data['exec_record_times'] = (int)$data['exec_record_times'] + 1;
        $up_data['update_time']       = time();

        $conds['id'] = self::getZeroHourIdByTaskId($country, $data['id'])['id'];

        $db = self::GetDbByCountry($country);

        return $db->update('sp_rt_regular', $conds, $up_data);
    }

    public static function write_remote_log($country, $nper_id, $rt = [], $num = 0)
    {
        $sql = "select g.name from sp_nper_list n left join sp_goods g on n.pid = g.id where n.id = :nper_id";

        $db = self::GetDbByCountry($country);

        $g_name = $db->fetchRow($sql, ["nper_id" => $nper_id])['name'];

        $time = time();
        $log  = '机器人(' . $rt['nick_name'] . ')于' . date("Y-m-d H:i:s", $time) . '购买了(' . $g_name . ')' . $num . '份';
        $data = ['nper_id'     => $nper_id,
                 'user'        => $rt['id'],
                 'type'        => 'RtRegular',
                 'log'         => $log,
                 'create_time' => $time,
        ];

        $db->insert("log", $data);

    }

    private static function GetDbByCountry($country)
    {
        $countries = RobotServerConfiguration::instance()->countries;

        if ($country == "") {
            die("country name should not be empty");
        }

        if (!in_array($country, $countries)) {
            die("no such country in config file");
        }

        switch ($country) {
            case malaysia:

                $db = MysqlService::GetMalaysiaDB();

                return $db;

            case russia:

                $db = MysqlService::GetRussiaDB();

                return $db;

            case turkey:

                $db = MysqlService::GetTurkeyDB();

                return $db;
        }

    }

    public static function CloseTask($data, $country)
    {
        $up_data['enable'] = -1;

        $conds['gid'] = $data['gid'];

        $db = self::GetDbByCountry($country);

        return $db->update('sp_rt_regular', $conds, $up_data);
    }
}
