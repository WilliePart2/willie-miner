<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Кабинет пользователя <?php echo $user; ?></title>
    <script src="https://authedmine.com/lib/simple-ui.min.js" async></script>
    <script src="https://authedmine.com/lib/authedmine.min.js"></script>
    <script src="<?php ROOT ?>/js/minerController.js" type="text/javascript"></script>
<!--    <script src="--><?php //ROOT ?><!--/js/heshCounter.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="<?php ROOT ?>/js/minerModel.js"></script>
    <script  src="<?php ROOT ?>/js/viewUpdate.js" type="text/javascript"></script>
    <script src="<?php ROOT ?>/js/minerSaveModel.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/userStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body>
<header class="header">
    <!--Шапка с идентификаторами майнинга-->
    <div class="header_stat">
        <div class="main_statistic">
            <h1 class="header_user" id="username"><?php echo $user; ?></h1>
            <h6 class="header_rate">На вашем счету: <span class="hashMonitor"><?php echo $result; ?></span> хэшэй</h6>
            <a class="js_logout" href="logout/">Выход</a>
        </div>
        <div class="miner_statistic">
            <div class="js_miner_speed">
                <!-- Тут будет отображаться H/sec -->
                0 H/s
            </div>
            <div class="js_miner_total">
                <!-- тут будет отображаться общее количество хэшй полученых за сесию -->
                0
            </div>
        </div>
    </div>
</header>
<main>
    <!--Пункт настройки и график со статистикой майнинга-->
    <div class="miner_form_wrapper">
        <div class="threads">
            <h6>Количество потоков: </h6>
            <div class="threads_monitor_wrapper">
                <button class="js_threads_plus">+</button>
                <div class="js_threads_monitor">1</div>
                <button class="js_threads_minus">-</button>
            </div>
        </div>
        <div class="throttle">
            <h6>Скорость майнига: </h6>
            <div class="throttle_monitor_wrapper">
                <button class="js_throttle_minus">+</button>
                <div class="js_throttle_monitor">10%</div>
                <button class="js_throttle_plus">-</button>
            </div>
        </div>
        <div class="autoThreads">
            <h6>Автоматический подбор скорости</h6>
            <input type="radio" name="autoThrottle" class="js_autoThreads" value="true">
        </div>
        <button class="js_start_mining">Начать</button>
        <button class="js_stop_mining">Остановить</button>
    </div>
    <canvas>
        <!-- В этом канвасе будет график майнинга -->
    </canvas>
</main>
<footer>
    <!--Маленький, возможно, скрытый футер-->
</footer>
</body>
</html>