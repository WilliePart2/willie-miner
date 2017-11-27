<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Статистика пользователя: <?php echo $user ?></title>
</head>
<body>
<div class="self_mining">
    <h4 class="self_mining_head">Статистика self-майнинга</h4>
    <div class="self_mining_body">
        <!--Тут будет информация о личном майнинге пользователя-->
    </div>
</div>
<div class="stream_mining">
    <h4 class="stream_mining_head">Статистика майнинги из потоков</h4>
    <div class="stream_mining_body">
        <!--Тут будет информация из потоков направленых на майнинг-->
    </div>
</div>
<div class="referral_mining">
    <h4 class="ref_mining_head">Статистика майнинга из рефералов</h4>
    <div class="ref_mining_body">
        <!--Статистика майнинга из рефералов-->
    </div>
</div>
<div class="all_mining">
    <h4 class="all_header">Общая статистика</h4>
    <div class="all_body">
        <h5>Общее количество криптовалюты: <?php echo $all; ?></h5>
    </div>
</div>
</body>
</html>