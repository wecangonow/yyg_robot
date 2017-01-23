<?php

namespace Yyg\Robot\Util;

use Yyg\Robot\Services\MemcachedService;
use Yyg\Robot\Services\RobotModel;
use Yyg\Robot\Configuration\RobotServerConfiguration;

class Task
{
    //暂存每个商品每期机器人总计购买的金额
    //[
    //    '国家' => ['任务ID'=> '当前机器人购买金额'],
    //    '国家' => ['任务ID'=> '当前机器人购买金额'],
    //    '国家' => ['任务ID'=> '当前机器人购买金额']
    //]
    public        $buy_numbers          = [
        2,
        70,
        21,
        20,
        7,
        1,
        23,
        4,
        10,
        2,
        7,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        5,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        2,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        1,
        4,
        10,
        5,
        7,
        1,
        59,
        13,
        65,
        1,
        1,
        5,
        13,
        27,
        15,
        1,
        2,
        10,
        1,
        5,
        10,
        2,
        5,
        1,
        1,
        2,
        13,
        5,
        60,
        2,
        10,
        29,
        1,
        10,
        10,
        8,
        50,
        2,
        5,
        16,
        2,
        1,
        11,
        11,
        53,
        5,
        1,
        1,
        2,
        19,
        8,
        1,
        1,
        2,
        1,
        10,
        20,
        2,
        1,
        2,
        5,
        10,
        1,
        14,
        2,
        1,
        1,
        4,
        1,
        1,
        1,
        1,
        13,
        5,
        1,
        5,
        10,
        14,
        30,
        12,
        10,
        21,
        12,
        1,
        2,
        1,
        2,
        8,
        2,
        26,
        9,
        2,
        2,
        14,
        2,
        1,
        40,
        15,
        4,
        4,
        1,
        7,
        6,
        12,
        6,
        1,
        30,
        2,
        2,
        54,
        2,
        6,
        1,
        1,
        30,
        1,
        18,
        1,
        5,
        5,
        1,
        2,
        1,
        10,
        1,
        5,
        2,
        2,
        1,
        9,
        10,
        1,
        2,
        5,
        5,
        60,
        9,
        2,
        3,
        1,
        2,
        6,
        5,
        70,
        10,
        2,
        2,
        2,
        51,
        38,
        38,
        24,
        11,
        3,
        2,
        15,
        10,
        10,
        3,
        90,
        4,
        5,
        10,
        10,
        1,
        1,
        1,
        19,
        10,
        62,
        80,
        39,
        1,
        1,
        2,
        56,
        2,
        1,
        1,
        25,
        1,
        1,
        30,
        1,
        6,
        30,
        1,
        33,
        5,
        50,
        5,
        2,
        1,
        2,
        1,
        14,
        3,
        50,
        22,
        1,
        1,
        10,
        36,
        5,
        1,
        1,
        1,
        2,
        2,
        1,
        1,
        1,
        10,
        5,
        2,
        1,
        1,
        1,
        10,
        10,
        11,
        2,
        2,
        50,
        8,
        1,
        7,
        1,
        10,
        1,
        1,
        8,
        1,
        2,
        100,
        10,
        2,
        26,
        18,
        2,
        5,
        1,
        1,
        24,
        36,
        15,
        2,
        2,
        5,
        1,
        31,
        57,
        1,
        1,
        1,
        5,
        1,
        37,
        4,
        50,
        1,
        20,
        10,
        2,
        1,
        9,
        25,
        3,
        5,
        5,
        10,
        20,
        6,
        35,
        1,
        20,
        29,
        2,
        5,
        2,
        2,
        2,
        2,
        5,
        1,
        13,
        1,
        6,
        7,
        2,
        1,
        40,
        67,
        1,
        6,
        68,
        20,
        10,
        2,
        5,
        50,
        9,
        2,
        1,
        2,
        45,
        52,
        1,
        63,
        1,
        1,
        15,
        2,
        2,
        2,
        30,
        31,
        55,
        58,
        1,
        10,
        1,
        5,
        2,
        1,
        2,
        1,
        5,
        7,
        5,
        1,
        39,
        1,
        60,
        3,
        1,
        20,
        10,
        1,
        28,
        35,
        5,
        1,
        2,
        10,
        5,
        2,
        28,
        1,
        2,
        1,
        1,
        5,
        1,
        2,
        2,
        5,
        60,
        2,
        8,
        5,
        2,
        30,
        20,
        15,
        30,
        23,
        8,
        33,
        1,
        9,
        1,
        2,
        2,
        10,
        2,
        15,
        10,
        15,
        64,
        5,
        1,
        10,
        45,
        2,
        15,
        1,
        10,
        5,
        1,
        2,
        10,
        2,
        1,
        5,
        1,
        5,
        10,
        14,
        1,
        10,
        2,
        37,
        27,
        10,
        12,
        1,
        9,
        1,
        1,
        15,
        3,
        6,
        69,
        1,
        5,
        2,
        10,
        2,
        8,
        10,
        2,
        22,
        1,
        3,
        7,
        1,
        1,
        1,
        5,
        32,
        1,
        3,
        2,
        10,
        1,
        7,
        66,
        10,
        9,
        50,
        61,
        40,
        1,
        34,
        2,
        1,
        10,
        1,
        1,
        3,
        4,
        12,
        5,
        1,
        1,
        9,
        5,
        2,
        30,
        1,
        2,
        1,
        2,
        11,
        1,
        1,
        32,
        1,
        5,
        2,
        4,
        40,
        1,
        20,
        4,
        1,
        50,
        1,
        5,
        1,
        34,
        2,
        6,
        17,
        5,
        16,
        10,
        2,
        1,
        10,
        10,
        5,
        1,
        1,
        20,
        30,
        9,
        8,
        10,
        7,
        2,
        8,
        5,
        17,
        10,
        1,
        10,
    ];

