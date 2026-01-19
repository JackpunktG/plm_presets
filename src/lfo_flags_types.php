<?php
require __DIR__ . "/helper_functions.php";
require __DIR__ . "/Databank.php";
use plm_presets\Databank;
session_start(); 

loadEnv(__DIR__ . '/../.env');
$db = new Databank($_ENV['DB_USER'], $_ENV['DB_PW'], $_ENV['DB_NAME']);
$_SESSION['lfo_flags'] = $db->get_lfo_flags();
$_SESSION['lfo_types'] = $db->get_lfo_types();
render('lfo_flags_types');
exit();
