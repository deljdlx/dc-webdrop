<?php
namespace WebDrop;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebDropServer extends BaseServer
{
    public function onMessage(ConnectionInterface $from, $data) {
        parent::onMessage($from, $data);

        try {
            $message = new Message($data);
            $this->executeCallback('onMessage', $from, $message);
        }
        catch (\Exception $e) {
            echo "Invalid message on connection {$from->resourceId} : {$e->getMessage()}\n";
            print_r($data);
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        parent::onOpen($conn);
        $this->executeCallback('onOpen', $conn);
    }

    public function onClose(ConnectionInterface $conn) {
        parent::onClose($conn);
        $this->executeCallback('onClose', $conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        parent::onError($conn, $e);
        unset($this->clients[$conn->resourceId]);
        $this->executeCallback('onError', $conn);
        $this->onClose($conn);
    }
}