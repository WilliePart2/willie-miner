<?php

require_once(ROOT.'/model/modelUser.php');
class controllerUser
{
    public function actionWorkspace()
    {
        session_start();
        if(isset($_COOKIE['PHPSESSID'])) {
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

            $request = new modelUser();
            $result = $request->getUser($user);
            if ($result !== false) {
                $request = null;
                require_once(ROOT . '/view/User.php');
                return true;
            } else {
                $request = null;
                return false;
            }
        }
    }
}