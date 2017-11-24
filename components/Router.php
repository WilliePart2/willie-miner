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
        $uri = $this->getURI();
//        echo "$uri";
        foreach($this->routes as $uriPattern => $action){
            if(preg_match("~$uriPattern~", $uri)){
                    $action = preg_replace("~$uriPattern~", $action, $uri);
//                    echo "$action";
                    $section = explode("/", $action);
//                    echo "<pre>";
//                    var_dump($section);
//                    echo "</pre>";
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
            }
        }
    }
}