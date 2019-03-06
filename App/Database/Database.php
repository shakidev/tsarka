<?php namespace App\Database;
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 12:44 PM
 */
use PDO;

class Database
{

    protected $connection;

    public function __construct()
    {
        $dsn = implode(';',
        [
            "mysql:host={$_ENV['DATABASE_HOST']}",
            "port={$_ENV['DATABASE_PORT']}",
            "dbname={$_ENV['DATABASE_NAME']}",
            "charset={$_ENV['DATABASE_CHARSET']}"
        ]);

        $this->connection = new \PDO($dsn, $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD'], [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $this->connection->exec("SET NAMES `{$_ENV['DATABASE_CHARSET']}`");
    }


    public function query($query,$values,$all = true)
    {
        $_query = $this->execute($query,$values);
        return $all ? $_query->fetchAll() : $_query->fetch();
    }

    protected function execute($query,$values){
        $_query = $this->connection->prepare($query);
        $_query->execute($values);
        return $_query;
    }


}