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
        <div class="self_mining_all">
            <h5>Общее количество хэшэй от self майнинга</h5>
            <?php echo $self_all; ?>
        </div>
        <div class="self_mining_from_week">
            <h5>Статистика добычи за последнюю неделю</h5>
            <?php if(!empty($self_statistic)){foreach($self_statistic as $val): ?>
                <div class="self_mining_from_week_wrapper">
                    <div class="self_mining_date"><?php echo $val['date'] ;?></div>
                    <div class="self_mining_count"><?php echo $val['crypt_count']; ?></div>
                </div>
            <?php endforeach;} ?>
        </div>
    </div>
</div>
<div class="stream_mining">
    <h4 class="stream_mining_head">Статистика майнинги из потоков</h4>
    <div class="stream_mining_body">
        <!--Тут будет информация из потоков направленых на майнинг-->
        <div class="stream_mining_all">
            Общее количество хэшэй из потоков: <?php echo $stream_all['count']; ?>
        </div>
        <div class="stream_mining_statistic">
            <?php if(!empty($stream_statistic)) foreach($stream_statistic as $value): ?>
                <div class="stream_mining_statistic--wrapper"></div>
                <div class="stream_mining_statistic--name">Поток: <?php echo $value['stream_name']; ?></div>
                <div class="stream_mining_statistic--value">Хэшэй из потока: <?php echo $value['currency_count']; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="referral_mining">
    <h4 class="ref_mining_head">Статистика майнинга из рефералов</h4>
    <div class="ref_mining_body">
        <!--Статистика майнинга из рефералов-->
        <div class="ref_mining_all_ref">
            Общее количество рефералов: <?php echo $ref_count; ?>
        </div>
        <div class="ref_mining_all_from_ref">
            Всего добыто рефералами: <?php echo $all_crypt_from_ref; ?>
        </div>
        <div class="ref_mining_statistic">
            <?php if(!empty($ref_statistic)) foreach($ref_statistic as $key => $val): ?>
                <div class="ref_mining_statistic--referral"><?php echo $val[$key]; ?></div>
            <?php endforeach; ?>
        </div>
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