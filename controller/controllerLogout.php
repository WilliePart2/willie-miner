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
            $crypt_fo_master = $data * ($_SESSION['ref_per']/100);
            $data = ($data - $crypt_fo_master) + $_SESSION['crypt_count'];
            $user = trim($_SESSION['user']);
            $sess_ref_data = $_SESSION['crypt_fo_master'] + $crypt_fo_master;

            $save_object = new modelLogout();
            $save_request = $save_object->actionSave($data, $sess_ref_data, $user);
            if($save_request){
                $save_object = null;
                // Финальные действия сохранения.
                $_SESSION = null;
                if(ini_get('session.use_cookies')) {
                    $param = session_get_cookie_params();
                    setcookie('PHPSESSID', '', time() - 999999999, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
                }
                else setcookie('PHPSESSID', '', time()-999999999);
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
            return false;
    }
    }
    /** Нужно прописать функцию для сохранения обычным способом(через кнопку) */
    public function actionJustOut()
    {
        ob_start();
        echo"<pre>";
        var_dump($_GET);
        echo"</pre>";
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            if(boolval($_GET['out'])) {
                ob_start();
                echo "удаляем сеисю";
                $_SESSION = null;
                if (ini_get('session.use_cookies')) {
                    $param = session_get_cookie_params();
                    setcookie('PHPSESSID', '', time() - 999999999, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
                }
                else setcookie('PHPSESSID', '', time()-999999999);
            }
        }
        ob_end_flush();
        return true;
    }
}