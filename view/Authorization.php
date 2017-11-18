<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Авторизация пользователя</title>
</head>
<body>
<form action="authorization/" method="POST">
    <div class="form-group">
        <label class="form-label" for="login">Логин</label>
        <input class="form-input" type="text" name="login" placeholder="Введите ваш логин" id="login">
    </div>
    <div class="form-group">
        <label class="form-label" for="password">Пароль</label>
        <input class="form-input" type="password" name="password" placeholder="Введите ваш пароль" id="password">
    </div>
    <div class="form-group">
        <button class="btn-submit" type="submit" name="signIn">Вход</button>
    </div>
</form>
</body>
</html>