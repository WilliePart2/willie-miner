<?php

class User
{
    // Установка куков
    public function setSession()
    {
        @session_start();
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        }
        if(isset($_SERVER['REMOTE_ADDR'])){
            $_SESSION['remoteAddress'] = $_SERVER['REMOTE_ADDR'];
        }
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $_SESSION['forwarded'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if(isset($_SERVER['HTTP_X_REAL_IP'])){
            $_SESSION['ip'] = $_SERVER['HTTP_X_REAL_IP'];
        }
        $_SESSION['time'] = time();
    }

    // Удаление сесии
    public function removeSession(){
        if($_COOKIE[session_name()]){
            @session_start();
            $_SESSION = NULL;
            setcookie(session_name(), '', time()-999999999);
            return true;
        }
        else {
            return true;
        }
    }

    // Проверка куков
    public function checkSession()
    {
        if(isset($_COOKIE[session_name()])){
            @session_start();
            $errors = array();
            if(isset($_SESSION['userAgent']) && $_SESSION['userAgent'] !== $_SERVER['HTTP_USER_AGENT']) array_push($errors, '+');
            if(isset($_SESSION['remoteAddress']) && $_SESSION['remoteAddress'] !== $_SERVER['REMOTE_ADDR']) array_push($errors, '+');
            if(isset($_SESSION['forwarded']) && $_SESSION['forwarded'] !== $_SERVER['HTTP_X_FORWARDED_FOR']) array_push($errors, '+');
            if(isset($_SESSION['ip']) && $_SESSION['id'] !== $_SERVER['HTTP_X_REAL_IP']) array_push($errors, '+');
            if(empty($errors)) {
//                $this->regenerateSession();
                return true;
            }
            else return false;
        }
        else{
            return false;
        }
    }
    // Обновление куков или выброс пользователя(наверное не стоит)
    public function regenerateSession()
    {
        if(isset($_COOKIE[session_name()])){
            @session_start();
            if(isset($_SESSION['time']) && (time() - $_SESSION['time']) < 600){
                session_commit();
                $id = session_create_id();
                session_start();
                session_id($id);
            }
        }
    }
}