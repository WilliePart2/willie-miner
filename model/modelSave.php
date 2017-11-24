<?php

class modelSave
{
    private $db = array();
    public function connect()
    {
        $this->db['connect'] = Db::dbConnection();
    }
    public function actionSave($data, $user)
    {
        if(!isset($this->db['query'])) {
            try {
                $this->db['query'] = $this->db['connect']->prepare("INSERT INTO $user (`crypt_count`) VALUES (:data)");
                $this->db['query']->bindValue(':data', $data);
                $this->db['result'] = $this->db['query']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка на этапе сохранения пользовательских хэшэй".$error->getMessage();
            }
            if ($this->db['result'] != false) {
                return true;
            }
            else{
                return false;
            }
        }
        else {
            try {
                $this->db['query']->bindValue(':data', $data);
                $this->db['result'] = $this->db['query']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при использовании подготовленого запроса: ">$error->getMessage();
            }
            if($this->db['result'] != false){
                return true;
            }
            else {
                return false;
            }
        }
    }
    public function __destruct()
    {
        $this->db = null;
    }
}