<?php

class modelLogout
{
    private $db = array();
    public function __construct(){
        $this->db['connect'] = Db::dbConnection();
    }
    /**
     * Дабавить проверку не сохранялся ли сегодня пользователь
     * Реализовать сохранение хэшэй для мастера.
    */
    public function actionSave($data, $sess_data, $ref_data, $user){
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