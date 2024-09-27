<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors to a file
function log_error($error_message) {
    $log_file = 'error_log.txt';
    $current_time = date('Y-m-d H:i:s');
    $formatted_message = "[$current_time] $error_message\n";
    file_put_contents($log_file, $formatted_message, FILE_APPEND);
}

// Set a custom error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $error_message = "Error [$errno]: $errstr in $errfile on line $errline";
    log_error($error_message);
    echo "<div style='color: red;'><strong>$error_message</strong></div>";
    return true;
});

// Set a custom exception handler
set_exception_handler(function ($exception) {
    $error_message = "Uncaught exception: " . $exception->getMessage();
    log_error($error_message);
    echo "<div style='color: red;'><strong>$error_message</strong></div>";
});

// Register a shutdown function to catch fatal errors
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== NULL) {
        $error_message = "Fatal error: {$error['message']} in {$error['file']} on line {$error['line']}";
        log_error($error_message);
        echo "<div style='color: red;'><strong>$error_message</strong></div>";
    }
});
?>