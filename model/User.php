<?php

class User
{
    public static function userAuthorization()
    {
        $login = $_POST['login'];
        $password = md5($_POST['password']);
        $db = Db::dbConnection();
        // Исиправить на подготовленый запросс
        $result = $db->query('SELECT * FROM users WHERE login='.$login);
        if($result === false){return false;} // Если пользователь не найден
        $result = $result->fetch();
        // Поставить особую проверку на админа
        if($result != false) {
            if($result['password'] === $password){
                $user = $db->query('SELECT * FROM '.$login.'ORDER BY date LIMIT 10');

                $user_info = array(
                    "login" => $login
                );
                $i = 0;
                while($info = $user->fetch()) {
                    $user_info[$i]['id'] = $info['id'];
                    $user_info[$i]['date'] = $info['date'];
                    $user_info[$i]['crypt_count'] = $info['crypt_count'];
                    $user_info[$i]['referrals'] = $info['referrals'];
                    $user_info[$i]['register_date'];
                    $i++;
                }
                // Проверить что возвращается.
                return $info;
            }
            else {
                die("неверный логин или пароль."); // Заглушка
            }
        }
        else {
            return false;
        }
    }
    public static function userRegistration()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $db = Db::dbConnection();
        echo $db;
        $db->query('CREATE TABLE '.$login.'('
            .'id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,'
            .'date DATETIME NULL' // Сюда записываются даты когда пользователь активен
            .'crypt_count INT NULL,'
            .'referrals TEXT NULL,'
            .'refer_count INT NULL'
            .'register_date DATETIME NOT NULL' // Установить.
        .');');
        // Занесем данные в таблицу users
        $db->query('INSERT INTO users (login,password) VALUES ('.$login.','.$password.')');
        // Установим значения созданой таблице
        $db->query('INSERT INTO'.$login.'(date, crypt_count,register_date,refer_count'
            .'VALUES ('
                .'NOW(),'
                .'0'
                .'NOW()'
                .'0'
            .')'
        );
        return true;
    }
}