<?php
namespace plm_presets;

class Synth_Type
{
    public int $id;
    public string $type;
    public ? string $config_notes;

    function __construct(string $type, ?string $config_notes, int $id = -1)
    {
        $this->id = $id;
        $this->type = $type;
        $this->config_notes = $config_notes;
    }
}

class Synth_Flags
{
    public int $id;
    public string $flag;
    public ? string $config_notes;
    public string $binary_value;

    function __construct(string $flag, string $binary_value, ?string $config_notes = NULL, int $id = -1)
    {
        $this->id = $id;
        $this->flag = $flag;
        $this->config_notes = $config_notes;
        $this->binary_value = $binary_value;
    }

    public static function array_to_table(array $flags) : void
    {
        echo "<table><tr><th>flag</th><th>binary_value</th><th>config_notes</th></tr>";
        foreach($flags as $flag)
        {
            echo "<tr>";
            echo "<td>$flag->flag</td>";
            echo "<td>$flag->binary_value</td>";
            echo "<td>$flag->config_notes</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

class Synth
{
    public int $id;
    public string $name;
    public Synth_Type $type;
    public float $frequency;
    public int $sampleRate;
    public float $volume;
    public ? string $config_notes;
    public array $flags;

    function __construct(string $name, Synth_Type $type, float $frequency, int $sampleRate, float $volume, ?string $config_notes, int $id = -1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->frequency = $frequency;
        $this->sampleRate = $sampleRate;
        $this->volume = $volume;
        $this->config_notes = $config_notes;
        $this->flags = [];  // Initialize array
    }

    function add_flag(Synth_Flags $flag) : void
    {
        $this->flags[] = $flag;
    }
}

class LFO_Type
{
    public int $id;
    public string $type;
    public ?string $config_notes;

    function __construct(string $type, ?string $config_notes, int $id = -1)
    {
        $this->id = $id;
        $this->type = $type;
        $this->config_notes = $config_notes;
    }

    public static function array_to_table(array $types) : void
    {
        echo "<form method='POST' action='/src/input_processing.php'>";
        echo "<table><tr><th>type</th><th>config_notes</th></tr>";
        foreach($types as $type)
        {
            $config = explode("\n", $type->config_notes);
            echo "<tr>";
            echo "<td>$type->type</td>";
            echo "<td>";
            foreach($config as $line)
                echo "$line<br>";
            echo "</td>";
            echo "<td><button class='buttonOrange' type='submit' name='EDIT_,lfo_type,{$type->id}'>edit</button></td>";
            echo "<td><button class='buttonRed' type='submit' name='DELETE_,lfo_type,{$type->id}'>X</button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    }
}

class LFO_Flags
{
    public int $id;
    public string $flag;
    public string $binary_value;
    public ?string $config_notes;

    function __construct(string $flag, string $binary_value, ? string $config_notes = NULL, int $id = -1)
    {
        $this->id = $id;
        $this->flag = $flag;
        $this->config_notes = $config_notes;
        $this->binary_value = $binary_value;
    }

    public static function array_to_table(array $flags) : void
    {
        echo "<form method='POST' action='/src/input_processing.php'>";
        echo "<table><tr><th>flag</th><th>binary_value</th><th>config_notes</th></tr>";
        foreach($flags as $flag)
        {
            $config = explode("\n", $flag->config_notes);
            echo "<tr>";
            echo "<td>$flag->flag</td>";
            echo "<td>$flag->binary_value</td>";
            echo "<td>";
            foreach($config as $line)
                echo "$line<br>";
            echo "</td>";
            echo "<td><button class='buttonOrange' type='submit' name='EDIT_,lfo_flags,{$flag->id}'>edit</button></td>";
            echo "<td><button class='buttonRed' type='submit' name='DELETE_,lfo_flags,{$flag->id}'>X</button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    }
}

class LFO_module
{
    public int $id;
    public string $name;
    public float $frequency;
    public float $amplitude;  // Changed from $intensity to match Databank usage
    public LFO_Type $type;
    public ? string $config_notes;  // Made nullable to match database
    public array $flags;

    function __construct(string $name, LFO_Type $type, float $frequency, float $amplitude, ? string $config_notes = NULL, int $id = -1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->frequency = $frequency;
        $this->amplitude = $amplitude;  // Changed from intensity
        $this->config_notes = $config_notes;
        $this->flags = [];  // Initialize array
    }

    function add_flag(LFO_Flags $flag) : void
    {
        $this->flags[] = $flag;
    }

    public static function array_to_table(array $lfo_modules) : void
    {
        echo "<table><tr><th>name</th><th>type</th><th>frequency</th><th>amplitude</th><th>config_notes</th><th>flags</th></tr>";
        foreach($lfo_modules as $lfo_module)
        {
            echo "<tr>";
            echo "<td>$lfo_module->name</td>";
            echo "<td>$lfo_module->type->type</td>";
            echo "<td>$lfo_module->frequency</td>";
            echo "<td>$lfo_module->amplitude</td>";  // Changed from intensity
            echo "<td>$lfo_module->config_notes</td>";
            echo "<td>";
            foreach($lfo_module->flags as $flag)
                echo "$flag->flag<br>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
