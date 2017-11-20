<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Willie-miner</title>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/indexStyle.css">
    <script></script>
</head>
<body>
<header class="top-menu">
    <h1 class="top-menu_label"><span class="open_php">?php echo </span>Willie-Miner.<small class="small">net</small><span class="close_php">; ?</span></h1>
    <div class="sign-btn">
        <a href="signin/"><button class="btn btn_signin">Вход</button></a>
        <a href="signup/"><button class="btn btn_signout">Регистрация</button></a>
    </div>
</header>
<main>
    <!--Тут будет будет блок для js вывода меню и демонстрационный майнер   -->
    <div class="main-wrapper">
        <div class="main_miner">
            <!-- Тут будет демонстрационный майнер -->
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