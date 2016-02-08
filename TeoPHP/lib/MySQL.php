<?php

namespace TeoPHP\lib;

class MySQL
{
    private static $connects = array();

    private static $config;
    private static $db;
    private static $db_type;
    private static $p_connect;
    private static $timeout;
    private static $charset;

    private $dsn;
    private $username;
    private $password;
    private $options = array();
    private $pdo;

    private function __construct()
    {
        if (!array_key_exists(self::$db, self::$config)) {
            throw new \Exception('the db is not found');
        }
        if (self::$db_type === 'master') {
            $confNum = 0;
        } elseif (self::$db_type === 'slave') {
            $dbNum = count(self::$config[self::$db]['dsn']);
            if($dbNum < 2) {
                throw new \Exception('the db conf have no slave');
            }
            $confNum = mt_rand(1, $dbNum - 1);
        } else {
            throw new \Exception('the dbType must be master or slave');
        }

        self::$charset = empty(self::$charset) ? self::$config[self::$db]['charset'] : self::$charset;
        $this->dsn = self::$config[self::$db]['dsn'][$confNum] . ';charset=' . self::$charset;
        $this->username = self::$config[self::$db]['username'][$confNum];
        $this->password = self::$config[self::$db]['password'][$confNum];
        $this->options[\PDO::ATTR_TIMEOUT] = self::$timeout > 0 ? self::$timeout : self::$config[self::$db]['timeout'];
        $this->options[\PDO::ATTR_PERSISTENT] = self::$p_connect ? true : false;

        try {
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password, $this->options);
            $this->pdo->query('set names ' . self::$charset);
        } catch (\PDOException $e) {
            throw new \Exception("db connect error: " . self::$db . $confNum . ' '. $e->getMessage());
        }
        return $this->pdo;
    }

    /**
     * 唯一单例入口
     * 数据库的名字
     * @param $db
     * 数据库类型 主库还是副库 master or slave
     * @param $db_type
     * 是否长连接 true or false
     * @param bool $p_connect
     * @param null $timeout
     * @param null $charset
     * @return mixed
     */
    public static function connect($db, $db_type, $p_connect = false, $timeout = null, $charset = null)
    {
        if (empty(self::$connects[$db][$db_type])) {
            //获得配置文件
            self::$config = \TeoPHP\Application::getConfig('resource');

            self::$db = $db;
            self::$db_type = $db_type;
            self::$p_connect = $p_connect;
            self::$timeout = $timeout;
            self::$charset = $charset;
            self::$charset = $charset;
            self::$charset = $charset;
            self::$connects[$db][$db_type] = new self;
        }
        return self::$connects[$db][$db_type];
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

}