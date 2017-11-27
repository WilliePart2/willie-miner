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

            if(empty($error_log)) $user = trim($_SESSION['user']);
            else return false;
        }
        else return false;
        // Что отображать:
        // Общее количество хэшэй.
        // Количесвто смайненое self майнингом.
        $request_obj = new modelStatistic();
        $self_statistic = $request_obj->actionSelf($user); // будет 8 элементов
        $self_all = array_shift($self_statistic);


        // Количество смайненое рефералами
            // И сюда круговой график!

        // Количество смайненое из потоков
            // Круговой график отображающий вклад каждого потока
        $stream_static = $request_obj->actionStream($user); // Сюда может вернуться много элементов. Первый элемент общее количество.
        $stream_all = array_shift($stream_static);
        // Круговой график отображающий вклад каждой области в майнинг

        // Общее количетсво хэшэй\крипты
        $all = $self_all['count'] + $stream_all['count'];
        require_once(ROOT.'/view/Statistic.php');
        return true;
    }
}