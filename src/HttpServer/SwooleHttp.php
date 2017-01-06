<?php

/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/22
 * Time: 上午11:11
 */
namespace Yyg\Robot\HttpServer;
use Yyg\Robot\Configuration;


class SwooleHttp
{
    public static function run()
    {
        $serv = new \swoole_http_server("127.0.0.1", Configuration\RobotServerConfiguration::instance()->http_port);

        $serv->on('Request', function($request, $response) {
            var_dump($request->get);
            var_dump($request->post);
            var_dump($request->cookie);
            var_dump($request->files);
            var_dump($request->header);
            var_dump($request->server);

            $response->cookie("User", "Swoole");
            $response->header("X-Server", "Swoole");
            $response->end("Hello Swoole!");
        });

        $serv->start();

    }
    
}