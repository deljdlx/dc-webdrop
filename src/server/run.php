<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use WebDrop\WebDropServer;

require_once __DIR__ . '/vendor/autoload.php';

$port = 8443;

$server = IoServer::factory(
    new HttpServer(new WsServer(new WebDropServer())),
    $port
);

set_error_handler(function ($severity, $message, $file, $line) use ($server) {
    // if (in_array($severity, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
    //     throw new ErrorException($message, 0, $severity, $file, $line);
    // }
    // $server->
    // return false;
    echo sprintf("Error: %s in %s on line %d\n", $message, $file, $line);
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        throw new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
    }
});


set_exception_handler(function ($exception) {
    echo $exception->getMessage();
});




echo "Starting server on port {$port}\n";
$server->run();