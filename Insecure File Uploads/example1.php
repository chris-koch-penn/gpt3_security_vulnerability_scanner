<?php

if( isset( $_POST[ 'Upload' ] ) ) {
	// Where are we going to be writing to?
	$target_path  = DVWA_WEB_PAGE_TO_ROOT . "static/uploads/";
	$target_path .= basename( $_FILES[ 'uploaded' ][ 'name' ] );

	// Can we move the file to the upload folder?
	if( !move_uploaded_file( $_FILES[ 'uploaded' ][ 'tmp_name' ], $target_path ) ) {
		$html .= '<pre>Your image was not uploaded.</pre>';
	}
	else {
		$html .= "<pre>{$target_path} succesfully uploaded!</pre>";
	}
}

?>
