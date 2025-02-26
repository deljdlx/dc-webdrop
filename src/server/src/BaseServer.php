<?php
namespace WebDrop;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


require 'vendor/autoload.php';

class BaseServer implements MessageComponentInterface {

    protected $clients = [];
    protected array $clientsData;

    public function __construct() {
        $this->clientsData = [];
    }

    public function getClients() {
        return $this->clients;
    }

    public function sendTo($id, $msg) {
        $this->clients[$id]->send($msg);
    }

    public function broadcast($msg) {
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function setClientData($id, $key, $value) {
        $this->clientsData[$id][$key] = $value;
    }

    public function getClientData($id, $key = null) {
        if($key === null) {
            return $this->clientsData[$id];
        }

        return $this->clientsData[$id][$key];
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "New message from {$from->resourceId} : $msg\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "🔥 New connection with id {$conn->resourceId} \n";
        $this->clients[$conn->resourceId] = $conn;
        $this->clientsData[$conn->resourceId] = [];
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\n";
        unset($this->clients[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error on connection {$conn->resourceId} : {$e->getMessage()}\n";
        $conn->close();
    }

    protected function executeCallback(string $callbak, ConnectionInterface $connection, $message = null) {
        $path = __DIR__ . '/callbacks/' . $callbak;
        if(!is_dir($path)) {
            echo "No callback for $callbak\n";
            return;
        }

        $files = scandir($path);
        foreach ($files as $file) {
            $includePath = $path . '/' . $file;
            $fileExtension = pathinfo($includePath, PATHINFO_EXTENSION);
            if ($fileExtension !== 'php') {
                continue;
            }
            try {
                $server = $this;
                echo "⚙️ Including $includePath\n";
                include $includePath;
            }
            catch (\Exception $e) {
                echo "Error while including $file : {$e->getMessage()}\n";
            }
        }
    }
}
