<?php

require_once __DIR__ . '/bootstrap.php';

use Yyg\Robot\Util\Timer;
use Yyg\Robot\Util\Task;
use Yyg\Robot\Services\MemUsage;
use Yyg\Robot\Configuration\RobotServerConfiguration;
use Oasis\Mlib\Logging\LocalFileHandler;
use Yyg\Robot\Services\RobotModel;

$dispatch_time = RobotServerConfiguration::instance()->dispatch_time;

$countries = RobotServerConfiguration::instance()->countries;

date_default_timezone_set("Europe/Istanbul");

(new LocalFileHandler(RobotServerConfiguration::instance()->log_path))->install();

// 同步时间为每一期的最后一期最后一单的随机一个时间
if (count($countries) > 0) {
    foreach ($countries as $country) {
        $ret = RobotModel::sync_first_order_time($country);

        if (RobotServerConfiguration::instance()->is_debug && $ret['state']) {
            mdebug(
                "country: %s :goods id %d next exec time is set to %s ",
                $country,
                $ret['gid'],
                date("Y-m-d H:i:s", $ret['exec_time'])
            );
        }
    }
}

$task = new Task();

Timer::run($task, $dispatch_time);

while (1) {
    pcntl_signal_dispatch();

    (new LocalFileHandler(RobotServerConfiguration::instance()->log_path))->install();

    if (RobotServerConfiguration::instance()->is_debug) {
        mdebug("memory usage: %s", MemUsage::convert(memory_get_usage(true)));
    }

    sleep($dispatch_time);

}



