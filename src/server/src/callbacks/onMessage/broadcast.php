<?php

use WebDrop\Message;
echo 'New message from ' . $connection->resourceId . "\n";
print_r($message);

$server->broadcast(new Message([
    'type' => 'message',
    'data' => [
        'message' => $message,
        'id' => $connection->resourceId
    ]
]));

if($message->getType() === 'fileUploaded') {
    $fileData = $message->data['fileData'];
    $server->sendTo(
        $message->data['userId'],
        new Message([
            'type' => 'downloadFile',
            'data' => [
                'file' => 'download.php?fileId=' . $fileData['fileId']
            ]
        ])
    );
}

if($message->getType() === 'setUserName') {
    $userName = $message->data['userName'];
    $server->setClientData(
        $connection->resourceId,
        'userName',
        $userName
    );
    $server->broadcast(
        new Message([
            'type' => 'userNameChanged',
            'data' => [
                'userName' => $userName,
                'id' => $connection->resourceId
            ]
        ])
    );
}
