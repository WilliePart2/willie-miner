<?php

class modelLogout
{
    private $db = array();
    public function __construct(){
        try {
            $this->db['connect'] = Db::dbConnection();
        } catch(PDOException $error){
            echo "Ошибка при подключении к БД: ".$error->getMessage();
        }
    }
    /**
     * Дабавить проверку не сохранялся ли сегодня пользователь
     * Реализовать сохранение хэшэй для мастера.
    */
    public function actionSave($data, $ref_data, $user)
    {
        // Запрос проверка
        try {
            $this->db['first_query'] = $this->db['connect']->query("SELECT * FROM $user WHERE date = CURDATE();");
        } catch(PDoException $error){
            echo "Ошибка на этапе проверки наличия записи: ".$error->getMessage();
        }
        if ($this->db['first_query'] == false) {
            /** Запрос если данные еще не вносились */
            try {
                $this->db['new_line'] = $this->db['connect']->prepare("INSERT INTO $user (`crypt_count`, `crypt_for_master`, date)"
                    . " VALUES (:crypt, :crypt_fo_master, CURDATE());");
                $this->db['new_line']->bindValue(':crypt', $data, PDO::PARAM_INT);
                $this->db['new_line']->bindValue(':crypt_for_master', $ref_data, PDO::PARAM_INT);
                $this->db['result'] = $this->db['new_line']->execute();
            } catch(PDOException $error){
                echo "Ошибка на этапе внесения первой записи в дате: ".$error->getMessage();
            }
        } else {
            /** Запрос если данные уже были сегодня внесены */
            try {
                $this->db['insert'] = $this->db['connect']->prepare("UPDATE $user SET crypt_count = :crypt, crypt_for_master = :crypt_fo_master"
                    . " WHERE date = CURDATE();");
                $this->db['insert']->bindValue(':crypt', $data, PDO::PARAM_INT);
                $this->db['insert']->bindValue(':crypt_for_master', $ref_data, PDO::PARAM_INT);
                $this->db['result'] = $this->db['insert']->execute();
            } catch(PDOException $error){
                echo "Ошибка при обновлени записи: ".$error->getMessage();
            }
        }
        if ($this->db['result'] !== false) return true;
        else return false;
    }
    public function __destruct(){
        $this->db = null;
    }
}