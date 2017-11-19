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

        // Если пользователь существует устанавливаем ему куки + создаем временный файл с его сесией.
            // В этот временный файл можно будет забивать параметры.(login)
    }
    public function __destruct()
    {
        $this->db = null;
    }
}