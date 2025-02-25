<?php
if(!empty($_FILES)) {
	foreach($_FILES as $file) {

		$fileId=uniqid(true);

		$uploadFilepath = realpath('/uploads');
		$filepath = $uploadFilepath . '/' . $fileId;
		$pathCreated = mkdir($filepath);
		if(!$pathCreated) {
			header('Content-Type: application/json');
			echo json_encode([
				'error' => 'Could not create directory',
				'filepath' => $filepath,
			]);
			exit();
		}

		$result = move_uploaded_file($file['tmp_name'], $filepath.'/file.data');
		file_put_contents($filepath.'/meta.json', json_encode($file));

		header('Content-Type: application/json');
		echo json_encode([
			'fileId' => $fileId,
			'path' => $filepath,
		]);
	}
	exit();
}
