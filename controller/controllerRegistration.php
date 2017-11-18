<?php

require_once(ROOT.'/model/modelRegistration.php');
class controllerRegistration
{
    public function actionNewUser()
    {
        // Реализую проверку данных введенных пользователем
        $errors = array();
        if(isset($_POST['signUp'])) { // Если нажата кнопка регистрации
            if (!preg_match('~[^\\s\\n]{4,}~', trim($_POST['login']))) {
                $errors[] = 'Поле логина заполнено некоректно';
            }
            if(!preg_match('~[^\\s\\n]{2,50}@\\w{1,20}\\.\\w{1,10}~', trim($_POST['email']))){
                $errors[] = "Поле email заполнено некоректно";
            }
            if(!preg_match('~[^\\s\\n]{6,}~', $_POST['password'])){
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
                $login = $_POST['login'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $connect = new modelRegistration();
                $result = $connect->actionNewUser($login, $password);
                if($result){
                    // Закрываем подключение к БД
                    $connect = null;
                    // Тут переадресовываем на страничку пользователя.
                    // Нужно указывать абсолютный путь вмете с протоколом.
                    header('Location: http://'.$_SERVER['HTTP_HOST'].'/user_'.$login.'/');
                    // Уведомляем роутер что регистрация прошла успешно.
                    return true;
                }
                else {
                    echo "выводим неудачную регистрацыю";
                    $connect = null;
                    // И тут выводим страницу ошибки.

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