<?php
return array(
    "/user_(\\w+)/streams/addStream" => "stream/addStreamAjax",
    "/user_(\\w+)/streams/" => "stream/index",
    "/user_(\\w+)/deleteStream/" => "stream/deleteAjax",
    "/user_(\\w+)/statistic/" => "statistic/index",
    "/ajax_signup/" => "registration/ajax",
    "/ajax_signin/" => "authorization/ajax",
    "/ajax_out/" => "logout/ajax", // Если вдруг перед выходм отключат JS постаить метод со ссылкой.
    "/user_([\\w]+)/ajax_logout/" => "logout/ajax",
    "/user_([\\w]+)/ajax_justOut" => "logout/justOut",
    "/user_([\\w]+)/logout/" => "logout/index",
    "/user_(\\w+)/save/" => "save/index",

    "/user_([\\w]+)/" => "user/workspace/$1",
    "/signin/authorization/" => "authorization/user",
    "/authorization/" => "authorization/user",
    "/signup/registration/" => "registration/newUser",
    "/signup/" => "registration/form",
    "/signin/" => "authorization/form",

    // Пути для реакта
    "/workspace/ajax_logout/?" => "logout/ajax",
    "/workspace/payment/?" => "payment/index",
    "/workspace/statistic/?" => "statistic/index",
    "/workspace/streams/?" => "stream/index",
    "/workspace/self/?" => "user/workspace",
    "/save/?" => "save/index",
    "/workspace/?" => "user/workspace",
    "/register/?" => "registration/newUser",
    "/login/?" => "authorization/user",
    "/addStream/?" => "stream/addStreamAjax",
    "/deleteStream/?" => "stream/deleteAjax",
    "/getFile/?" => "stream/download",
    "/ajax_justOut/" => "logout/justOut",
    "/ajax_logout/" => "logout/ajax",



    // Запись для вызова только контроллера
    "/$" => "index/index" // По идее в конструкторе все должно подтянуться
);