    public function __construct()
    {
    }

    public function GetAllTaskIDs()
    {
        $countries = RobotServerConfiguration::instance()->countries;
        $tasks     = [];

        foreach ($countries as $country) {
            $hour            = date("G", time());
            $tasks[$country] = RobotModel::GetTaskIDs($country, $hour);
        }

        return $tasks;

    }

    public function execute()
    {

        foreach ($this->GetAllTaskIDs() as $country => $ids) {
            //根据国家动态修改时区

            $timezone = RobotServerConfiguration::instance()->timezones[$country];
            date_default_timezone_set($timezone);


            if (count($ids) > 0) {
                $step = 0;
                foreach ($ids as $id) {

                    $task = RobotModel::GetTaskInfoById($country, $id);

                    //判断是否达到脚本执行时间,购买次数是否符合要求
                    $exec_time = MemcachedService::Get($country . "_exec_time_" . $task['gid']);
                    if (RobotServerConfiguration::instance()->is_debug) {
                        mdebug(
                            "country: %s :goods id %d task id %d : run_hour is %d excute time is %s - time remaining is %ds",
                            $country,
                            $task['gid'],
                            $task['id'],
                            $task['run_hour'],
                            date("Y-m-d H:i:s", $exec_time),
                            $exec_time - time()
                        );
                    }
                    $time_condition = $this->get_time_condition($exec_time);
                    if ($time_condition
                        || ($task['exec_record_times'] >= $task['exec_times']
                            && $task['exec_times']
                               != -1)
                    ) {
                        $step += 1;
                        continue;
                    }

                    $robots  = RobotModel::GetRobot($country);
                    $r_index = array_rand($robots);
                    $rt_uid  = $robots[$r_index]['id'];

                    if ($task['join_type'] == 3) {
                        $join_type = rand(0, 2);
                    }
                    else if ($task['join_type'] == 2) {
                        $join_type = rand(1, 2);
                    }
                    else {
                        $join_type = 0;
                    }

                    //判断机器人购买的数量是否达到上限
                    //调用远程接口开始
                    $param   = "url_" . $country;
                    $uri     = RobotServerConfiguration::instance()->$param;
                    $buy_num = $this->buy_numbers[mt_rand(0, 887)];
                    //设置 key  为 country_buy_times_task_id  的上一次购买的次数，如果该次数目跟上一次一样则放弃

                    if ($task['price'] < 500 && $buy_num > 10) {
                        $buy_num = mt_rand(1, 2);
                    }

                    if ($buy_num != 1 || $buy_num != 2) {
                        $last_buy_num = MemcachedService::Get($country . "_buy_times_" . $task['id']);

                        if ($last_buy_num) {
                            if ($last_buy_num == $buy_num) {
                                $buy_num = mt_rand(1, 2);
                            }
                            else {
                                MemcachedService::Set($country . "_buy_times_" . $task['id'], $buy_num);
                            }

                        }
                        else {
                            MemcachedService::Set($country . "_buy_times_" . $task['id'], $buy_num);
                        }

                    }

                    $task['buy_times'] = $buy_num;

                    $request_data = [
                        'id'        => $task['id'],
                        'uid'       => $rt_uid,
                        'gid'       => $task['gid'],
                        'num'       => $task['buy_times'],
                        'join_type' => $join_type,
                    ];

                    $ret = $this->post_data($uri, $request_data);

                    if ($ret[0] == -160) {
                        minfo(
                            "Country: %s | Goods %d is closed | Reason is %s",
                            $country,
                            $task['gid'],
                            json_encode($ret)
                        );
                    }

                    if (isset($ret['1']) && $ret['1'] == "success") {

                        MemcachedService::Delete($country . "_" . $task['id']);

                        minfo(
                            "country: %s : task id %d : excuted delayed %d s robot %d buy goods %d %d yuan",
                            $country,
                            $task['id'],
                            time() - $exec_time,
                            $rt_uid,
                            $task['gid'],
                            $task['unit_price'] * $task['buy_times']
                        );

                        //更新任务
                        RobotModel::sync_task($task, $country);

                        // 写远程日志
                        RobotModel::write_remote_log(
                            $country,
                            $ret['nper_id'],
                            $robots[$r_index],
                            $task['buy_times']
                        );


                        $buy_total = $task['buy_times'] * $task['unit_price'];

                        if(!MemcachedService::Increment($country . "_total_money_" . $task['gid'] . "_" . $ret['nper_id'], $buy_total )) {

                            MemcachedService::Set(
                                $country . "_total_money_" . $task['gid'] . "_" . $ret['nper_id'],
                                $buy_total,
                                3600 * 24 * 15
                            );
                        }

                        if ($this->reach_money_limit($task, $country, $ret['nper_id'])) {
                            RobotModel::CloseTask($task, $country);
                            minfo(
                                "Country: %s | Task %d is closed | Reason is up to the participate percent - %s",
                                $country,
                                $task['id'],
                                $task['percent']
                            );
                        }


                    }
                    else {
                        merror(
                            "Country: %s | Task %d failed | Reason is %s",
                            $country,
                            $task['id'],
                            json_encode($ret)
                        );
                    }

                }

                if ($step == count($ids)) {
                    mnotice("%s have no task time is up", $country);
                }
            }
            else {
                mnotice("%s have no task open right now", $country);
            }

        }

    }

    // 将每个商品每期购买的金额缓存到memcache

    public function reach_money_limit($data, $country, $nper_id)
    {
        $percent       = $data['percent'];
        $price         = $data['price'];
        $total_money_key = $country . "_total_money_" . $data['gid'] . "_" . $nper_id;
        $current_money = MemcachedService::Get($total_money_key);
        if (!$current_money) {
            $current_money = 0;
        }

        $current_percent = $current_money * 100 / $price;
        $fix_percent     = (int)str_replace("%", "", $percent);

        if (RobotServerConfiguration::instance()->is_debug) {
            mdebug(
                "goods %d price is %d current percent is %s money is %d && total_money_index is %s",
                $data['gid'],
                $price,
                $current_percent . "%",
                $current_money,
                $total_money_key
            );
        }
        if ($current_percent > $fix_percent) {
            return true;
        }
        else {

            return false;
        }

    }

    public function get_time_condition($exec_time)
    {
        return (int)$exec_time > (int)time();
    }

    public function post_data($uri, $data)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $str = http_build_query($data);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        $ret = curl_exec($curl);

        curl_close($curl);

        return json_decode($ret, true);
    }

}
