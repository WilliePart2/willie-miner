<?php

class controllerSave
{
    public function actionIndex()
    {
        session_start();
        if(isset($_COOKIE['PHPSESSID'])){
            $error_log = array();
            if(isset($_SESSION['userAgent']) && $_SESSION['userAgent'] !== $_SERVER['HTTP_USER_AGENT']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['remoteAddress']) && $_SESSION['remoteAddress'] !== $_SERVER['REMOTE_ADDR']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['forwarded']) && $_SESSION['forwarded'] !== $_SERVER['HTTP_X_FORWARDED_FOR']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['ip']) && $_SESSION['ip'] !== $_SERVER['HTTP_X_REAL_IP']){
                array_push($error_log, "+");
            }
            if(empty($error_log)){
                $user = $_SESSION['user'];
            }
            else{
                return false;
            }
        }
        else { return false;}
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            $data = is_numeric($_POST['data'])? intval($_POST['data']): die('Пришедшые даные не являются числовыми');
            $ref_data = (isset($_SESSION['ref']))? $data*(($_SESSION['ref_per'])/100) : 0;
            $data = $data - $ref_data;

            $_SESSION['crypt_fo_master'] += $ref_data;
            $_SESSION['crypt_count'] += $data;
        }
        else return false;
    }
}