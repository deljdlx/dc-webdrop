<?php
$fileId=preg_replace('`\W`', '', $_GET['fileId']);

if(!is_dir(realpath('/uploads'))) {
	mkdir(realpath('/uploads'));
}

$filepath = realpath('/uploads').'/'.$fileId;


if(is_file($filepath.'/meta.json') && is_file($filepath.'/file.data')) {

	$data=json_decode(file_get_contents($filepath.'/meta.json'));
	header("Content-Type: application/force-download; name=\"" .$data->name. "\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".$data->size);
	header("Content-Disposition: attachment; filename=\"" . $data->name . "\"");
	header("Expires: 0");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	readfile($filepath.'/file.data');

	unlink($filepath.'/meta.json');
	unlink($filepath.'/file.data');
	rmdir($filepath);

	exit();
}
else {
	header("HTTP/1.0 404 Not Found");
}



