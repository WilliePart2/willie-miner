<?php
// Основные настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключения файлов
define('ROOT',dirname(__FILE__));
require_once(ROOT.'/components/Router.php');
require_once(ROOT.'/components/Db.php');
$connectionToSave = array(); // Эту штюку оставим серверному демону.

// Подключения к базе данных

// Подключение роутера
$router = new Router();
$router->run();