class WebDropClient
{

	client;
	connectionId;

	constructor(client) {

		this.client = client;

		const userNameInput = document.querySelector('#userName');

		this.client.on('connect', (payload) => {
			console.log('%cwebdropclient.js :: 14 =============================', 'color: #f00; font-size: 1rem');
			console.log("Connected");
			this.connectionId=payload.data.id;
			const userName = this.generateFakeUserNames();
			userNameInput.value = userName;
			this.client.send('setUserName', {
				userName: userName
			});
		});

		userNameInput.addEventListener('input', (e) => {
			this.client.send('setUserName', {
				userName: e.target.value
			});
		});

		this.client.on('userNameChanged', (payload) => {
			if (this.connectionId === payload.data.id) {
				return;
			}
			const userContainer = document.querySelector('*[data-id="'+payload.data.id+'"]');
			if (userContainer) {
				userContainer.querySelector('.userName').textContent = payload.data.userName;
			}
		});


		this.client.on('disconnect', (payload) => {
			const userContainer = document.querySelector('*[data-id="'+payload.data.id+'"]');
			if (userContainer) {
				userContainer.remove();
			}
		});


		this.client.on('userList', (data) => {
			var container=jQuery('.userList');
			var userlist=data.data;
			console.log('%cwebdropclient.js :: 23 =============================', 'color: #f00; font-size: 1rem');
			console.log(data.data);

			for(var i=0; i<userlist.length; i++) {
				if(userlist[i].id==this.connectionId) {
					continue;
				}

				let userContainer = document.querySelector('*[data-id="'+userlist[i].id+'"]');

				if(!userContainer) {
					userContainer=document.createElement('div');
					var user = new WebDropUser(client, userlist[i].id);
					var element = user.getElement();
					userContainer.appendChild(element);
					container.append(userContainer);
					user.setUserName(userlist[i].data.userName);
				}
			}
		});

		this.client.on('downloadFile', function(data) {
			var iframe=document.getElementById('download');
			iframe.src=data.data.file
		});
	}


	generateFakeUserNames=function() {
		const animals  = [
			'Antelope', 'Bear', 'Cat', 'Dog', 'Elephant', 'Frog', 'Giraffe', 'Horse', 'Iguana', 'Jaguar', 'Kangaroo', 'Lion', 'Monkey', 'Newt', 'Owl', 'Penguin', 'Quail', 'Rabbit', 'Snake', 'Tiger', 'Uakari', 'Vulture', 'Walrus', 'Xerus', 'Yak', 'Zebra'
		]

		const adjectives = [
			'Awesome', 'Brave', 'Clever', 'Daring', 'Eager', 'Fierce', 'Gentle', 'Happy', 'Intelligent', 'Jolly', 'Kind', 'Loyal', 'Merry', 'Nice', 'Obedient', 'Proud', 'Quick', 'Rapid', 'Strong', 'Tough', 'Unique', 'Vigorous', 'Wise', 'Xenial', 'Young', 'Zealous'
		]

		const colors = [
			'Amber', 'Blue', 'Crimson', 'Dandelion', 'Emerald', 'Fuchsia', 'Gold', 'Honey', 'Indigo', 'Jade', 'Kale', 'Lavender', 'Magenta', 'Navy', 'Olive', 'Pink', 'Quartz', 'Red', 'Sapphire', 'Turquoise', 'Ultramarine', 'Violet', 'White', 'Xanadu', 'Yellow'
		];

		const animal = animals[Math.floor(Math.random() * animals.length)];
		const adjective = adjectives[Math.floor(Math.random() * adjectives.length)];
		const color = colors[Math.floor(Math.random() * colors.length)];

		return `${color} ${adjective} ${animal}`;
	}

	connect(url) {
		var self=this;
		jQuery.ajax({
			url: url,
			success: function(data) {
				self.client.setURL('wss://'+data.host+':'+data.port+'/'+data.serviceName);
				self.client.connect();
			}
		});
	}
}



