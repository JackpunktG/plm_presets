<?php
namespace plm_presets;
require_once __DIR__ . '/obj.php'; 

class Databank
{
    private $conn;     

    public function __construct(string $username, string $password, string $database)
    {
        $this->conn = pg_pconnect("host=localhost dbname=$database user=$username password=$password");
        
        if (!$this->conn) {
            throw new \Exception("Failed to connect to PostgreSQL:  " . pg_last_error());
        }
    }

    function __destruct()
    {
        if ($this->conn) {
            pg_close($this->conn);
        }
    }

    function test_connection() : bool
    {
        return (bool)$this->conn;
    }
        
    function error_msg() : string
    {
        return pg_last_error($this->conn);
    }

    function insert_synth_type(Synth_Type $synth_type) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO synth_types VALUES($1, $2) RETURNING id", [$synth_type->type, $synth_type->config_notes]);
        
        if (! $result) 
            return false;

        $row = pg_fetch_assoc($result);
        $synth_type->id = (int)$row['id'];
        return true;
    }

    function insert_synth_flag(Synth_Flags $synth_flag) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO synth_flags VALUES($1, $2, $3) RETURNING id", [$synth_flag->flag, $synth_flag->binary_value, $synth_flag->config_notes]);
        
        if (!$result) 
            return false;

        $row = pg_fetch_assoc($result);
        $synth_flag->id = (int)$row['id'];
        return true;
    }
        
    function insert_lfo_type(LFO_Type $lfo_type) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO lfo_types VALUES($1, $2) RETURNING id", [$lfo_type->type, $lfo_type->config_notes]);
        
        if (!$result)
            return false;

        $row = pg_fetch_assoc($result);
        $lfo_type->id = (int)$row['id'];
        return true;
    }

    function insert_lfo_flag(LFO_Flags $lfo_flag) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO lfo_flags VALUES($1, $2, $3) RETURNING id", [$lfo_flag->flag, $lfo_flag->binary_value, $lfo_flag->config_notes]);
        
        if (!$result)
            return false;

        $row = pg_fetch_assoc($result);
        $lfo_flag->id = (int)$row['id'];
        return true;
    }
    
    function insert_synth(Synth $synth) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO synths VALUES($1, $2, $3, $4, $5, $6) RETURNING id", [$synth->name, $synth->type->id, $synth->frequency, $synth->sampleRate, $synth->volume, $synth->config_notes]);
        
        if (!$result)
            return false;

        $row = pg_fetch_assoc($result);
        $synth->id = (int)$row['id'];
        
        if (! empty($synth->flags))
        {
            foreach($synth->flags as $flag)
            {
                if ($synth->id === -1 || $flag->id === -1) {
                    return false;
                }
                
                $result = pg_query_params($this->conn, "INSERT INTO synths_synth_flags VALUES($1, $2)", [$synth->id, $flag->id]);

                if (!$result)
                    return false;
            }
        }
        return true;
    }
    
    function insert_lfo(LFO_module $lfo) : bool
    {
        $result = pg_query_params($this->conn, "INSERT INTO lfos VALUES($1, $2, $3, $4, $5) RETURNING id", [$lfo->name, $lfo->type->id, $lfo->frequency, $lfo->amplitude, $lfo->config_notes]);
        
        if (!$result)
            return false;
 
        $row = pg_fetch_assoc($result);
        $lfo->id = (int)$row['id'];

        if (!empty($lfo->flags))
        {
            foreach($lfo->flags as $flag)
            {
                if ($lfo->id === -1 || $flag->id === -1) {
                    return false;
                }
                
                $result = pg_query_params($this->conn, "INSERT INTO lfos_lfo_flags VALUES($1, $2)", [$lfo->id, $flag->id]);

                if (!$result)
                    return false;
            }
        }
        return true;
    }

    function get_lfo_flags() : array
    {
        $flags = [];
        $result = pg_query_params($this->conn, "SELECT id, flag, binary_value, config_notes FROM lfo_flags", []);
        
        if (! $result)
            return $flags;

        while ($row = pg_fetch_assoc($result))
        {
            $flag = new LFO_Flags($row['flag'], $row['binary_value'], $row['config_notes'], (int)$row['id']);
            $flags[] = $flag;
        }
        return $flags;
    }

    function get_lfo_type_for_lfo(int $id) : ?LFO_Type
    {
        $result = pg_query_params($this->conn, "SELECT id, type, config_notes FROM lfo_types WHERE id = $1", [$id]);
        
        if (!$result)
            return null;

        $row = pg_fetch_assoc($result);
        if (! $row)
            return null;
            
        $lfo_type = new LFO_Type($row['type'], $row['config_notes'], (int)$row['id']);
        return $lfo_type;
    }

    function get_lfo_types() : array
    {
        $types = [];
        $result = pg_query_params($this->conn, "SELECT id, type, config_notes FROM lfo_type", []);
        
        if (!$result)
            return $types;

        while ($row = pg_fetch_assoc($result))
        {
            $type = new LFO_Type($row['type'], $row['config_notes'], (int)$row['id']);
            $types[] = $type;
        }
        return $types;
    }

    function get_flags_for_lfo(int $lfo_id) : array
    {
        $flags = [];
        $result = pg_query_params($this->conn, "SELECT lf.id, lf.flag, lf.binary_value, lf.config_notes FROM lfo_flags lf JOIN lfos_lfo_flags lgf ON lf.id = lgf.flag_id WHERE lgf.lfo_id = $1", [$lfo_id]);
        
        if (!$result)
            return $flags;

        while ($row = pg_fetch_assoc($result))
        {
            $flag = new LFO_Flags($row['flag'], $row['binary_value'], $row['config_notes'], (int)$row['id']);
            $flags[] = $flag;
        }
        return $flags;
    }

    function get_lfo_modules() : array
    {
        $lfos = [];
        $result = pg_query_params($this->conn, "SELECT id, name, type_id, frequency, amplitude, config_notes FROM lfos", []);
        
        if (! $result)
            return $lfos;

        while ($row = pg_fetch_assoc($result))
        {
            $type = $this->get_lfo_type_for_lfo((int)$row['type_id']);
            if (!$type) {
                continue;  // Skip if type not found
            }
            
            $lfo = new LFO_module($row['name'], $type, (float)$row['frequency'], (float)$row['amplitude'], $row['config_notes'], (int)$row['id']);
            $lfo->flags = $this->get_flags_for_lfo((int)$row['id']);
            $lfos[] = $lfo;
        }
        return $lfos;
    }
}
