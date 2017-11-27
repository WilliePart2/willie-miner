<?php

/**
 * Неиспользуемая модель.
 * Возможно будет использоваться серверным демоном.
*/
class modelSave
{
    private $db = array();
    public function connect()
    {
        try {
            $this->db['connect'] = Db::dbConnection();
        } catch(PDOException $error){
            echo "Ошибка соединения с БД: ".$error->getMessage();
        }
    }
    public function actionSave($data, $ref_data, $user)
    {
        if(!isset($this->db['query'])) {
            try {
                $this->db['query'] = $this->db['connect']->prepare("INSERT INTO $user (`crypt_count`, `crypt_fo_master`) VALUES (:data, :ref_data)");
                $this->db['query']->bindValue(':data', $data, PDO::PARAM_INT);
                $this->db['query']->bindValue(':ref_data', $ref_data, PDO::PARAM_INT);
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
                $this->db['query']->bindValue(':ref_data', $ref_data, PDO::PARAM_INT);
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