<?php
namespace GC\WebSocket;




class Client
{



	public function __construct($connection) {
		$this->connection=$connection;
	}
	
	
	public function getId() {
		return $this->connection->getId();
	}
	
	
	public function send($message) {
		return $this->connection->send($message);
	}
	
	
	public function toArray() {
		return array(
			'id'=>$this->getId()
		);
	}

}