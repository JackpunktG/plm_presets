<div class="container">
    <div> 
    </div>
    <div>
        <h3>LFO Types</h3>
        <?php \plm_presets\LFO_Type::array_to_table($_SESSION['lfo_types']); ?>  
    </div>
    <div>
        <h3>Input new LFO type</h3>
        <form method="POST" action="src/input_processing.php">
        <input type="text" name="lfo_type" placeholder="flag type" id="stdInput"><br>
        <textarea name="lfo_config_notes" placeholder="notes" cols="40" rows="5"></textarea><br>
        <button type="reset">Clear</button>
        <button type="submit" name="submit_lfo_type">Add</button>
        </form>
    </div>
    <div>
    </div>
    <div>
        <h3>LFO_Flags</h3>
        <?php \plm_presets\LFO_Flags::array_to_table($_SESSION['lfo_flags']); ?>  
    </div>
    <div>
        <h3>Input new LFO flag</h3>
        <form method="POST" action="src/input_processing.php">
        <input type="text" name="flag_type" placeholder="flag type" id="stdInput"><br>
        <input type="text" name="flag_binary_value" placeholder="binary value" id="stdInput"><br>
        <textarea name="flag_config_notes" placeholder="notes" cols="40" rows="5"></textarea><br>
        <button type="reset">Clear</button>
        <button type="submit" name="submit_lfo_flag">Add</button>
        </form>
    </div>
</div>
