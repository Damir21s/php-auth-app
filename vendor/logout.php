<?php
session_start();

$file = file_get_contents(dirname(__DIR__) . '/data/usersDB.json');

$users = json_decode($file, true);
unset($file);

for ($counter = 0; $counter < count($users); $counter++) {
    if ($users[$counter]['login'] == $_SESSION['user']['login'] && $users[$counter]['hash'] == $_SESSION['user']['hash']) {
        $users[$counter]['hash'] = "";
    }
}

file_put_contents(dirname(__DIR__) . '/data/usersDB.json', json_encode($users, JSON_UNESCAPED_UNICODE));
unset($users);
unset($_SESSION['user']);

header('Location: /index.php');
exit();
