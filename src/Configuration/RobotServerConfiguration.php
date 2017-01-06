<?php

namespace Yyg\Robot\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Oasis\Mlib\Config\AbstractYamlConfiguration;

class RobotServerConfiguration extends AbstractYamlConfiguration
{
    public $is_debug;
    public $log_path;
    public $services;
    public $mysql_malaysia;
    public $mysql_turkey;
    public $mysql_russia;
    public $http_port;
    public $memcache_config;
    public $url_malaysia;
    public $url_turkey;
    public $url_russia;
    public $cache_time;
    public $dispatch_time;
    public $countries;

    public function load()
    {
        $this->loadYaml(
            "config.yml",
            [
                PROJECT_DIR . "/config",
                "../../"

            ]
        );
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root("robot_server");
        {
            $rootNode->children()->booleanNode("is_debug")->defaultValue(false);
            $rootNode->children()->scalarNode("log_path")->defaultValue("/tmp");
            $rootNode->children()->integerNode("http_port")->defaultValue(80);
            $rootNode->children()->integerNode("cache_time")->defaultValue(60);
            $rootNode->children()->integerNode("dispatch_time")->defaultValue(1);
            $rootNode->children()->arrayNode("countries")->prototype("scalar");

            $apis     = $rootNode->children()->arrayNode("buy_api");
            {
                $api_malaysia = $apis->children()->arrayNode("api_malaysia");
                {
                    $api_malaysia->children()->scalarNode("url");
                }
                $api_turkey = $apis->children()->arrayNode("api_turkey");
                {
                    $api_turkey->children()->scalarNode("url");
                }
                $api_russia = $apis->children()->arrayNode("api_russia");
                {
                    $api_russia->children()->scalarNode("url");
                }
            }


            $services = $rootNode->children()->arrayNode("services");
            {
                $mysql_malaysia = $services->children()->arrayNode("mysql_malaysia");
                {
                    $mysql_malaysia->children()->scalarNode("dbname");
                    $mysql_malaysia->children()->scalarNode("user");
                    $mysql_malaysia->children()->scalarNode("password");
                    $mysql_malaysia->children()->scalarNode("host")->defaultValue("localhost");
                    $mysql_malaysia->children()->scalarNode("charset")->defaultValue("utf8");
                    $mysql_malaysia->children()->integerNode("port")->defaultValue(3306);

                }

                $mysql_turkey = $services->children()->arrayNode("mysql_turkey");
                {
                    $mysql_turkey->children()->scalarNode("dbname");
                    $mysql_turkey->children()->scalarNode("user");
                    $mysql_turkey->children()->scalarNode("password");
                    $mysql_turkey->children()->scalarNode("host")->defaultValue("localhost");
                    $mysql_turkey->children()->scalarNode("charset")->defaultValue("utf8");
                    $mysql_turkey->children()->integerNode("port")->defaultValue(3306);

                }

                $mysql_russia = $services->children()->arrayNode("mysql_russia");
                {
                    $mysql_russia->children()->scalarNode("dbname");
                    $mysql_russia->children()->scalarNode("user");
                    $mysql_russia->children()->scalarNode("password");
                    $mysql_russia->children()->scalarNode("host")->defaultValue("localhost");
                    $mysql_russia->children()->scalarNode("charset")->defaultValue("utf8");
                    $mysql_russia->children()->integerNode("port")->defaultValue(3306);

                }

                $memcache = $services->children()->arrayNode("memcache");
                {
                    $memcache->children()->scalarNode("host")->isRequired();
                    $memcache->children()->integerNode("port")->isRequired();
                }

            }

        }

        return $treeBuilder;

    }

    public function assignProcessedConfig()
    {
        $this->is_debug        = $this->processedConfig["is_debug"];
        $this->log_path        = $this->processedConfig["log_path"];
        $this->cache_time      = $this->processedConfig["cache_time"];
        $this->dispatch_time   = $this->processedConfig["dispatch_time"];
        $this->http_port       = $this->processedConfig["http_port"];
        $this->mysql_russia    = $this->processedConfig["services"]["mysql_russia"];
        $this->mysql_turkey    = $this->processedConfig["services"]["mysql_turkey"];
        $this->mysql_malaysia  = $this->processedConfig["services"]["mysql_malaysia"];
        $this->memcache_config = $this->processedConfig["services"]["memcache"];
        $this->url_malaysia    = $this->processedConfig["buy_api"]["api_malaysia"]["url"];
        $this->url_turkey      = $this->processedConfig["buy_api"]["api_turkey"]["url"];
        $this->url_russia      = $this->processedConfig["buy_api"]["api_russia"]["url"];
        $this->countries       = $this->processedConfig['countries'];
    }

    public function dumpConfig()
    {
        print_r($this->processedConfig);
    }

}
