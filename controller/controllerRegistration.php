<?php

require_once(ROOT . '/model/modelRegistration.php');
require_once(ROOT . '/core/controller_base.php');
require_once(ROOT . '/components/User.php');

class controllerRegistration extends controller_base
{
    public function actionNewUser()
    {
        if ($this->isAjax()) {
            $data = $this->getAjaxData();
//            echo "<pre>";
//            var_dump($data);
//            echo "</pre>";
            // Реализую проверку данных введенных пользователем
            $errors = array();
            if (!preg_match('~[^\\s\\n]{3,25}~isx', $data['login'])) {
                $errors[] = 'Поле логина заполнено некоректно';
            }
            if (!preg_match('~[^\\s\\n]{2,50}@\\w{1,20}\\.\\w{1,10}~', trim($data['email']))) {
                $errors[] = "Поле email заполнено некоректно";
            }
            if (!preg_match('~.{6,}~s', $data['password'])) {
                $errors[] = "Поле пароля заполнено некоректно";
            }
            if ($data['password'] !== $data['password_repeat']) {
                $errors[] = "Пароли не совпадают";
            }
            // Вывод ошибок
            if (!empty($errors)) {
                echo json_encode($errors);
                return false; // Уведомляем роутер что произошла ошибка.
            }
            // Если ошибок нету
            // Собираем данные с формы и регистрируем пользователя.
            else {
                $login = strtolower(trim($data['login']));
                $password = password_hash($data['password'], PASSWORD_DEFAULT);
                $email = trim($data['email']);

                // Доработаю реферальную систему
                $master = (isset($data['ref'])) ? htmlspecialchars(trim($data['ref'])) : null;

                $connect = new modelRegistration();
                $result = $connect->actionNewUser($login, $password, $email, $master);
                if ($result) {
                    // Закрываем подключение к БД
                    $connect = null;

                    $user_obj = new User();
                    $user_obj->setSession();
                    $_SESSION['user'] = $login;
                    $_SESSION['ref'] = (!is_null($master)) ? true : false;
                    $_SESSION['ref_per'] = ($_SESSION['ref']) ? 5 : 0;

                    echo "true";
                    return true;
                } else {
                    $connect = null;
                    // И тут выводим страницу ошибки.
                    echo "false";
                    // Уведомляем роутер что произошла ошибка
                    return false;
                }
            }
        } else {
            $this->layout();
            return true;
        }
    }
}