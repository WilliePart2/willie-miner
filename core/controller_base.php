<?php

class controller_base
{
    protected function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            return true;
        }
        else {
            return false;
        }
    }
    protected function getAjaxData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }
    protected function layout()
    {
        require_once ROOT.'/client/public/index.php';
    }
}