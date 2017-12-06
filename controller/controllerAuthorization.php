<?php

require_once(ROOT.'/model/modelAuthorization.php');
require_once(ROOT.'/core/controller_base.php');
require_once(ROOT.'/components/User.php');
class controllerAuthorization extends controller_base
{
    /**
     * Авторизируем пользователя.
     * Если авторизация не удалась возвращаем сообщеие и false.
    */
    public function actionUser()
    {
        if($this->isAjax()){
            $data = $this->getAjaxData();
            $login = strtolower(trim($data['login']));
            $password = $data['password'];

            $request = new modelAuthorization();
            $result = $request->userAuthorization($login, $password);
            if($result != false){
                $user = new User();
                $request = null;
                $user->setSession();
                $_SESSION['user'] = $login;
                echo "true";
                return true;
            }
            else {
                $request = null;
                echo "false";
                return false;
            }
        }
        else{
            $this->layout();
            return true;
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
        $error_log = array();
        if(isset($_COOKIE['PHPSESSID'])){
            session_start();
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