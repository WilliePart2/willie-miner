<?php

require_once(ROOT.'/model/modelStatistic.php');
require_once(ROOT.'/core/controller_base.php');
require_once(ROOT.'/components/User.php');
class controllerStatistic extends controller_base
{
    // Dashboard.
    public function actionIndex()
    {
        if($this->isAjax()) {
            $user_obj = new User();
            if($user_obj->checkSession()) {
                // Что отображать:
                // Общее количество хэшэй.
                // Количесвто смайненое self майнингом.
                $user = $_SESSION['user'];
                $request_obj = new modelStatistic();
                $self_statistic = $request_obj->actionSelf($user); // будет 8 элементов
                $self_all = array_shift($self_statistic)['count'];


                // Количество смайненое рефералами
                // И сюда круговой график!
                $ref_statistic = $request_obj->actionReferral($user); // В первом аргументе общее количество рефералов.
                $ref_count = (!empty($ref_statistic)) ? array_shift($ref_statistic) : 0;
                $all_crypt_from_ref = (!empty($ref_statistic)) ? array_pop($ref_statistic) : 0;

                // Количество смайненое из потоков
                // Круговой график отображающий вклад каждого потока
                $stream_statistic = $request_obj->actionStream($user); // Сюда может вернуться много элементов. Первый элемент общее количество.
                $stream_all = array_shift($stream_statistic);
                $stream_count_currency = $stream_all['count'];
                $stream_count = $stream_all['stream_count'];
                // Круговой график отображающий вклад каждой области в майнинг

                // Общее количетсво хэшэй\крипты
                $all = ($self_all + $stream_all['count']);

                $data['self_all'] = $self_all;
                $data['self_statistic'] = $self_statistic;
                $data['ref_count'] = $ref_count;
                $data['all_crypt_from_ref'] = $all_crypt_from_ref;
                $data['stream_all'] = $stream_count_currency;
                $data['stream_count'] = $stream_count;
                $data['all'] = $all;
                echo json_encode($data);
                return true;
            }
        }
        else {
            $this->layout();
            return true;
        }
    }
}