<?php

class modelStream
{
    private $db = array();
    public function __construct()
    {
        try {
            $this->db['connect'] = Db::dbConnection();
        }
        catch(PDOException $error){
            echo 'Ошибка при подключнии к базе данных'.$error->getMessage();
        }
    }
    public function actionIndex($user)
    {
        $result = [];
        try {
            // Метод подтягивает информацию о киличестве потоков у пользоватея
            $this->db['query'] = $this->db['connect']->prepare('SELECT user_stream FROM users WHERE login = :login');
            $this->db['query']->bindValue(':login', $user, PDO::PARAM_STR);
            $this->db['query']->execute();
            $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
            $result[] = $this->db['query']->fetch();
        }
        catch(PDOException $error){
            echo 'Ошибка при получении количества потоков пользователя: '.$error->getMessage();
        }
        if(!empty($result)){ // Может лучше поставить проверку на 0?
            // Нужно обратиться к таблице потоков и выбрать из те которые принадлежат конкретному пользователю
            try{
                $this->db['list_streams'] = $this->db['connect']->prepare('SELECT * FROM mining_stream WHERE added_user = :login');
                $this->db['list_streams']->bindValue(':login', $user, PDO::PARAM_STR);
                $this->db['list_streams']->execute() or die('Ничего не шали в списке потов(странно...)');
                $this->db['list_streams']->setFetchMode(PDO::FETCH_ASSOC);
                foreach($this->db['list_streams'] as $line => $value){
                    $result[] = $value;
                }
            }
            catch(PDOException $error){
                echo "Ошибка при извелении пользовательских потоков: ".$error->getMessage();
            }
            return $result;
        }
        else {
            return false;
        }

        // + Выводит список потоков пользователя с общим количеством смайненых хэшэй\вылюты
    }
    public function actionAdd($user, $data)
    {
        try {
            // Добавляем +1 поток в таблицу юзера
            $this->db['add_stream'] = $this->db['connect']->prepare('UPDATE users SET user_stream = user_stream+1 WHERE login = :login');
            $this->db['add_stream']->bindValue(':login', $user, PDO::PARAM_STR);
            $this->db['result'] = $this->db['add_stream']->execute();
        }
        catch(PDOException $error){
            echo "Ошибка при увеличении счетчика потоков юзера: ">$error->getMessage();
        }
        if($this->db['result'] == true) {
            try {
                // Добавляем поток в общую таблицу.
                $this->db['add_to_mining_stream'] = $this->db['connect']->prepare('INSERT INTO mining_stream (added_user, stream_name, stream_addr, stream_currency, added_date)'
                    . 'VALUES(:login, :stream_name, :stream_addr, :stream_currency, CURDATE());');
                $this->db['add_to_mining_stream']->bindValue(':login', $user, PDO::PARAM_STR);
                $this->db['add_to_mining_stream']->bindValue(':stream_name', $data['stream_name'], PDO::PARAM_STR);
                $this->db['add_to_mining_stream']->bindValue(':stream_addr', $data['stream_addr'], PDO::PARAM_STR);
                $this->db['add_to_mining_stream']->bindValue(':stream_currency', $data['stream_currency'], PDO::PARAM_STR);
                $this->db['result'] = $this->db['add_to_mining_stream']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при добавлении потока в общую таблицу: ".$error->getMessage();
            }
            if($this->db['result'] !== false){
                return true;
            }
            else return false; // Странно будет если так произойдет.
        }


    }
    public function actionDelete($user, $stream_name, $stream_addr, $currency_type)
    {
        // Уменьшем счетчик количества потоков юзера.
        try{
            $this->db['query'] = $this->db['connect']->prepare('UPDATE users SET user_stream = user_stream-1 WHERE login = :login');
            $this->db['query']->bindValue(':login', $user, PDO::PARAM_STR);
            $this->db['result'] = $this->db['query']->execute();
        }
        catch(PDOException $error){
            echo "Ошибка на первом этапе удаления: ".$error->getMessage();
        }
        if($this->db['result'] !== false){
            // Удаляем поток из общей таблицы.
            try {
                $this->db['row_delete'] = $this->db['connect']->prepare('DELETE FROM mining_stream WHERE added_user = ? '
                    . 'AND stream_name = ? '
                    . 'AND stream_addr = ? '
                    . 'AND stream_currency = ?;');
                $this->db['row_delete']->bindValue('1', $user, PDO::PARAM_STR);
                $this->db['row_delete']->bindValue('2', $stream_name, PDO::PARAM_STR);
                $this->db['row_delete']->bindValue('3', $stream_addr, PDO::PARAM_STR);
                $this->db['row_delete']->bindValue('4', $currency_type, PDO::PARAM_STR);
                $this->db['result'] = $this->db['row_delete']->execute();
            }
            catch(PDOException $error){
                echo "Ошибка при удалении записи из таблицы: ".$error->getMessage();
            }
            if($this->db['result'] !== false) return true;
            else return false;
        }
        else return false;

        // Удаляем поток из общей таблицы.
    }
    public function __destruct()
    {
        $this->db = null;
    }
}