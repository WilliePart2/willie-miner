<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Кабинет пользователя <?php echo $user; ?></title>
    <script src="https://authedmine.com/lib/simple-ui.min.js" async></script>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/userStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body>
<header class="header">
    <!--Шапка с идентификаторами майнинга-->
    <div class="header_stat">
        <h1 class="header_user"><?php echo $user; ?></h1>
        <h6 class="header_rate">На вашем счету: <?php echo $result; ?> хэшэй</h6>
        <a class="logout" href="out/">Выход</a>
    </div>
    <div class="miner_wrapper">
        <div class="coinhive-miner"
             style="width: 550px; height: 100px"
             data-key="wvolo3wcsofZ0QWawBkpuIxyh5kiYzEk"
             data-autostart="false"
             data-whitelabel="true"
             data-background="#159173"
             data-text="#fff"
             data-action="#00ff00"
             data-graph="#555555"
             data-threads="4"
             data-throttle="0">
            <em>Loading...</em>
        </div>
    </div>
</header>
<main>
    <!--Пункт настройки и график со статистикой майнинга-->

</main>
<footer>
    <!--Маленький, возможно, скрытый футер-->
</footer>
</body>
</html>