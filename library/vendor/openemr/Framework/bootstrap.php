<?php
/**
 * Define paths to openemr and vendor dir for use in plugins
 */
if ( !defined( 'OPENEMR_DIRECTORY' ) ) {
    define( 'OPENEMR_DIRECTORY', realpath( __DIR__.'/../' ) );
}

set_include_path( get_include_path() . PATH_SEPARATOR . OPENEMR_DIRECTORY );

if ( !defined( 'Mi2_DIRECTORY' ) ) {
    define( 'Mi2_DIRECTORY', realpath( __DIR__ ) );
}

set_include_path( get_include_path() . PATH_SEPARATOR . Mi2_DIRECTORY );

if ( !defined( 'VENDOR_DIR' ) ) {
    define( 'VENDOR_DIR', realpath( __DIR__.'/system' ) );
}

set_include_path( get_include_path() . PATH_SEPARATOR . SYSTEM_DIRECTORY );

include_once SYSTEM_DIRECTORY . '/autoload.php';
if ( method_exists( '\Library\Framework\Plugin\PS', 'init' ) ) {
    \Library\Framework\Plugin\PS::init();
} else {
    error_log( "Could not initialize the plugin system" );
}
