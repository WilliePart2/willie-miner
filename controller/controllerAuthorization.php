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
        // Тут нужно достать логин и пароль пользователя
        $login = $_POST['login'];
        $password = $_POST['password'];

        $request = new modelAuthorization();
        $result = $request->userAuthorization($login, $password);

        if($result){
            $request = null;
            // Если пользователь есть, устанавливаем куки и создаем временный файл
            $user_file = tempnam(ROOT.'/tmp/', uniqid($login));
            // Записывам в временный файл логин пользователя для дальнейшего доступа к БД.
            $file = fopen($user_file, 'r+t');
            flock($file, LOCK_EX);
            fwrite($file, $login);
            flock($file, LOCK_UN);
            fclose($file);
            // Куки нужно будет продолжать
            setcookie($login, $user_file, time()+60*60, '/', $_SERVER['HTTP_HOST'], false, true);
            // Установить куки и передать туда имя файла.
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/user_'.$login.'/');
            return true;
        }
        else {
            return false;
        }

    }
    /**
     * Этот метод просто выводит форму авторизации и все.
    */
    public function actionForm()
    {
        require_once(ROOT.'/view/Authorization.php');
        return true;
    }
}