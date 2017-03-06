<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 17/3/6
 * Time: 下午12:01
 */

require_once __DIR__ . '/bootstrap.php';

use Yyg\Robot\Services\RobotModel;

$ret = RobotModel::auto_open_task_per_hour();

if($ret == 0) {

    mdebug("open task successfully!");

} else if ( $ret == 1 ) {

    mdebug("open task failed!");

} else {

    mdebug("all task are open");

}
