<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/23
 * Time: 下午4:42
 */

namespace Yyg\Robot\Services;

class MemUsage
{

    public static function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');

        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}