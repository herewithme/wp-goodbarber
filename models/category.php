<?php

class GB_JSON_API_Category {

	public $id;          // Integer
	public $slug;        // String
	public $title;       // String
	public $description; // String
	public $parent;      // Integer
	public $post_count;  // Integer

	public function __construct( $wp_category = null ) {
		if ( $wp_category ) {
			$this->import_wp_object( $wp_category );
		}
	}

	public function import_wp_object( $wp_category ) {
		$this->id          = (int) $wp_category->term_id;
		$this->slug        = $wp_category->slug;
		$this->title       = $wp_category->name;
		$this->description = $wp_category->description;
		$this->parent      = (int) $wp_category->parent;
		$this->post_count  = (int) $wp_category->count;
	}

}
