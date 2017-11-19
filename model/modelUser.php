<?php

class modelUser
{
    private $db = array();
    public function __construct()
    {
        $this->db['connection'] = Db::dbConnection();
    }
    public function getUser($user)
    {
        $this->db['request'] = $this->db['connection']->query('SELECT SUM(crypt_count) FROM '.$user);
        $this->db['request']->bindValue(':login', $user);
        $this->db['request']->execute();
        $result = $this->db['request']->fetch();
        return $result['SUM(crypt_count)'];
    }
    public function __destruct()
    {
        $this->db = null;
    }
}