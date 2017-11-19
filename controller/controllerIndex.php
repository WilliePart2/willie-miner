<?php

class controllerIndex
{
    /**
     * Все что делает это метод это выводит главную страницу
    */
    public function actionIndex()
    {
        require_once(ROOT.'/view/Index.php');
        return true;
    }
}