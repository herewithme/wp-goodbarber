<?php

class GB_JSON_API_Tag {

	public $id;          // Integer
	public $slug;        // String
	public $title;       // String
	public $description; // String
	public $post_count;  // Integer

	public function __construct( $wp_tag = null ) {
		if ( $wp_tag ) {
			$this->import_wp_object( $wp_tag );
		}
	}

	public function import_wp_object( $wp_tag ) {
		$this->id          = (int) $wp_tag->term_id;
		$this->slug        = $wp_tag->slug;
		$this->title       = $wp_tag->name;
		$this->description = $wp_tag->description;
		$this->post_count  = (int) $wp_tag->count;
	}

}
