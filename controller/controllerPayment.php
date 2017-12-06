<?php

require_once(ROOT.'/core/controller_base.php');
require_once(ROOT.'/components/User.php');
class controllerPayment extends controller_base
{
    public function actionIndex()
    {
        if($this->isAjax()){
            $user_obj = new User();
            if($user_obj->checkSession()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $this->layout();
            return true;
        }
    }
}