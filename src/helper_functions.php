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
            
            putenv("$key=$value");
            $_ENV[$key] = $value; 
        }
    }
}

function post($server) : bool
{
    return isset($server['REQUEST_METHOD']) && $server['REQUEST_METHOD'] === 'POST';
}

function array_key_starts_with(array $array, string $key) : ?string 
{
    foreach ($array as $k => $item)
    {
        if (str_starts_with($k, $key))
            return $k;
    }
    return NULL;
}
 
function first(array $array, callable $callback) :  mixed
{
    foreach ($array as $item) {
        if ($callback($item)) {
            return $item;
        }
    }
    return null;
}
