<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Willie-miner</title>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/indexStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <script></script>
</head>
<body>
<header class="top-menu">
    <h1 class="top-menu_label"><span class="open_php">?php echo </span><span class="top_willie">Willie</span>-<span class="top_miner">Miner</span>.<small class="small">net</small><span class="close_php">; ?</span></h1>
    <div class="sign-btn">
        <a class="btn btn_signin" href="signin/">Вход</a>
        <a class="btn btn_signout" href="signup/">Регистрация</a>
    </div>
</header>
<main>
    <!--Тут будет будет блок для js вывода меню и демонстрационный майнер   -->
    <div class="main-wrapper">
        <div class="main_miner">
            <!-- Тут будет демонстрационный майнер -->
            <script src="https://authedmine.com/lib/simple-ui.min.js" async></script>
            <div class="coinhive-miner"
                 style="width: 300px; height: 350px"
                 data-key="wvolo3wcsofZ0QWawBkpuIxyh5kiYzEk"
                 data-autostart="false"
                 data-whitelabel="true"
            >
                <em>Loading...</em>
            </div>
        </div>
        <div class="main_form">
            <!-- Сюда будет выезжать форма для входа\регистрации -->
        </div>
    </div>
</main>
<div class="border"><!--Пустой блок для ограничивания--></div>
<footer class="footer">
    <!--Тут будет подвал сайта с копирайтами-->
    <div class="footer_item"></div>
    <div class="footer_item"></div>
    <div class="footer_item"></div>
</footer>
</body>
</html>