<?php
session_start();
require __DIR__ . '/vendor/auth.php';

?>
<html>

<head>
    <title>Главная страница</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
</head>

<body>
    <?php
    if (!isUserLoggedIn()) : ?>
        <div class="not-loggedIn-user">
            <p> Данная страница супер секретная! <br>
                Для доступа к ней необходимо
                <a href="/login.php">авторизоваться</a>
            </p>
        </div>
    <?php else : ?>
        <div class="loggedIn-user">
            <p>Добро пожаловать, <?= $_SESSION['user']['login'] ?></p>
            <a href="/vendor/logout.php">Выйти</a>
        </div>
    <?php endif;

    ?>
</body>

</html>