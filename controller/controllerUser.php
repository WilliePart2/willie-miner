<?php

require_once(ROOT.'/model/modelUser.php');
class controllerUser
{
    public function actionWorkspace($user)
    {
        // Получаем адресс файл из куков и сравниваем логины
        $filename = $_COOKIE[$user] or die('Несанкционированая попытка доступа');
        $file = fopen($filename, 'rt');
        flock($file, LOCK_SH);
        $login = fread($file, 100);
        flock($file, LOCK_UN);
        fclose($file);
        if($login !== $user){return false;}

        $request = new modelUser();
        $result = $request->getUser($user);
        if($result !== false){
            $request = null;
            require_once(ROOT.'/view/User.php');
            return true;
        }
        else {
            $request = null;
            return false;
        }
    }
}