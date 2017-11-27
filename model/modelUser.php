<?php

class modelUser
{
    private $db = array();
    public function __construct()
    {
        try {
            $this->db['connection'] = Db::dbConnection();
        } catch(PDOException $error){
            echo "Ошибка при подключении к БД: ".$error->getMessage();
        }
    }
    public function getUser($user)
    {
        try {
            $this->db['request'] = $this->db['connection']->query('SELECT SUM(crypt_count) FROM ' . $user);
            $result = $this->db['request']->fetch();
            return $result['SUM(crypt_count)'];
        } catch(PDOException $error){
            echo "Ошибка при получении данных пользователя: ".$error->getMessage();
        }
    }
    public function __destruct()
    {
        $this->db = null;
    }
}