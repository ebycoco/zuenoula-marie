<?php
session_start();

require '../../database/connexionbasedonne.php';
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/'.$_SESSION['Admin_id']; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['avatar']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

	if (!file_exists($targetPath)) {
		mkdir($targetPath,0755,true);
	}

	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['avatar']['name']);
	$randomFileName = md5(uniqid(rand())) .'.'. $fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . $randomFileName;
	
	
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		if (move_uploaded_file($tempFile, $targetFile)) {
			$q = $db->prepare('UPDATE administrateur SET avatar = ? WHERE id = ?');
			$q->execute([$targetFolder. '/' . $randomFileName, $_POST['Admin_id']]);
			$_SESSION['avatar'] = $targetFolder.'/' . $randomFileName;
		} 
			
		
		echo '1';
	} else {
		echo 'Type de fichier invalide.';
	}
}
?>