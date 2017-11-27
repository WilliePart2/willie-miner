<?php

class Router
{
    public $routes;
    public function __construct()
    {
        $this->routes = require_once(ROOT.'/config/route.php');
    }
    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            return $_SERVER['REQUEST_URI'];
        }
    }
    public function run()
    {
        /**
         * Получение данных от клиента
         * */
        $uri = $this->getURI();
        $query = (isset($_GET['ref']))? trim($_SERVER['QUERY_STRING']) : null;
        if(!is_null($query)){
            $position = strpos($uri, $query);
            $query = substr($uri, $position);
            $uri = substr($uri, 0, strlen($query)-2); // Индекс конца вырезания включается в результирующую строку.
        }
        /**
         * Тело роутера
         */
        foreach($this->routes as $uriPattern => $action){
            if(preg_match("~$uriPattern~", $uri)){
                    $action = preg_replace("~$uriPattern~", $action, $uri);
                    $section = explode("/", $action);
                    $controllerName = 'controller'.ucfirst(array_shift($section));
                    $actionName = "action".ucfirst(array_shift($section));

                    $controllerFile = ROOT."/controller/".$controllerName.".php";
                    if(file_exists($controllerFile)){
                        require_once($controllerFile);
                        $controllerObject = new $controllerName();
                        $result = call_user_func_array(array($controllerObject,$actionName),$section);
                        if($result !== null){
                            break;
                        }
                    }
                    else{
                        /** Если контроллера не найдено выдать страницу ошибки */
                    }
            }
        }
    }
}