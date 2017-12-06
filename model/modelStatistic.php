<?php

class modelStatistic
{
    public $db = array();
    public function __construct()
    {
        try {
            $this->db['connect'] = Db::dbConnection();
        } catch(PDOException $error){
            echo "Ошибка соединения с БД: ".$error->getMessage();
        }
    }
    /**
     * Метод возвращает статистику по self майнингу.
    */
    public function actionSelf($user)
    {
        $result = [];
        try {
            $this->db['query'] = $this->db['connect']->query('SELECT SUM(crypt_count) AS count FROM ' . $user);
            if ($this->db['query'] !== false) {
                $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
                $result[] = $this->db['query']->fetch();
            } else return false;
        } catch(PDOException $error){
            echo "Ошибка при получении общего количества хэшэй юзера: ".$error->getMessage();
        }

        try {
            $this->db['query'] = $this->db['connect']->query('SELECT crypt_count, date FROM ' . $user . ' LIMIT 7');
            if ($this->db['query'] !== false) {
                foreach ($this->db['query'] as $key => $value) {
                    $result[] = $value;
                }
                return $result; // Возвращаем данные по self майнингу.
            } else return false;
        } catch (PDOException $error){
            echo "Ошибка при получении статистики self за неделю: ".$error->getMessage();
        }
    }
    /**
     * Метод возвращает статистику по майнингу из потоков
    */
    public function actionStream($user)
    {
        $result = [];
        //  Выбираем общее количество смайненого
        try {
            $this->db['query'] = $this->db['connect']->prepare('SELECT SUM(currency_count) AS count, COUNT(currency_count) as stream_count FROM mining_stream WHERE added_user = :user;');
            $this->db['query']->bindValue(':user', $user , PDO::PARAM_STR);
            $this->db['result'] = $this->db['query']->execute();
            if ($this->db['result'] !== false) {
                $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
                $result[] = $this->db['query']->fetch();
            } else return false;
        } catch(PDOException $error){
            echo "Ошибка получения общей статистики stream майнинга: ".$error->getMessage();
        }
        // Выбираем общее смайненое в каждом потоке.
        try {
            $this->db['query'] = $this->db['connect']->prepare('SELECT stream_name, currency_count FROM mining_stream WHERE added_user = :user');
            $this->db['query']->bindValue(':user', $user, PDO::PARAM_STR);
            $this->db['result'] = $this->db['query']->execute();
            if ($this->db['result'] !== false) {
                $this->db['query']->setFetchMode(PDO::FETCH_ASSOC);
                foreach ($this->db['query'] as $value) {
                    $result[] = $value;
                }
                return $result;
            } else return false;
        } catch(PDOException $error){
            echo "Ошибка при получении данных о майнинга на каждом из потоков: ".$error->getMessage();
        }
    }
    public function actionReferral($user)
    {
        $result = [];
        // Выбираем общее количество рефералов.
        try {
            $this->db['ref_count'] = $this->db['connect']->prepare('SELECT ref_count FROM users WHERE login = :login');
            $this->db['ref_count']->bindValue(':login', $user, PDO::PARAM_STR);
            $this->db['ref_count']->execute();
            $result[] = $this->db['ref_count']->fetch()['ref_count'];
        } catch(PDOException $error){
            echo "Ошибка при получении общего количества рефералов пользователя: ".$error->getMessage();
        }
        if($result[0] != false){
            // Выбираем всех пользователей у которых мастер этот юзер.
            $this->db['referals'] = $this->db['connect']->prepare('SELECT login FROM users WHERE login = :user');
            $this->db['referals']->bindValue(':user', $user, PDO::PARAM_STR);
            $this->db['referals']->execute();
            // Обходим всех этих пользователей и собираем общее количество нафармленого ими в общий масив.
            $crypt_sum = [];
            foreach($this->db['referals'] as $user){
                $this->db['all_crypt_count'] = $this->db['connect']->query("SELECT SUM(crypt_for_master) AS count FROM $user;");
                $result[$user] = $crypt_sum['count'] += $this->db['all_crypt_count']->fetch()['count'];
            }
            $result[] = $crypt_sum['count'];
            return $result;
        }

    }
    public function __destruct()
    {
        $this->db['connect'] = null;
    }
}