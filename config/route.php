<?php
return array(
    "/authorization/" => "authorization/user",
    "/signup/registration/" => "registration/newUser",
    "/signup/" => "registration/form",
    "/user_([a-z]+)/" => "user/workspace/$1",
    // Запись для вызова только контроллера
    "/" => "index/index" // По идее в конструкторе все должно подтянуться
);