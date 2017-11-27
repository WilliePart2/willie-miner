<?php

class modelStatistic
{
    public $db = array();
    public function __construct()
    {
        $this->db['connect'] = Db::dbConnection();
    }
    public function actionSelf($user)
    {
        $result = [];
        // Общее количество
        $this->db['query'] = $this->db['connect']->query('SELECT SUM(crypt_count) AS count FROM '.$user);
        if($this->db['query'] !== false){
            $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
            $result[] = $this->db['query']->fetch();
        }
        else return false;

        // Статистика за последние 7 дней.
        $this->db['query'] = $this->db['connect']->query('SELECT crypt_count FROM '.$user.' LIMIT 7');
        if($this->db['query'] !== false){
            foreach($this->db['query'] as $value){
                $result[] = $value;
            }
            return $result; // Возвращаем данные по self майнингу.
        }
        else return false;
    }
    public function actionStream($user)
    {
        $result = [];
        //  Выбираем общее количество смайненого
        $this->db['query'] = $this->db['connect']->prepare('SELECT SUM(currency_count) AS count FROM mining_stream WHERE added_user = :user;');
        $this->db['query']->bindValue(':user', $user. PDO::PARAM_STR);
        $this->db['result'] = $this->db['query']->execute();
        if($this->db['result'] !== false){
            $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
            $result[] = $this->db['query']->fetch();
        }
        else return false;
        // Выбираем общее смайненое в каждом потоке.
        $this->db['query'] = $this->db['connect']->prepare('SELECT stream_name, currency_count FROM mining_stream WHERE added_user = :user');
        $this->db['query']->bindValue(':user', $user, PDO::PARAM_STR);
        $this->db['result'] = $this->db['query']->execute();
        if($this->db['result'] !== false){
            $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
            foreach($this->db['query'] as $value){
                $result[] = $value;
            }
            return $result;
        }
        else return false;
    }
    public function actionReferral()
    {
        // Выбираем статистику по майнингу рефералов.
    }
    public function __destruct()
    {
        $this->db['connect'] = null;
    }
}