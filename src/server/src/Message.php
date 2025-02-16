<?php
namespace WebDrop;

class Message
{
    protected $rawMessage;

    public readonly string $type;
    public readonly array $data;

    public function __construct($rawMessage)
    {
        if(is_array($rawMessage)) {
            if(!isset($rawMessage['type']) || !isset($rawMessage['data'])) {
                throw new \Exception('Invalid message');
            }
            $this->type = $rawMessage['type'];
            $this->data = $rawMessage['data'];
            return;
        }
        $this->rawMessage = $rawMessage;
        $this->parseMessage();
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function parseMessage()
    {
        $message = json_decode($this->rawMessage, true);
        if($message === null) {
            throw new \Exception('Invalid JSON');
        }
        $this->type = $message['type'];
        $this->data = $message['data'];
    }

    public function __toString()
    {
        $json = json_encode([
            'type' => $this->type,
            'data' => $this->data
        ]);
        return $json;
    }

}
