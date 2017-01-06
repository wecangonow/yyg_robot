<?php

namespace Yyg\Robot\Util;


class Timer
{
    public static $time = 1;
    public static $task = null;

    public static function run(Task $task, $time = null)
    {
        if($time)
        {
            self::$time = $time;
        }

        self::$task = $task;
        self::installHandler();
        pcntl_alarm(1);
    }

    public static function installHandler()
    {
        pcntl_signal(SIGALRM, ["\Yyg\Robot\Util\Timer","signalHandler"]);
    }

    public static function signalHandler()
    {
        self::$task->execute();
        pcntl_alarm(self::$time);
    }


}
