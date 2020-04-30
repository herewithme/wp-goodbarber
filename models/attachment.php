<?php

class GB_JSON_API_Attachment {

	public $id;          // Integer
	public $url;         // String
	public $slug;        // String
	public $title;       // String
	public $description; // String
	public $caption;     // String
	public $parent;      // Integer
	public $mime_type;   // String
	public $images;      // Array

	public function __construct( $wp_attachment = null ) {
		if ( $wp_attachment ) {
			$this->import_wp_object( $wp_attachment );
			if ( $this->is_image() ) {
				$this->query_images();
			}
		}
	}

	public function import_wp_object( $wp_attachment ) {
		$this->id          = (int) $wp_attachment->ID;
		$this->url         = $wp_attachment->guid;
		$this->slug        = $wp_attachment->post_name;
		$this->title       = $wp_attachment->post_title;
		$this->description = $wp_attachment->post_content;
		$this->caption     = $wp_attachment->post_excerpt;
		$this->parent      = (int) $wp_attachment->post_parent;
		$this->mime_type   = $wp_attachment->post_mime_type;
	}

	public function is_image() {
		return ( strpos( $this->mime_type, 'image' ) === 0 );
	}

	public function query_images() {
		$sizes = array( 'thumbnail', 'medium', 'large', 'full' );
		if ( function_exists( 'get_intermediate_image_sizes' ) ) {
			$sizes = array_merge( array( 'full' ), get_intermediate_image_sizes() );
		}
		
		$this->images = array();
		foreach ( $sizes as $size ) {
			list( $url, $width, $height ) = wp_get_attachment_image_src( $this->id, $size );
			$this->images[ $size ] = (object) array(
				'url'    => $url,
				'width'  => $width,
				'height' => $height
			);
		}
	}

}


