<?php
use plm_presets\Databank;
require_once __DIR__ . '/Databank.php';
require_once __DIR__ . '/helper_functions.php';

session_start();

if (isset($_SESSION['user']) && $_SESSION['user']->verified)
{
    render('main_menu');
}
else
{
    echo "<br><br>ERROR - sorry something has gone wrong :(<br>";
}
exit();



exit();
