<?php

require_once(ROOT.'/core/controller_base.php');
require_once(ROOT.'/components/User.php');
require_once(ROOT.'/model/modelLogout.php');
class controllerSave extends controller_base
{
    public function actionIndex()
    {
        if ($this->isAjax()) {
            $user_obj = new User();
            if ($user_obj->checkSession()) {
                $user = $_SESSION['user'];
                $data = isset($_POST['data']) ? $_POST['data'] : 0;
                $ref_data = (isset($_SESSION['ref'])) ? $data * (($_SESSION['ref_per']) / 100) : 0;
                $data = $data - $ref_data;

                $_SESSION['crypt_fo_master'] += $ref_data - (!empty($_SESSION['crypt_fo_master']) && isset($_SESSION['crypt_fo_master'])? $_SESSION['crypt_fo_master'] : 0);
                $_SESSION['crypt_count'] += $data - (!empty($_SESSION['crypt_count'] && isset($_SESSION['crypt_count']))? $_SESSION['crypt_count'] : 0);
                echo"Принято сохранениe";
                echo "Всего хэшэй: ".$_SESSION['crypt_count'];
                $_SESSION['time_to_save'] = time();
                sleep(30);
                if((time() - $_SESSION['time_to_save']) > 20 ) $this->save_to_db($_SESSION['crypt_count'], $_SESSION['crypt_fo_master'], $user);
            }
        }
    }
    private function save_to_db($data, $ref_data, $user)
    {
        $request_obj = new ModelLogout();
        $request_obj->actionSave($data, $ref_data, $user);
    }
}