<?php
class LkzDatabase {
    private static $instance = [];

    public static function getInstance(
        $username = 'root',
        $password = 'root',
        $dbname = 'neobiz_dev',
        $host = '127.0.0.1',
        $port = '3306',
        $driver = 'mysql') {

        $config = parse_ini_file("database.ini", true);
        if(!isset(self::$instance[$config['mysql']['dbname']])) {
            $dns = $config['mysql']['driver'] == "dblib" ?
                $config['mysql']['driver'] . ":host=" . $config['mysql']['host'] . ":" . $config['mysql']['port'] . ";dbname=".$config['mysql']['dbname'] :
                $config['mysql']['driver'] . ':host=' . $config['mysql']['host'] . ((!empty($config['mysql']['port'])) ? (';port=' . $config['mysql']['port']) : '') . ';dbname=' . $config['mysql']['dbname'];

            try {
                $pdo = new PDO($dns, $config['mysql']['username'], $config['mysql']['password']);
                //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance[$config['mysql']['dbname']] = $pdo;
            } catch(PDOException $e) {
                echo 'Connection failed: '.$e->getMessage()."\n";
            }
        }
        return self::$instance[$config['mysql']['dbname']];
    }

    public static function close($dbname) {
        self::$instance[$dbname] = null;
    }

    private function __construct() {

    }

    public static function getBulkInsert($table, Array $fields, Array $data, $replace = false, $quantity = 10000) {
        $query = array();
        $fields = static::arrayToValues($fields);
        $d = static::multipleUnshift($data, 0, count($data) <= $quantity ? count($data) : count($data) % $quantity);
        $data = $d['origin'];
        $query[] = static::insertMaker($table, $fields, $d['shifted'], $replace);
        while($data) {
            $d = static::multipleUnshift($data, 0, $quantity);
            $data = $d['origin'];
            $query[] = static::insertMaker($table, $fields, $d['shifted'], $replace);
        }
        return $query;
    }

    public static function getBulkUpdate($q, Array $data, $quantity = 3000) {
        $query = array();
        $d = static::multipleUnshift($data, 0, count($data) <= $quantity ? count($data) : count($data) % $quantity);
        $data = $d['origin'];
        $query[] = sprintf($q, static::arrayToValues($d['shifted']));
        while($data) {
            $d = static::multipleUnshift($data, 0, $quantity);
            $data = $d['origin'];
            $query[] = sprintf($q, static::array_to_values($d['shifted']));
        }
        return $query;
    }

    public static function multipleUnshift(Array $array, $from, $quantity) {
        $shifted = array_splice($array, $from, $quantity);
        return array("origin" => $array, "shifted" => $shifted);
    }

    private static function insertMaker($table, $fields, $data, $replace) {
        $query = $replace ? "REPLACE" : "INSERT";
        $query .= " INTO ".$table." ".$fields. " VALUES ";
        $values = [];
        foreach($data as $v) {
            $values[] = static::arrayToValues(array_map('json_encode', $v));
        }
        return $query. implode(", ", $values);
    }

    public static function arrayToValues($data) {
        $srt = "(".implode(", ", $data).")";
        return $srt;
    }
}