<?php

class modelAuthorization
{
    private $db = array();
    public function userAuthorization($login, $password)
    {
        // Устанавливаем соединение с БД
        try {
            $this->db['connection'] = Db::dbConnection();
            $this->db['query'] = $this->db['connection']->prepare('SELECT password FROM users WHERE login = :login');
            $this->db['query']->bindValue(':login', $login, PDO::PARAM_STR);
            $this->db['query']->execute();
            if (($user = $this->db['query']->fetch()) != 0) {
                // Проверяем соответствие пароля.
                $password_match = password_verify($password, $user['password']);
                if ($password_match) {
                    $this->db['master'] = $this->db['connection']->prepare('SELECT master, ref_per FROM  users WHERE login = :login');
                    $this->db['master']->bindValue(':login', $login, PDO::PARAM_STR);
                    $this->db['master']->execute();
                    $this->db['master']->setFetchMode(PDO::FETCH_ASSOC);
                    $this->db['result'] = $this->db['master']->fetch();
                    session_start();
                    $_SESSION['ref'] = (!empty($this->db['result']['master']))? true : false;
                    $_SESSION['ref_per'] = (!empty($this->db['result']['ref_per']))? $this->db['result']['ref_per'] : 0;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $error){
            echo "Ошибка поиска пользователя в базе даных".$error->getMessage()."<br/>";
        }


    }
    public function __destruct()
    {
        $this->db = null;
    }
}