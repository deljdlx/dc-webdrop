class WebDropFileUpload {


	constructor(client, file, clientId) {
		this.client=client;
		this.reader = new FileReader();
		this.xhr=new XMLHttpRequest();
		this.file=file;

		this.clientId=clientId;

		var self = this;

		this.xhr.upload.addEventListener("progress", function(e) {
			if (e.lengthComputable) {
				var percentage = Math.round((e.loaded * 100) / e.total);
			}
		}, false);


		this.xhr.addEventListener("load", function(e) {
			self.client.send('fileUploaded', {
				fileData: JSON.parse(self.xhr.responseText),
				userId:self.clientId
			});
		}, true);

		//this.send();
	}


	send() {

		console.debug('send');

		var self=this;

		var formData = new FormData();
		formData.append(this.file.name, this.file, this.file.name);

		this.reader.readAsBinaryString(this.file);
		this.reader.onload = function(evt) {
			self.xhr.send(formData);
		};


		this.xhr.open("POST", "upload.php");
		this.xhr.overrideMimeType(this.file.type);

	}
}
