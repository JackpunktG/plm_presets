<?php
require_once __DIR__ . '/Databank.php';
require_once __DIR__ . '/helper_functions.php';
use plm_presets\Databank;
use plm_presets\LFO_Flags;
use plm_presets\LFO_Type;


function delete_entry(Databank $db, string $table, string $id) : bool
{
    $result = pg_query_params($db->conn, "DELETE FROM $table WHERE id = $1", [$id]);
    if (!$result)
        return false;
    else
        return true;
}

function update_entry(Databank $db, string $table, string $id) : bool
{
    $result = pg_query_params($db->conn, "UPDATE $table WHERE id = $1", [$id]);
    if (!$result)
        return false;
    else
        return true;
}

  
loadEnv(__DIR__ . '/../.env');
session_start();
$correctlyAdded = true;
$nextLocation = "/../index.php";
if (isset($_SESSION['edit_input']))
    unset($_SESSION['edit_input']);
//var_info($_POST);
        
if (post($_SERVER))
{
    $db = new Databank($_ENV['DB_USER'], $_ENV['DB_PW'], $_ENV['DB_NAME']);
    if (isset($_POST['submit_lfo_flag']))
    {
        $lfoF = new LFO_Flags($_POST['flag_type'], $_POST['flag_binary_value'], $_POST['flag_config_notes']);
        if (!$db->insert_lfo_flag($lfoF)) 
            $correctlyAdded = false;
        $nextLocation = "/src/lfo_flags_types.php";
    }
    else if (isset($_POST['submit_lfo_type']))
    {
        $lfoT = new LFO_Type($_POST['lfo_type'], $_POST['lfo_config_notes']);   
        if (!$db->insert_lfo_type($lfoT))
            $correctlyAdded = false;
        $nextLocation = "/src/lfo_flags_types.php";
    }

    $edit = array_key_starts_with($_POST, 'EDIT');
    echo $edit;
    if ($edit !== NULL)
    {
        $_SESSION['edit_input'] = $edit;
        $nextLocation = "/src/lfo_flags_types.php";
    }
    $delete = array_key_starts_with($_POST, 'DELETE');
    if ($delete !== NULL)
    {   
        $command = str_getcsv($delete, ',');
        if (!delete_entry($db, $command[1], $command[2]))
            $correctlyAdded = false;
        $nextLocation = "/src/lfo_flags_types.php";
    }
}
else
    echo "ERROR - something has gone wrong, sorry :(";

if(!$correctlyAdded)
{
    echo "ERROR - something went wrong with the database action";
    exit();
}

header('location: ' . $nextLocation);
exit();

