<div class="container">
    <div> 
    </div>
    <div>
        <h3>LFO Types</h3>
        <?php \plm_presets\LFO_Type::array_to_table($_SESSION['lfo_types']); ?>  
    </div>
    <div>
    <?php $command = str_getcsv($_SESSION['edit_input'], ',');
        unset($_SESSION['edit_input']);
        //var_info($command);
    if ($command[1] === 'lfo_type')
    {   
        $toEdit = first($_SESSION['lfo_types'], fn($e) => $e->id === (int)$command[2]);
        //var_info($toEdit);
        echo "<h3>Input new LFO type</h3>
        <form method='POST' action='input_processing.php'>
        <input type='text' name='lfo_type' placeholder='flag type' id='stdInput' value={$toEdit->type}><br>
        <textarea name='lfo_config_notes' placeholder='notes' cols='40' rows='5'>{$toEdit->config_notes}</textarea><br>
        <button type='reset'>Clear</button>
        <button type='submit' name='UPDATE_,lfo_type,{$toEdit->id}'>Edit</button>
        </form> 
        <button type='submit' name='cancel'><a href={$_SERVER['REQUEST_URI']}>Cancel</a></button>";
    }
    else
    {
        echo "<h3>Input new LFO type</h3>
        <form method='POST' action='input_processing.php'>
        <input type='text' name='lfo_type' placeholder='flag type' id='stdInput'><br>
        <textarea name='lfo_config_notes' placeholder='notes' cols='40' rows='5'></textarea><br>
        <button type='reset'>Clear</button>
        <button type='submit' name='submit_lfo_type'>Add</button>
        </form>";  
    }?>
    </div>
    <div>
    </div>
    <div>
        <h3>LFO_Flags</h3>
        <?php \plm_presets\LFO_Flags::array_to_table($_SESSION['lfo_flags']); ?>  
    </div>
    <div>
    <?php if ($command[1] === 'lfo_flags') 
    {
        $toEdit = first($_SESSION['lfo_flags'], fn($e) => $e->id === (int)$command[2]);
        echo "<h3>Input new LFO flag</h3>
        <form method='POST' action='input_processing.php'>
        <input type='text' name='flag_type' placeholder='flag type' id='stdInput' value={$toEdit->flag}><br>
        <input type='text' name='flag_binary_value' placeholder='binary value' id='stdInput' value={$toEdit->binary_value}><br>
        <textarea name='flag_config_notes' placeholder='notes' cols='40' rows='5'>{$toEdit->config_notes}</textarea><br>
        <button type='reset'>Clear</button>
        <button type='submit' name='UPDATE_,lfo_flags,{$toEdit->id}'>Edit</button>
        </form>
        <button type='submit' name='cancel'><a href={$_SERVER['REQUEST_URI']}>Cancel</a></button>";
    
    }
    else
    {
        echo "<h3>Input new LFO flag</h3>
        <form method='POST' action='input_processing.php'>
        <input type='text' name='flag_type' placeholder='flag type' id='stdInput'><br>
        <input type='text' name='flag_binary_value' placeholder='binary value' id='stdInput'><br>
        <textarea name='flag_config_notes' placeholder='notes' cols='40' rows='5'></textarea><br>
        <button type='reset'>Clear</button>
        <button type='submit' name='submit_lfo_flag'>Add</button>
        </form>";
    } ?>
    </div>
</div>
