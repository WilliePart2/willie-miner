<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Площадки майнинга</title>
    <script type="text/javascript" src="<?php ROOT ?>/js/UI_inside/Stream/controllerStream.js"></script>
    <script type="text/javascript" src="<?php ROOT ?>/js/UI_inside/Stream/modelStream.js"></script>
    <script type="text/javascript" src="<?php ROOT ?>/js/UI_inside/Stream/viewStream.js"></script>
    <script type="text/javascript" src="<?php ROOT ?>/js/UI_inside/Stream/modelStreamAjax.js"></script>
    <script type="text/javascript" src="<?php ROOT ?>/js/UI_inside/Stream/modelStreamDeleteAjax.js"></script>
</head>
<body>
    <div class="left_sidebar">
        <!--Тут будет общая для всех панелька навигации-->
        <div class="sidebar_user_name">
            <?php echo $user; ?>
        </div>
    </div>
    <h2>Имеющиеся площадки для майнинга</h2>
    <div class="users_mining_streams">
        <div class="user_stream_count">Количество потоков: <?php if($query !== false) print_r(array_shift($query)['user_stream']); ?></div>
        <table class="js_stream_table">
            <tr class="head_row">
                <th>№</th>
                <th>Название потока</th>
                <th>Адрес потока</th>
                <th>Количетсво хэшэй из потока</th>
                <th>Тип валюты потока</th>
                <th>Изменить</th> <!--Вставить сюда иконку... наверное-->
            </tr>
        <?php if($query != false){
            $count = 1;
            foreach($query as $line => $params) {
                echo "<tr class='body_row'>";
                echo "<td class='stream_count'>{$count}</td>";
                echo "<td class='stream_name'>$params[stream_name]</td>";
                echo "<td class='stream_addr'>$params[stream_addr]</td>";
                echo "<td class='currency_count'>$params[currency_count]</td>";
                echo "<td class='currency_type'>$params[stream_currency]</td>";
                echo "<td><a href='#' class='delete_stream_btn'>удалить</a></td>";
                echo "</tr>";
                $count++;
            }
        }
        else {
            echo "<tr class='empty_row'>";
            echo "<td colspan='5'>Пока что площадок для майнинга нету</td>";
            echo "</tr>";
        }?>
        </table>
    </div>
    <div class="add_mining_stream">
        <h4>Добавлить площадку для потока майнинга</h4>
        <form>
            <input class="js_stream_name_field" type="text" name="mining_stream_name" placeholder="Введите имя площадки">
            <input class="js_stream_addr_field" type="text" name="mining_stream_address" placeholder="Введите адрес площадки">
            <select class="js_stream_currency_type" name="mining_currency_type">
                <option value="Monero" checked="true">Monero</option>
                <option value="JSEcoin">JSEcoin</option>
            </select>
            <input type="button" class="js_add_stream" name="addStream" value="Добавить канал">
        </form>
    </div>
</body>
</html>