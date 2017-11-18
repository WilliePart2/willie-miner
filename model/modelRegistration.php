<?php

class modelRegistration
{
    private $db = array();
    public function __construct()
    {
        $this->db['connection'] = Db::dbConnection();
    }
    public function actionNewUser($login, $password)
    {
        // Нужно заключить это все в блоки try - catch

        // Проверяем есть ли такой пользователь.
        try {
            $this->db['check'] = $this->db['connection']->prepare('SELECT id FROM users WHERE login = :login');
            $this->db['check']->bindParam(':login', $login, PDO::PARAM_STR);
            // Достаем данные из того же PDOStatement для которого вызывался execute()
            $this->db['check']->execute();
        }
        catch(PDOException $error){
            echo "Ошибка при проверке дублирования пользователей: ".$error->getMessage()."<br/>";
        }
        // Если такого пользователя нету в базе
        if($this->db['check']->fetch() == 0){
            // Создаем пользователя в первичной таблице
            try {
                $this->db['first_reg'] = $this->db['connection']->prepare('INSERT INTO users (login, password) VALUES (:login, :password);');
                $this->db['first_reg']->bindValue(':login', $login, PDO::PARAM_STR);
                $this->db['first_reg']->bindValue(':password', $password, PDO::PARAM_STR);
                $this->db['first_reg']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при первичной проверке: ".$error->getMessage()."<br/>";
            }

            // Создаем индифидуальную таблицу пользователя
            try {
                $this->db['second_reg'] = $this->db['connection']->query('CREATE TABLE '.$login.' ('
                    . 'id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
                    . 'date DATE NULL,'
                    . 'crypt_count INT(20) NOT NULL DEFAULT "0",'
                    . 'referrals TEXT NULL,'
                    . 'register_date DATE NULL'
                    . ');');
//                $this->db['second_reg']->bindValue(':login', $login, PDO::PARAM_STR);
//                $this->db['result_second_reg'] = $this->db['second_reg']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при создании пользователя(шаг 1): ".$error->getMessage()."<br/>";
            }

            try{
                // Зполнение таблицы пользователя.
                $this->db['insert'] = $this->db['connection']->query('INSERT INTO '.$login
                .'(date, crypt_count, register_date)'
                    .'VALUES (NOW(), 0, NOW());');
//                $this->db['insert']->bindValue(':login', $login);
//                $this->db['insert']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при создании пользователя(шаг 2): ".$error->getMessage()."<br/>";
            }
            return true; // Подтверждаем что пользователя зарегистрирован
        }
        else {
            return false; // Такой пользователь уже есть в системе.
        }
    }
    public function __destruct()
    {
        $this->db = null;
    }
}