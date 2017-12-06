<?php
require_once(ROOT.'/core/controller_base.php');
class controllerIndex extends controller_base
{
    /**
     * Все что делает это метод это выводит главную страницу
    */
    public function actionIndex()
    {
        $this->layout();
        return true;
    }
}