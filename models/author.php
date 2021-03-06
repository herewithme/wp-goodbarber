<?php

class GB_JSON_API_Author {

	public $id;          // Integer
	public $slug;        // String
	public $name;        // String
	public $first_name;  // String
	public $last_name;   // String
	public $nickname;    // String
	public $url;         // String
	public $description; // String
	public $avatarUrl;   // String

	public function __construct( $id = null ) {
		if ( $id ) {
			$this->id = (int) $id;
		} else {
			$this->id = (int) get_the_author_meta( 'ID' );
		}
		$this->set_value( 'slug', 'user_nicename' );
		$this->set_value( 'name', 'display_name' );
		$this->set_value( 'first_name', 'first_name' );
		$this->set_value( 'last_name', 'last_name' );
		$this->set_value( 'nickname', 'nickname' );
		$this->set_value( 'url', 'user_url' );
		$this->set_value( 'description', 'description' );
		$this->set_author_meta();

		if ( function_exists( 'get_avatar_url' ) ) {
			$this->avatarUrl = get_avatar_url( $this->id, array( 'size' => 512 ) );
		}
		//$this->raw = get_userdata($this->id);
	}

	public function set_value( $key, $wp_key = false ) {
		if ( ! $wp_key ) {
			$wp_key = $key;
		}
		$this->$key = get_the_author_meta( $wp_key, $this->id );
	}

	public function set_author_meta() {
		global $gb_json_api;
		if ( ! $gb_json_api->query->author_meta ) {
			return;
		}
		$protected_vars = array(
			'user_login',
			'user_pass',
			'user_email',
			'user_activation_key'
		);
		$vars           = explode( ',', $gb_json_api->query->author_meta );
		$vars           = array_diff( $vars, $protected_vars );
		foreach ( $vars as $public ) {
			$this->set_value( $public );
		}
	}

}

