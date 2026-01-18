<?php
use plm_presets\User;
require_once __DIR__ . '/Databank.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_new_user']))
{
    $user = new User(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), $_SESSION['db'], true); 
    
    if ($user->verified) 
    {   
        setcookie("known_user", $user->username, [
            'expires' => time()+3600 *24 * 30,
            'path' => '/',
            'httponly' => true,
            'secure' => true, // Only over HTTPS
            'samesite' => 'Strict'
            ]);
        $_SESSION['user'] = $user;
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_login_user']))
{ 
    $user = new User(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), $_SESSION['db']); 
    
    if ($user->verified)
    {   
        setcookie("known_user", $user->username, [
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
    $user = new User(htmlspecialchars($_COOKIE['known_user']), htmlspecialchars($_POST['password']), $_SESSION['db']);

    if ($user->verified)
    {   
        setcookie("known_user", $user->username, [
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
}
else
    echo "false request";


header("location: logged_in.php");
exit();
