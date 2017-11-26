<?php

class modelStatistic
{
    public $db = array();
    public function __construct()
    {
        $this->db['connect'] = Db::dbConnection();
    }
    public function actionSelf()
    {
        // Выбираем из базы статистику по self майнингу.
    }
    public function actionStream()
    {
        //  Выбираем из базы статистику по майнингу из потоков.
    }
    public function actionReferal()
    {
        // Выбираем статистику по майнингу рефералов.
    }
    public function __destruct()
    {
        $this->db['connect'] = null;
    }
}