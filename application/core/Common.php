<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

if (is_dir ( $application_folder )) {
	define ( 'APPPATH', $application_folder . '/' );
} else {
	if (! is_dir ( BASEPATH . $application_folder . '/' )) {
		exit ( "Your application folder path does not appear to be set correctly. Please open the following file and correct this: " . SELF );
	}
	
	define ( 'APPPATH', BASEPATH . $application_folder . '/' );
}