<?php

class Db
{
    public static function dbConnection()
    {
        try {
            $params = ROOT . '/config/db_configuration.php';
            $params = require_once($params);
            $dns = "mysql: host={$params['host']}; dbname={$params['dbname']}";
            $pdo = new PDO($dns, $params['user'], $params['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('set names utf8');
            return $pdo;
        } catch (PDOException $error){
            echo "Ошибка подключения к БД: ".$error->getMessage();
        }
    }
}