<?php

require_once(ROOT.'/model/modelRegistration.php');
class controllerRegistration
{
    public function actionNewUser()
    {
        // Реализую проверку данных введенных пользователем
        $errors = array();
        if(isset($_POST['signUp'])) { // Если нажата кнопка регистрации
            if (!preg_match('~[^\\s\\n]{3, 25}~', trim($_POST['login']))) {
                $errors[] = 'Поле логина заполнено некоректно';
            }
            if(!preg_match('~[^\\s\\n]{2,50}@\\w{1,20}\\.\\w{1,10}~', trim($_POST['email']))){
                $errors[] = "Поле email заполнено некоректно";
            }
            if(!preg_match('~.{6,}~s', $_POST['password'])){
                $errors[] = "Поле пароля заполнено некоректно";
            }
            if($_POST['password'] !== $_POST['repeat_password']){
                $errors[] = "Пароли не совпадают";
            }
            // Вывод ошибок
            if(!empty($errors)){
                echo "<div class='errors'>";
                foreach($errors as $value){
                    echo $value."<br/>";
                }
                echo "</div>";
                return false; // Уведомляем роутер что произошла ошибка.
            }
            // Если ошибок нету
            // Собираем данные с формы и регистрируем пользователя.
            else {
                $login = strtolower(trim($_POST['login']));
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = trim($_POST['email']);

                $master = (isset($_GET['ref']))? htmlspecialchars(trim($_GET['ref'])) : null;

                $connect = new modelRegistration();
                $result = $connect->actionNewUser($login, $password, $email, $master);
                if($result){
                    // Закрываем подключение к БД
                    $connect = null;
                    // Информация о реферале получается по GET запросу

                    $_SESSION['user'] = $login;
                    $_SESSION['ref'] = (!is_null($master))? true : false;
                    $_SESSION['ref_per'] = ($_SESSION['ref'])? 5 : 0;
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
                    // Тут переадресовываем на страничку пользователя.
                    // Нужно указывать абсолютный путь вмете с протоколом.
                    header('Location: http://'.$_SERVER['HTTP_HOST'].'/user_'.$login.'/');
                    // Уведомляем роутер что регистрация прошла успешно.
                    return true;
                }
                else {
                    $connect = null;
                    // И тут выводим страницу ошибки.
                    require_once(ROOT.'/view/Error.php');
                    // Уведомляем роутер что произошла ошибка
                    return false;
                }
            }
        }
        else {
            // Ошибка кнопка не нажата.
            return false;
        }
    }
    public function actionForm()
    {
        require_once(ROOT.'/view/Registration.php');
        return true;
    }
}