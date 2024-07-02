<?php

// Define the base directory for class files
define( 'CLASS_DIR', __DIR__ . '/../' );

// Autoloader function
function my_autoloader( $class ) {
	// Convert the class name to a file path
	$file = CLASS_DIR . $class . '.php';

	// Check if the file exists
	if ( file_exists( $file ) ) {
		// Include the class file
		include $file;
	}
}

// Register the autoloader function
spl_autoload_register( 'my_autoloader' );
