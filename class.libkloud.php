<?php

class libkloud {
    
    private $drivers = array(
	'rackspace',
	'ec2'
    );
    private $drivers_folder = './drivers/';
    public $providers;
    
    public function __construct( $providers ) {
	if( is_array( $providers ) ) {
	    if( @require_once( $this->drivers_folder.'class.driver.php' ) ) {
	        foreach( $providers as $provider => $credentials ) {
		    if( in_array( $provider, $this->drivers ) ) {
			 $this->drivers_load( $provider, $credentials );
		    }
		}
	    }
	}
    }
    
    private function __call( $func, $args ) {
	$return = array();
	foreach( array_keys( $this->providers ) as $provider ) {
	    if( method_exists( $this->providers[$provider], $func ) ) {
		$return[$provider] = $this->providers[$provider]->$func( $args );
	    }
	}
	return $return;
    }
    
    private function drivers_load( $provider, $credentials ) {
	if( @include_once( $this->drivers_folder.'class.driver.'.$provider.'.php' ) ) {
	    $class = 'driver_'.$provider;
	    if( class_exists( $class ) ) {
		$this->providers[$provider] = new $class( $this, $credentials );
	    }
	}
    }
    
    public function drivers_loaded() {
	return array_keys( $this->providers );
    }
    
    public function drivers_list() {
	return $this->drivers;
    }
    
}

?>