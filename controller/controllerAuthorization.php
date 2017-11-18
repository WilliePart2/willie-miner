<?php

require_once(ROOT.'/model/User.php');
define('HOST',$_SERVER['HTTP_HOST']);
class controllerAuthorization
{
    /**
     * Авторизируем пользователя.
     * Если авторизация не удалась возвращаем сообщеие и false.
    */
    public function actionUser()
    {
        $request = User::userAuthorization();
        if($request === false){
            echo "Пользователь не найден<br>"; // Сделать вывод через View
            return false;
        }
        else {
            header(HOST.'/user_'.$_POST['login'].'/');
            // Нужно поставить return иначе Router будет дальше перебирать масив route
        }
    }
    private function actionRegisterUser()
    {
        $request = User::userRegistration();
        if($request){
            header(HOST.'user_'.$_POST['login'].'/');
        }
    }
}