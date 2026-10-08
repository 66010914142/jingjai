<?php
session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
setcookie('jingjai_logged_in', '', time() - 3600, '/');
setcookie('jingjai_user_name', '', time() - 3600, '/');
session_destroy();
header('Location: login.php');
exit;
