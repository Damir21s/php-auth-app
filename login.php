<?php
session_start();

require __DIR__ . '/vendor/auth.php';

$error_msg = '';
$reg_success = '';
if (isset($_SESSION['error-msg'])) {
    $error_msg = $_SESSION['error-msg'];
    unset($_SESSION['error-msg']);
}
if (isset($_SESSION['reg-success'])) {
    $reg_success = $_SESSION['reg-success'];
    unset($_SESSION['reg-success']);
}

if (isUserLoggedIn())
    header('Location: /index.php');

?>

<html>

<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <form action="/vendor/log.php" method="post">
        <h1>Авторизация</h1>
        <div class="login">
            <label for="login">Логин: </label>
            <input type="text" name="login" id="login" placeholder="Введите логин">
        </div>
        <div class="password">
            <label for="password">Пароль: </label>
            <input type="password" name="password" id="password" placeholder="Введите пароль">
        </div>
        <input class="log-button" type="submit" value="Войти">
        <?php if (!empty($error_msg)) : ?>
            <span class="error-msg">
                <?= $error_msg ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($reg_success)) : ?>
            <span class="reg-success">
                <?= $reg_success ?>
            </span>
        <?php endif; ?>
        <p class="go-to-reg">У вас еще нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </form>

</body>

</html>