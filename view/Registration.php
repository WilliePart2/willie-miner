<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Регистрация нового пользователя</title>
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/ResetCSS.css">
    <link type="text/css" rel="stylesheet" href="<?php ROOT ?>/templates/css/registrationStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h1 class="header">Регистрация</h1>
    <form class="form" action="registration/" method="POST">
        <div class="form_group">
            <label class="form_label" for="login">Логин</label>
            <input class="form_input" type="text" name="login" id="login">
        </div>
        <div class="form_group">
            <label class="form_label" for="email">Email</label>
            <input class="form_input" type="email" name="email" id="email">
        </div>
        <div class="form_group">
            <label class="form_label" for="password">Пароль</label>
            <input class="form_input" type="password" name="password" id="password">
        </div>
        <div class="form_group">
            <label class="form_label" id="repeat_password">Повторие пароль</label>
            <input class="form_input" type="password" name="repeat_password" id="repeat_password">
        </div>
        <div class="form-group">
            <button class="btn_submit" type="submit" name="signUp">Регистрация</button>
        </div>
    </form>
</div>
</body>
</html>