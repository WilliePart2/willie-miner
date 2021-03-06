<?php

class modelRegistration
{
    private $db = array();
    public function __construct()
    {
        $this->db['connection'] = Db::dbConnection();
    }
    public function actionNewUser($login, $password, $email, $master)
    {
        $referrer = (!is_null($master))? $master : null;
        $persent_fo_master = 5;
        /**
         * Тут можно вставить блок кода с пользователями которые имеют повышеный реферальный процент.
        */
        session_start();
        $_SESSION['ref_per'] = $persent_fo_master;

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
        if(empty($this->db['check']->fetch())){
            // Создаем пользователя в первичной таблице
            try {
                $this->db['first_reg'] = $this->db['connection']->prepare('INSERT INTO users (login, password, email, master, ref_per, registration_date)'
                                                                                    .'VALUES (:login, :password, :email, :master, :persent, NOW());');
                $this->db['first_reg']->bindValue(':login', $login, PDO::PARAM_STR);
                $this->db['first_reg']->bindValue(':password', $password, PDO::PARAM_STR);
                $this->db['first_reg']->bindValue(':email', $email, PDO::PARAM_STR);
                $this->db['first_reg']->bindValue(':master', $referrer, PDO::PARAM_STR);
                $this->db['first_reg']->bindValue(':persent', $persent_fo_master, PDO::PARAM_INT);
                $this->db['first_reg']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при первичной проверке: ".$error->getMessage()."<br/>";
            }

            // Создаем индивидуальную таблицу пользователя
            try {
                $this->db['second_reg'] = $this->db['connection']->query('CREATE TABLE '.$login.' ('
                    . 'id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
                    . 'date DATE NULL,'
                    . 'crypt_count INT(15) NOT NULL DEFAULT "0",'
                    . 'master VARCHAR(25) NULL,'
                    . 'crypt_for_master INT(15) NULL'
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
                .'(date, crypt_count)'
                    .'VALUES (NOW(), 0);');
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