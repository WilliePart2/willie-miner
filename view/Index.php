<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        /*Это все перенести в файл стилей*/
        .top-menu {
            height: 50px;
            position: relative;
        }
        .top-menu_label{
            display: inline-block;
            text-align: left;
            font-size: 24px;
        }
        .sign-btn{
            display: inline-block;
            position: absolute;
            right: 0;
        }
        .small{
            font-size: 16px;
        }
        a {
            text-decoration: none;
        }
    </style>
    <script></script>
</head>
<body>
<header class="top-menu">
    <h1 class="top-menu_label">Willie-Miner.<small class="small">net</small></h1>
    <div class="sign-btn">
        <a href="signin/"><button>Вход</button></a>
        <a href="signup/"><button>Регистрация</button></a>
    </div>
</header>
</body>
</html>