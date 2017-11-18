<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Регистрация нового пользователя</title>
</head>
<body>
<h1>Регистрация нового пользователя</h1>
<form action="registration/" method="POST">
    <div class="form_group">
        <label class="form-label" for="login">Логин</label>
        <input class="form-input" type="text" name="login" placeholder="Введите ваш логин" id="login">
    </div>
    <div class="form_group">
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" name="email" placeholder="Введите ваш email" id="email">
    </div>
    <div class="form_group">
        <label class="form-label" for="password">Пароль</label>
        <input class="form-input" type="password" name="password" placeholder="Введите ваш пароль" id="password">
    </div>
    <div class="form_group">
        <label class="form-label" id="repeat_password">Повторие пароль</label>
        <input class="form-input" type="password" name="repeat_password" placeholder="Повторите пароль" id="repeat_password">
    </div>
    <div class="form-group">
        <button class="btn-submit" type="submit" name="signUp">Регистрация</button>
    </div>
</form>
</body>
</html>