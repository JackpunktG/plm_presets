<?php
function render(string $view, array $data = NULL, bool $extract = true): void
{
    if ($data != NULL && $extract)
        extract($data);
    require __DIR__ . "/../views/$view.php";
}

function var_info(...$values): void
{
    foreach ($values as $value)
    { 
        echo "<pre>";
        var_dump($value);
        echo "</pre>"; 
    }
}

//checks post for any empty or mallicious inputs
function check_post(array $data) : bool
{
    //make some sort of function to detect scripts etc...
    
    return true;
}

function print_post(array $data) : void
{
    foreach($_POST as $key => $value)
        echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
}

function generate_table_csv($pathCSV) : void
{
    if (($handle = fopen($pathCSV, "r")) !== FALSE) {
    echo "<table style=\"width:80%\" border=\"2\">";
    while (($data = fgetcsv($handle, null, ",")) !== FALSE) {
        $num = count($data);
        echo "<tr>";
        for ($c=0; $c < $num; $c++) {
            echo "<td>$data[$c]</td>";
        }
        echo "</tr>";

    }
    echo "</table>";
    fclose($handle);
    }
    else
    {
        echo "Datei nicht gefunden!";
    }
}

function loadEnv($path)
{
    if (! file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '//') === 0) {
            continue;
        }

        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}
