<?php

$ini = parse_ini_file("autoload.ini",true);
print_r(  $ini );

//function tf( bool $b ): string {
//	return $b
//		? "sections"
//		: "raw";
//}
//
//function sm( int $sm ): string {
//	return match ( $sm ) {
//		INI_SCANNER_NORMAL => "normal",
//		INI_SCANNER_RAW => "raw",
//		INI_SCANNER_TYPED => "typed",
//		default => "unknown",
//	};
//}
//foreach ( [ true, false ] as $process_sections ) {
//	foreach ( [ INI_SCANNER_NORMAL, INI_SCANNER_RAW, INI_SCANNER_TYPED ] as $scanner_mode ) {
//		printf( "\n\n\nparse_ini_file(autoload.ini,%s,%s);" , tf($process_sections), sm($scanner_mode) );
//		print_r( parse_ini_file( "autoload.ini", $process_sections, $scanner_mode ) );
//	}
//}
