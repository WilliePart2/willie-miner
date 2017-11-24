<?php

class modelLogout
{
    private $db = array();
    public function __construct(){
        $this->db['connect'] = Db::dbConnection();
    }
    public function actionSave($data, $user){
        $this->db['query'] = $this->db['connect']->query('INSERT INTO '.trim($user).' (date, crypt_count) VALUES (NOW(), '.$data.');');
        if($this->db['query'] != false){
            return true;
        }
        else {
            return false;
        }
    }
    public function __destruct(){
        $this->db = null;
    }
}