<?php

use WebDrop\Message;

$server->sendTo(
    $connection->resourceId,
    new Message([
        'type' => 'connect',
        'data' => [
            'message' => 'A new user has connected',
            'id' => $connection->resourceId
        ]
    ])
);


$users = [];
foreach($server->getClients() as $client) {
    $users[] = [
        'id' =>$client->resourceId,
        'data' => $server->getClientData($client->resourceId)
    ];
}
$server->broadcast(new Message([
    'type' => 'userList',
    'data' => $users,
]));

