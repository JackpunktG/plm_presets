<?php
use plm_presets\Databank;
require __DIR__ . '/helper_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pw']))
{
    $db = new Databank("appuser", $_GET['pw'], "planetary_loop_machine");
    $_SESSION['lfo_flags'] = $db->get_lfo_flags();
    $_SESSION['lfo_types'] = $db->get_lfo_types();
    $_SESSION['db'] = $db;
}
else
{
    echo "forgeting GET param?";
    exit();
}

if (isset($_COOKIE['known_user']))
    render('login'); 
else
    render('unknow_user');
exit();


exit();
