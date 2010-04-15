<?php

class driver {
    
    private $parent;
    private $username;
    private $password;
    private $token;
    
    public function __construct( $parent, $credentials ) {
	$this->parent = $parent;
	$this->username = $credentials[0];
	$this->password = $credentials[1];
	print_r( $this->username );
	print_r( $this->password );
    }
}

?>