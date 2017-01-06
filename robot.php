<?php

require_once __DIR__ . '/bootstrap.php';

use Yyg\Robot\Util\Timer;
use Yyg\Robot\Util\Task;
use Yyg\Robot\Services\MemUsage;
use Yyg\Robot\Configuration\RobotServerConfiguration;
use Oasis\Mlib\Logging\LocalFileHandler;

$dispatch_time = RobotServerConfiguration::instance()->dispatch_time;

$task = new Task("robot_task_buy_money.tmp");

Timer::run($task, $dispatch_time);

file_put_contents("robot_task_buy_money.tmp", "");

while (1) {
    pcntl_signal_dispatch();

    (new LocalFileHandler(RobotServerConfiguration::instance()->log_path))->install();

    if (RobotServerConfiguration::instance()->is_debug) {
        mdebug("memory usage: %s", MemUsage::convert(memory_get_usage(true)));
    }

    sleep($dispatch_time);

}



