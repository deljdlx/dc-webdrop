

function WebDropUser(client, id)
{
	this.client=client;
	this.element=null;
	this.id=id;
}


WebDropUser.prototype.getElement=function() {
	if(!this.element) {
		this.element=document.createElement('div');
		this.element.manager=this;
		this.element.setAttribute('data-id', this.id);
		this.element.className='webDropUser';
		this.element.addEventListener("dragenter", this.dragEnter, false);
		this.element.addEventListener("dragover", this.dragOver, false);
		this.element.addEventListener("drop", this.drop, false);
		this.element.innerHTML='<span class="userName"></span>';

		this.element.addEventListener('click', (e) => {
			const fileInput = document.querySelector('#fileInput');

			if(!fileInput.initialized) {
				fileInput.addEventListener('change', (e) => {
					this.sendFiles(e.target.files);
				});
				fileInput.initialized=true;
			}
			fileInput.click();
		});
	}
	return this.element
}

WebDropUser.prototype.setUserName=function(userName) {
	this.getElement().querySelector('.userName').textContent=userName;
}

WebDropUser.prototype.dragEnter=function(e) {
	e.stopPropagation();
	e.preventDefault();
}

WebDropUser.prototype.dragOver=function(e) {
	e.stopPropagation();
	e.preventDefault();
}

WebDropUser.prototype.drop=function(e) {

	e.stopPropagation();
	e.preventDefault();
	var dt = e.dataTransfer;
	var files = dt.files;
	this.manager.sendFiles(files);
}


WebDropUser.prototype.sendFiles=function(files) {
	for (var i = 0; i < files.length; i++) {
		console.debug('call send');
		var uploader=new WebDropFileUpload(this.client, files[i], this.id);
		uploader.send();
	}
}














