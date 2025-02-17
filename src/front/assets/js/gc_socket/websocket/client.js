class GC_Client {

	constructor(url, login) {
		this.url=url;
		this.id=null;
		this.socket=null;
		this.login=login;
		this.handlers={};
	}


 	setURL(url) {
		this.url=url;
	}



	send(messageType, data) {
		this.socket.send(new GC_ClientMessage(messageType, data).stringify());
	}


 	on(eventName, callback) {
		this.handlers[eventName]=callback;
 	}



 	handleMessage(message) {

		console.log('%cclient.js :: 29 =============================', 'color: #f00; font-size: 1rem');
		console.log(message);

		var data=JSON.parse(message.data);

		if(typeof(this.handlers[data.type])!='undefined') {
			//console.debug('handling');
			return this.handlers[data.type](data);
		}
		else {
			//console.debug(data);
		}
	}
	close() {
		this.socket.close();
	}

	connect() {
		this.socket=new WebSocket(this.url);

		var self=this;

		this.socket.onmessage=(message) => {
			this.handleMessage(message);
		}
	}

}



