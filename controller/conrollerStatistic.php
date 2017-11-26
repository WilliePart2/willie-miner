<?php

require_once(ROOT.'/model/modelStatistic.php');
class controllerStatistic
{
    // Dashboard.
    public function actionIndex()
    {
        session_start();
        if(isset($_COOKIE['PHPSESSID'])){
            $error_log = array();
            if(isset($_SESSION['userAgent']) && $_SERVER['HTTP_USER_AGENT'] !== $_SESSION['userAgent']) array_push($error_log, '+');
            if(isset($_SESSION['remoteAddress']) && $_SERVER['REMOTE_ADDR'] !== $_SESSION['remoteAddress']) array_push($error_log, '+');
            if(isset($_SESSION['forwarded']) && $_SERVER['HTTP_X_FORWARDED_FOR'] !== $_SESSION['forwarded']) array_push($error_log, '+');
            if(isset($_SESSION['ip']) && $_SERVER['HTTP_X_REAL_IP'] !== $_SESSION['ip']) array_push($error_log, '+');

            if(empty($error_log)) $user = $_SESSION['user'];
            else return false;
        }
        else return false;
        // Что отображать:
        // Общее количество хэшэй.
        // Количесвто смайненое self майнингом.

        // Количество смайненое рефералами
        // Количество смайненое из потоков
        // Круговой график сколько отображающий вклад каждой области в майнинг
    }
}