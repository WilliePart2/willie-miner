<?php

require_once(ROOT.'/model/modelUser.php');
require_once(ROOT.'/components/User.php');
require_once(ROOT.'/core/controller_base.php');
class controllerUser extends controller_base
{
    public function actionWorkspace()
    {
        if($this->isAjax()) {
            $user_obj = new User();
            if ($user_obj->checkSession()) {
                $user = $_SESSION['user'];

                $request = new modelUser();
                $result = $request->getUser($user);
                if ($result !== false) {
                    $request = null;
                    $data['user'] = $user;
                    $data['crypt_count'] = $result;
                    echo json_encode($data);
                    return true;
                } else {
                    $request = null;
                    return false;
                }
            } else {
                echo '0';
                return false;
            }
        }
        else {

            $this->layout();
            echo '1';
            return true;
        }
    }
}