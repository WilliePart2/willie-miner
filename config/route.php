<?php
return array(
    "/user_([\\w]+)/" => "user/workspace/$1",
    "/signin/authorization/" => "authorization/user",
    "/authorization/" => "authorization/user",
    "/signup/registration/" => "registration/newUser",
    "/signup/" => "registration/form",
    "/signin/" => "authorization/form",
    // Запись для вызова только контроллера
    "/$" => "index/index" // По идее в конструкторе все должно подтянуться
);