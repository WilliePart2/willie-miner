<?php

require_once(ROOT.'/model/modelStream.php');
class controllerStream
{
    public function actionIndex()
    {
        session_start();
        /**
         * Поставить защиту от взлома сесии!
        */
        if($_COOKIE['PHPSESSID']){
            $error_log = array();
            if(isset($_SESSION['userAgent']) && $_SERVER['HTTP_USER_AGENT'] !== $_SESSION['userAgent']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['remoteAddress']) && $_SERVER['REMOTE_ADDR'] !== $_SESSION['remoteAddress']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['forwarded']) && $_SERVER['HTTP_X_FORWARDED_FOR'] !== $_SESSION['forwarded']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['ip']) && $_SERVER['HTTP_X_REAL_IP'] !== $_SESSION['ip']){
                array_push($error_log, '+');
            }

            if(empty($error_log)){
                $user = $_SESSION['user'];
            }
            else {
                echo 'Ошибка при проверки сесии, возможна компроментация';
                return false;
            }
        }
        else return false;

        // Подтягиваем информацию о потоках пользоватея.
        $request_obj = new modelStream();
        $query = $request_obj->actionIndex(trim($user));
        $request_obj = null;
        // Выдаем view каналов пользователя.
        require_once(ROOT.'/view/Streams.php');
        return true;
    }
    public function actionAddStreamAjax()
    {
        session_start();
        if($_COOKIE['PHPSESSID']){
            $error_log = array();
            if(isset($_SESSION['userAgent']) && $_SERVER['HTTP_USER_AGENT'] !== $_SESSION['userAgent']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['remoteAddress']) && $_SERVER['REMOTE_ADDR'] !== $_SESSION['remoteAddress']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['forwarded']) && $_SERVER['HTTP_X_FORWARDED_FOR'] !== $_SESSION['forwarded']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['ip']) && $_SERVER['HTTP_X_REAL_IP'] !== $_SESSION['ip']){
                array_push($error_log, '+');
            }

            if(empty($error_log)){
                $user = trim($_SESSION['user']);
            }
            else {
                return false;
            }
        }

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            $_POST = json_decode(file_get_contents('php://input'), true);
            // Ставить сюда проверку или нет?
            $data['stream_name'] = trim($_POST['stream_name']);
            $data['stream_addr'] = (isset($_POST['stream_addr']))? trim($_POST['stream_addr']) : 'none';
            $data['stream_currency'] = trim($_POST['stream_currency']);
        }
        else{
            return false;
        }
        // Метод добавляет новый канал от пользователя
        $request_obj = new modelStream();
        $query = $request_obj->actionAdd($user, $data);
        if($query === false){
            echo 'false';
            return false;
        }
        else {
            echo 'true';
            return false;
        }

        // Запись в общую таблицу каналов

        // Создание таблицы со статистикой канала
//        return true; // ВРЕМЕННО!
    }
    public function actionDeleteAjax()
    {
        session_start();
        if($_COOKIE['PHPSESSID']){
            $error_log = array();
            if(isset($_SESSION['userAgent']) && $_SERVER['HTTP_USER_AGENT'] !== $_SESSION['userAgent']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['remoteAddress']) && $_SERVER['REMOTE_ADDR'] !== $_SESSION['remoteAddress']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['forwarded']) && $_SERVER['HTTP_X_FORWARDED_FOR'] !== $_SESSION['forwarded']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['ip']) && $_SERVER['HTTP_X_REAL_IP'] !== $_SESSION['ip']){
                array_push($error_log, '+');
            }

            if(empty($error_log)){
                $user = trim($_SESSION['user']);
            }
            else {
                return false;
            }
        }
        else return false;
        // Метод удаляет пользовательский поток
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            $data = json_decode(urldecode($_POST['data']), true);
            $stream_name = trim($data['stream_name']);
            $stream_addr = (preg_match('~^none$~', trim($data['stream_addr'])))? 'none' : trim($data['stream_addr']);
            $stream_currency = trim($data['stream_currency_type']);
            $currency_count = trim($data['currency_count']);

            $request_obj = new modelStream();
            $request = $request_obj->actionDelete($user, $stream_name, $stream_addr, $stream_currency, $currency_count);
            if($request === true){
                echo "true";
                $request_obj = null;
                return true;
            }
            else {
                echo "false";
                $request_obj = null;
                return false;
            }
        }
        else return false;
    }
}