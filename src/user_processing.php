<?php
use plm_presets\User;
require_once __DIR__ . '/Databank.php';
require_once __DIR__ . '/helper_functions.php';
loadEnv(__DIR__ . '/../.env');
session_start();

unset($_SESSION['user']);
unset($_SESSION['invalid_user_msg']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_new_user']))
{
    $user = new User(htmlspecialchars($_POST['alias']), htmlspecialchars($_POST['password']), true); 
    
    if ($user->verified) 
    {   
        setcookie("known_user", $user->alias, [
            'expires' => time()+3600 *24 * 30,
            'path' => '/',
            'httponly' => true,
            'secure' => true, // Only over HTTPS
            'samesite' => 'Strict'
            ]);
        $_SESSION['user'] = $user;
    }
    else
        $_SESSION['invalid_user_msg'] = "Bankbank connection failed... Try again later, or contact admin... lol";
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_login_user']))
{ 
    $user = new User(htmlspecialchars($_POST['alias']), htmlspecialchars($_POST['password'])); 
    
    if ($user->verified)
    {   
        setcookie("known_user", $user->alias, [
            'expires' => time()+3600 *24 * 30,
            'path' => '/',
            'httponly' => true,
            'secure' => true, // Only over HTTPS
            'samesite' => 'Strict'
            ]);
        $_SESSION['user'] = $user;
    } 
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_known_user']))
{
    $user = new User(htmlspecialchars($_COOKIE['known_user']), htmlspecialchars($_POST['password']));

    if ($user->verified)
    {   
        setcookie("known_user", $user->alias, [
            'expires' => time()+3600 *24 * 30,
            'path' => '/',
            'httponly' => true,
            'secure' => true, // Only over HTTPS
            'samesite' => 'Strict'
            ]);
        $_SESSION['user'] = $user;
    }

}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_clear_cookie']))
{
    setcookie("known_user", "", [
    'expires' => time()-3600,
    'path' => '/',
    'httponly' => true,
    'secure' => true, // Only over HTTPS
    'samesite' => 'Strict'
    ]);
    echo "user cleared";
    header("location: /../index.php");
    exit();
}
else
    echo "false request";

if (isset($_SESSION['user']))
    header("location: logged_in.php");
else
{
    if (!isset($_SESSION['invalid_user_msg']))
        $_SESSION['invalid_user_msg'] = "Incorrect PW";
    header("location: /../index.php");
}

exit();
