<?php

require_once(ROOT.'/model/modelAuthorization.php');
class controllerAuthorization
{
    /**
     * Авторизируем пользователя.
     * Если авторизация не удалась возвращаем сообщеие и false.
    */
    public function actionUser()
    {
        $login = strtolower(trim($_POST['login']));
        $password = $_POST['password'];

        $request = new modelAuthorization();
        $result = $request->userAuthorization($login, $password);

        if($result){
            $request = null;
            session_start();
            $_SESSION['user'] = $login;
            if(isset($_SERVER['HTTP_USER_AGENT'])) {
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            }
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $_SESSION['remoteAddress'] = $_SERVER['REMOTE_ADDR'];
            }
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $_SESSION['forwarded'] = $_SERVER['HTTP_X_FORWARDER_FOR'];
            }
            if(isset($_SERVER['HTTP_X_REAL_IP'])) {
                $_SESSION['ip'] = $_SERVER['HTTP_X_REAL_IP'];
            }

            header('Location: http://'.$_SERVER['HTTP_HOST'].'/user_'.$login.'/');
            return true;
        }
        else {
            $request = null;
            return false;
        }

    }
    /**
     * Этот метод просто выводит форму авторизации и все.
    */
    public function actionForm()
    {
        /**
         * Доработать сесию и добавить поддержку сесии в файл User.php(view)
        */
        session_start();
        $error_log = array();
        if(isset($_COOKIE['PHPSESSID'])){
            if(isset($_SESSION['remoteAddress']) && $_SERVER['REMOTE_ADDR'] !== $_SESSION['remoteAddress']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['userAgent']) && $_SERVER['HTTP_USER_AGENT'] !== $_SESSION['userAgent']){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['forwarded']) && ($_SERVER['HTTP_X_FORWARDED_FOR'] !== $_SESSION['forwarded'])){
                array_push($error_log, '+');
            }
            if(isset($_SESSION['ip']) && ($_SERVER['HTTP_X_REAL_IP'] !== $_SESSION['ip'])){
                array_push($error_log, '+');
            }
            if(empty($error_log)){
                header('Location: http://'.$_SERVER['HTTP_HOST'].'/user_'.$_SESSION['user'].'/');
                return true;
            }
        }
        require_once(ROOT.'/view/Authorization.php');
        return true;
    }
}