<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Авторизация пользователя</title>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/authorizationStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h1 class="header">Вход</h1>
    <form class="form" action="authorization/" method="POST">
        <div class="form_group">
            <label class="form_label" for="login">Логин</label>
            <input class="form_input" type="text" name="login" id="login">
        </div>
        <div class="form_group">
            <label class="form_label" for="password">Пароль</label>
            <input class="form_input" type="password" name="password" id="password">
        </div>
        <div class="form_group">
            <button class="btn_submit" type="submit" name="signIn">Вход</button>
        </div>
    </form>
</div>
</body>
</html>