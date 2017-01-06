<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/22
 * Time: 下午3:31
 */

namespace Yyg\Robot\Services;
use Yyg\Robot\Configuration\RobotServerConfiguration;

class MysqlService
{
    public static function GetMalaysiaDB()
    {
        $config = RobotServerConfiguration::instance()->mysql_malaysia;
        return new \Simplon\Mysql\Mysql($config['host'], $config['user'], $config['password'], $config['dbname']);
    }

    public static function GetTurkeyDB()
    {
        $config = RobotServerConfiguration::instance()->mysql_turkey;
        return new \Simplon\Mysql\Mysql($config['host'], $config['user'], $config['password'], $config['dbname']);
    }

    public static function GetRussiaDB()
    {
        $config = RobotServerConfiguration::instance()->mysql_russia;
        return new \Simplon\Mysql\Mysql($config['host'], $config['user'], $config['password'], $config['dbname']);
    }

}