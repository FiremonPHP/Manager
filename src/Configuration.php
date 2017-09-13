<?php
namespace FiremonPHP\Manager;


class Configuration
{
    /**
     * @var Manager[]
     */
    private static $_managers = [];
    /**
     * @var array
     */
    private static $_databases = [];

    public static function set(string $name, array $configs)
    {
        if (!isset($configs['database'])) {
            throw new \ErrorException('Config array need "database" index with name of database!');
        }

        if (!isset($configs['url'])) {
            throw new \ErrorException('Config array need "url" index with url connection!');
        }

        $mongoManager = new \MongoDB\Driver\Manager($configs['url']);
        self::$_managers[$name] = new Manager($mongoManager, $configs['database']);
        self::$_databases[$name] = $configs['database'];
    }

    /**
     * @param string $name
     * @return Manager
     * @throws \ErrorException
     */
    public static function get(string $name = 'default')
    {
        if (isset(self::$_managers[$name])) {
            return self::$_managers[$name];
        }

        throw new \ErrorException('The connection: "'.$name.'" not configured!');
    }

    /**
     * @param string $name
     * @return string
     */
    public function getDatabaseName(string $name = 'default')
    {
        return self::$_databases[$name];
    }

}