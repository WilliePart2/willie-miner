<?php
require_once(ROOT.'/model/modelLogout.php');
require_once(ROOT.'/model/modelSave.php');
class controllerLogout
{
    public function actionAjax()
    {
        session_start();
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            $data = intval($_POST['data']);
            $user = trim($_SESSION['user']);
            $sess_data = $_SESSION['crypt_count'];
            $sess_ref_data = $_SESSION['crypt_fo_master'];
            // Нужно выполнить закпрос к базе данных на сохранение.


            $save_object = new modelLogout();
            $save_request = $save_object->actionSave($data, $sess_data, $sess_ref_data, $user);
            if($save_request){
                $save_object = null;
                // Финальные действия сохранения.
                setcookie('PHPSESSID', '', time()-999999999);
//                header('Location: http://'.$_SERVER['HTTP_HOST']);
//                require_once(ROOT.'/view/Index.php');
                echo 'http://'.$_SERVER['HTTP_HOST']; // Может тут лучше возвращать булево значение?
                return true;
            }
            else {
                $save_object = null;
                header('Location: http://'.$_SERVER['HTTP_HOST'].'error/');
                return false;
            }
        }
        else {
           // Перенаправление на страцицу ошибки.
    }
    }
}