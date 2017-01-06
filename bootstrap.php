<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/21
 * Time: 下午6:13
 */

use Yyg\Robot\Configuration\RobotServerConfiguration;

define("PROJECT_DIR", __DIR__);

require_once __DIR__ . "/vendor/autoload.php";

RobotServerConfiguration::instance()->load();


