<?php
use plm_presets\Databank;
require __DIR__ . '/helper_functions.php';


if (isset($_SESSION['user']))
{
   echo "user is logged in :)";
}
else
{
    echo "Couldn't process user<br>";
}
exit();


$db = new Databank("", "", "planetary_loop_machine");
$_SESSION['lfo_flags'] = $db->get_lfo_flags();
$_SESSION['lfo_types'] = $db->get_lfo_types();
$_SESSION['db'] = $db;

exit();
