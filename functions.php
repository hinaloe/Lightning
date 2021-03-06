<?php
/*-------------------------------------------*/
/*	Theme setup
/*-------------------------------------------*/
/*	Load JS and CSS
/*-------------------------------------------*/
/*	Head logo
/*-------------------------------------------*/
/*	WidgetArea initiate
/*-------------------------------------------*/
/*	Year Artchive list 'year' and count insert to inner </a>
/*-------------------------------------------*/
/*	Category list 'count insert to inner </a>
/*-------------------------------------------*/
/*	Head title
/*-------------------------------------------*/
/*	Global navigation add cptions
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Theme setup
/*-------------------------------------------*/
add_action('after_setup_theme', 'lightning_theme_setup');

function lightning_theme_setup() {

	global $content_width;

	/*-------------------------------------------*/
	/*	Admin page _ Eye catch
	/*-------------------------------------------*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 320, 180, true );

	/*-------------------------------------------*/
	/*	Custom menu
	/*-------------------------------------------*/
	register_nav_menus( array( 'Header' => 'Header Navigation', ) );
	register_nav_menus( array( 'Footer' => 'Footer Navigation', ) );

	load_theme_textdomain('lightning', get_template_directory() . '/languages');

	/*-------------------------------------------*/
	/*	Set content width
	/* 	(Auto set up to media max with.)
	/*-------------------------------------------*/
	if ( ! isset( $content_width ) ) $content_width = 750;

	/*-------------------------------------------*/
	/*	Admin page _ Add editor css
	/*-------------------------------------------*/
	add_editor_style('/css/editor.css');
	add_editor_style('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css');

	add_theme_support( 'automatic-feed-links' );
}

/*-------------------------------------------*/
/*	Load JS and CSS
/*-------------------------------------------*/

add_action('wp_enqueue_scripts','lightning_addJs');
function lightning_addJs(){
	wp_register_script( 'lightning-js' , get_template_directory_uri().'/js/all.min.js', array('jquery'), '20150918a' );
	wp_enqueue_script( 'lightning-js' );
}

add_action( 'wp_enqueue_scripts', 'lightning_commentJs' );
function lightning_commentJs(){
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action('wp_enqueue_scripts', 'lightning_css' );
function lightning_css(){
	wp_enqueue_style( 'lightning-font-awesome-style', get_template_directory_uri().'/css/font-awesome/4.3.0/css/font-awesome.min.css', array(), '20150622' );
	wp_enqueue_style( 'lightning-design-style', get_template_directory_uri().'/css/style.css', array(), '20150918a' );
	wp_enqueue_style( 'lightning-theme-style', get_stylesheet_uri(), array('lightning-design-style'), '20150814');
}

/*-------------------------------------------*/
/*	Load Theme customizer
/*-------------------------------------------*/
require( get_template_directory() . '/functions_customizer.php' );

/*-------------------------------------------*/
/*	Load helpers
/*-------------------------------------------*/
require( get_template_directory() . '/functions_helpers.php' );

/*-------------------------------------------*/
/*	Load tga(Plugin install)
/*-------------------------------------------*/
require( get_template_directory() . '/functions_plugin_install.php' );

/*-------------------------------------------*/
/*	WidgetArea initiate
/*-------------------------------------------*/
function lightning_widgets_init() {
	// sidebar widget area
		register_sidebar( array(
			'name' => __('Sidebar(Home)', 'lightning' ),
			'id' => 'front-side-top-widget-area',
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title subSection-title">',
			'after_title' => '</h1>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar(Common top)', 'lightning' ),
			'id' => 'common-side-top-widget-area',
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title subSection-title">',
			'after_title' => '</h1>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar(Common bottom)', 'lightning' ),
			'id' => 'common-side-bottom-widget-area',
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title subSection-title">',
			'after_title' => '</h1>',
		) );


	// Sidebar( post_type )

		$postTypes = get_post_types(Array('public' => true));
		
		foreach ($postTypes as $postType) {

			// Get post type name
			/*-------------------------------------------*/
			$post_type_object = get_post_type_object($postType);
			if($post_type_object){
				// Set post type name
				$postType_name = esc_html($post_type_object->labels->name);

				// Set post type widget area
				register_sidebar( array(
					'name' => sprintf( __( 'Sidebar(%s)', 'lightning' ), $postType_name ),
					'id' => $postType.'-side-widget-area',
					'description' => sprintf( __( 'This widget area appears on the %s contents page only.', 'lightning' ), $postType_name ),
					'before_widget' => '<aside class="widget %2$s" id="%1$s">',
					'after_widget' => '</aside>',
					'before_title' => '<h1 class="widget-title subSection-title">',
					'after_title' => '</h1>',
				) );
			} // if($post_type_object){

		} // foreach ($postTypes as $postType) {

	// Home content top widget area

		register_sidebar( array(
			'name' => __( 'Home content top', 'lightning' ),
			'id' => 'home-content-top-widget-area',
			'before_widget' => '<section class="widget %2$s" id="%1$s">',
			'after_widget' => '</section>',
			'before_title' => '<h1 class="mainSection-title">',
			'after_title' => '</h1>',
		) );

	// footer upper widget area

		register_sidebar( array(
			'name' => __( 'Widget area of upper footer', 'lightning' ),
			'id' => 'footer-upper-widget-1',
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title subSection-title">',
			'after_title' => '</h1>',
		) );

	// footer widget area
	for ( $i = 1; $i <= 3 ;) {
		register_sidebar( array(
			'name' => __( 'Footer widget area ', 'lightning' ).$i,
			'id' => 'footer-widget-'.$i,
			'before_widget' => '<aside class="widget %2$s" id="%1$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title subSection-title">',
			'after_title' => '</h1>',
		) );
		$i++;
	}
}
add_action( 'widgets_init', 'lightning_widgets_init' );

/*-------------------------------------------*/
/*	Year Artchive list 'year' and count insert to inner </a>
/*-------------------------------------------*/
function lightning_archives_link($html){
  return preg_replace('@</a>(.+?)</li>@', '\1</a></li>', $html);
}
add_filter('get_archives_link', 'lightning_archives_link');

/*-------------------------------------------*/
/*	Category list 'count insert to inner </a>
/*-------------------------------------------*/
function lightning_list_categories( $output, $args ) {
	$output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
	return $output;
}
add_filter( 'wp_list_categories', 'lightning_list_categories', 10, 2 );

/*-------------------------------------------*/
/*	Head title
/*-------------------------------------------*/
add_filter('wp_title','lightning_wp_head_frontPage_title');
function lightning_wp_head_frontPage_title($title){
	if (is_front_page()) {
		$title = get_bloginfo('name');
	}
	return $title;
}
/*-------------------------------------------*/
/*	Global navigation add cptions
/*-------------------------------------------*/
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$prepend = '<strong class="gMenu_name">';
		$append = '</strong>';
		$description  = ! empty( $item->description ) ? '<span class="gMenu_description">'.esc_attr( $item->description ).'</span>' : '';

		if($depth != 0) {
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
