<?php
return array(
    "/signin/authorization/" => "authorization/user",
    "/authorization/" => "authorization/user",
    "/signup/registration/" => "registration/newUser",
    "/signup/" => "registration/form",
    "/signin/" => "authorization/form",
    "/user_([a-z]+)/" => "user/workspace/$1",
    // Запись для вызова только контроллера
    "/" => "index/index" // По идее в конструкторе все должно подтянуться
);