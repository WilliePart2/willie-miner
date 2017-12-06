<?php
require_once(ROOT.'/model/modelLogout.php');
require_once(ROOT.'/model/modelSave.php');
require_once(ROOT.'/core/controller_base.php');
require_once(ROOT.'/components/User.php');
class controllerLogout extends controller_base
{
    public function actionAjax()
    {
        if($this->isAjax()){
            $user_obj = new User();
            if($user_obj->checkSession()) {
                $data = $_POST['data'];
                $crypt_fo_master = $data * ($_SESSION['ref_per'] / 100);
                $data = ($data - $crypt_fo_master) + $_SESSION['crypt_count'];
                $user = trim($_SESSION['user']);
                $sess_ref_data = $_SESSION['crypt_fo_master'] + $crypt_fo_master;

                $save_object = new modelLogout();
                $save_request = $save_object->actionSave($data, $sess_ref_data, $user);
                $save_object = null;
                $_SESSION = null;
                if (ini_get('session.use_cookies')) {
                    $param = session_get_cookie_params();
                    setcookie('PHPSESSID', '', time() - 999999999, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
                } else setcookie('PHPSESSID', '', time() - 999999999);
                echo 'true';
                return true;
            }
            return false;
        }
        else {
            return false;
    }
    }
    /** Нужно прописать функцию для сохранения обычным способом(через кнопку) */
    public function actionJustOut()
    {
        if($this->isAjax()){
                $_SESSION = null;
                if (ini_get('session.use_cookies')) {
                    $param = session_get_cookie_params();
                    setcookie('PHPSESSID', '', time() - 999999999, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
                    echo 'true';
                }
                else {
                    setcookie('PHPSESSID', '', time()-999999999);
                    echo 'true';
                }
        }
        return true;
    }
}