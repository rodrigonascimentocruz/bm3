<?php
class RoyalPosts {
	
	// Initialization
	public static function init( ) {
		// Register our clients
		$args = array(
			'labels'             => array(
				'name'                 => __( 'Clients', 'royal' ),
				'singular_name'        => __( 'Clients', 'royal' ),
				'add_new'              => __( 'Add New', 'royal' ),
				'add_new_item'         => __( 'Add New Client', 'royal' ),
				'edit_item'            => __( 'Edit Client', 'royal' ),
				'new_item'             => __( 'New Client', 'royal' ),
				'all_items'            => __( 'All Clients', 'royal' ),
				'view_item'            => __( 'View Clients', 'royal' ),
				'search_items'         => __( 'Search Clients', 'royal' ),
				'not_found'            => __( 'No Client found', 'royal' ),
				'not_found_in_trash'   => __( 'No Client found in Trash', 'royal' ),
				'menu_name'            => __( 'Our Clients', 'royal' ),
				'parent_item_colon'    => '',
			),
			'exclude_from_search' => true,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __( 'our-clients', 'royal' ) ),
			'capability_type'     => 'page',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-heart',
			'supports'            => array( 'title', 'thumbnail' )
		); 
		register_post_type( 'our-clients', $args );

		// Register our team
		$args = array(
			'labels'             => array(
				'name'                 => __( 'Our Team', 'royal' ),
				'singular_name'        => __( 'Our Team', 'royal' ),
				'add_new'              => __( 'Add New', 'royal' ),
				'add_new_item'         => __( 'Add New Member', 'royal' ),
				'edit_item'            => __( 'Edit Member', 'royal' ),
				'new_item'             => __( 'New Member', 'royal' ),
				'all_items'            => __( 'All Members', 'royal' ),
				'view_item'            => __( 'View Members', 'royal' ),
				'search_items'         => __( 'Search Members', 'royal' ),
				'not_found'            => __( 'No Member found', 'royal' ),
				'not_found_in_trash'   => __( 'No Member found in Trash', 'royal' ),
				'menu_name'            => __( 'Our Team', 'royal' ),
				'parent_item_colon'    => '',
			),
			'exclude_from_search' => true,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __( 'our-team', 'royal' ) ),
			'capability_type'     => 'page',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'thumbnail' ),
		); 
		register_post_type( 'our-team', $args );

		// Register portfolio taxonomy
		$args = array(
			'hierarchical'       => true,
			'labels'             => array(
				'name'                => __( 'Category', 'royal' ),
				'singular_name'       => __( 'Category', 'royal' ),
				'search_items'        => __( 'Search Categories', 'royal' ),
				'all_items'           => __( 'All Categories', 'royal' ),
				'parent_item'         => __( 'Parent Category', 'royal' ),
				'parent_item_colon'   => __( 'Parent Category:', 'royal' ),
				'edit_item'           => __( 'Edit Category', 'royal' ), 
				'update_item'         => __( 'Update Category', 'royal' ),
				'add_new_item'        => __( 'Add New Category', 'royal' ),
				'new_item_name'       => __( 'New Category', 'royal' ),
				'menu_name'           => __( 'Categories', 'royal' ),
			),
			'show_ui'            => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolio-category' )
		);
		register_taxonomy( 'portfolio-category', 'portfolio', $args );

		// Register portfolio
		$args = array(
			'labels'             => array(
				'name'                 => __( 'Portfolio', 'royal' ),
				'singular_name'        => __( 'Portfolio', 'royal' ),
				'add_new'              => __( 'Add New', 'royal' ),
				'add_new_item'         => __( 'Add New Item', 'royal' ),
				'edit_item'            => __( 'Edit Item', 'royal' ),
				'new_item'             => __( 'New Item', 'royal' ),
				'all_items'            => __( 'All Items', 'royal' ),
				'view_item'            => __( 'View Items', 'royal' ),
				'search_items'         => __( 'Search Items', 'royal' ),
				'not_found'            => __( 'No Item found', 'royal' ),
				'not_found_in_trash'   => __( 'No Item found in Trash', 'royal' ),
				'menu_name'            => __( 'Portfolio', 'royal' ),
				'parent_item_colon'    => '',
			),
			'exclude_from_search' => true,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __( 'portfolio', 'royal' ) ),
			'capability_type'     => 'page',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-portfolio',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'portfolio-category' ),
			'taxonomies'          => array( 'portfolio-category' ),
		);
		register_post_type( 'portfolio', $args );
	}
	
}

add_action( 'init', array( 'RoyalPosts', 'init' ) );