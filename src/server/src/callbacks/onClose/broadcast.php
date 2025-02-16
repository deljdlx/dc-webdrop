<?php

use WebDrop\Message;

$server->broadcast(
    new Message([
        'type' => 'disconnect',
        'data' => [
            'message' => 'A user has disconnected',
            'id' => $connection->resourceId
        ]
    ])
);

