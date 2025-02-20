<?php

require_once get_template_directory() . '/includes/loader.php';

add_action( 'after_setup_theme', 'charityhome_setup_theme' );
add_action( 'after_setup_theme', 'charityhome_load_default_hooks' );


function charityhome_setup_theme() {

	load_theme_textdomain( 'charityhome', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );


	// Set the default content width.
	$GLOBALS['content_width'] = 525;
	
	/*---------- Register image sizes ----------*/
	
	//Register image sizes
	add_image_size( 'charityhome_270x250', 270, 250, true ); //'team_v1'
	add_image_size( 'charityhome_540x500', 540, 500, true ); //'team_v2'
	add_image_size( 'charityhome_270x250', 270, 250, true ); //'team_v3'
	add_image_size( 'charityhome_360x270', 360, 270, true ); //'blogs_v1'
	add_image_size( 'charityhome_380x320', 380, 320, true ); //'gallery_v1'
	add_image_size( 'charityhome_500x400', 500, 400, true ); //'blogs_v2'
	add_image_size( 'charityhome_105x105', 105, 105, true ); //'testimonials_v2'
	add_image_size( 'charityhome_500x400', 500, 400, true ); //'services_v2'
	add_image_size( 'charityhome_260x385', 260, 385, true ); //'charityhome_260x385 services_v2'
	add_image_size( 'charityhome_180x120', 180, 120, true ); //'charityhome_180x120 services_v2'
	add_image_size( 'charityhome_360x220', 360, 220, true ); //'charityhome_360x220 Recent Causes'
	add_image_size( 'charityhome_570x350', 570, 350, true ); //'charityhome_570x350 Recent Causes V3'
	add_image_size( 'charityhome_358x240', 358, 240, true ); //'charityhome_358x240 Upcoming Event'
	add_image_size( 'charityhome_460x300', 460, 300, true ); //'charityhome_460x300 Event List View'
	add_image_size( 'charityhome_380x320', 380, 320, true ); //'charityhome_380x320 Gallery Mixitup
	add_image_size( 'charityhome_360x220', 360, 220, true ); //'charityhome_360x220 Blog Grid View
	add_image_size( 'charityhome_1170x400', 1170, 400, true ); //'charityhome_360x220 Our  Blog
	
	
	/*---------- Register image sizes ends ----------*/
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'main_menu' => esc_html__( 'Main Menu', 'charityhome' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'      => 250,
		'height'     => 250,
		'flex-width' => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style();
	add_action( 'admin_init', 'charityhome_admin_init', 2000000 );
}

/**
 * [charityhome_admin_init]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */


function charityhome_admin_init() {
	remove_action( 'admin_notices', array( 'ReduxFramework', '_admin_notices' ), 99 );
}

/*---------- Sidebar settings ----------*/

/**
 * [charityhome_widgets_init]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */
function charityhome_widgets_init() {

	global $wp_registered_sidebars;

	$theme_options = get_theme_mod( 'charityhome' . '_options-mods' );

	register_sidebar( array(
		'name'          => esc_html__( 'Default Sidebar', 'charityhome' ),
		'id'            => 'default-sidebar',
		'description'   => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'charityhome' ),
		'before_widget'=>'<div id="%1$s" class="widget sidebar-widget %2$s">',
	    'after_widget'=>'</div>',
	    'before_title' => '<h3 class="title">',
	    'after_title' => '</h3>'
	) );
	register_sidebar(array(
		'name' => esc_html__('Footer Widget', 'charityhome'),
		'id' => 'footer-sidebar',
		'description' => esc_html__('Widgets in this area will be shown in Footer Area.', 'charityhome'),
		'before_widget'=>'<div class="col-lg-3 col-md-6 col-sm-12 footer-column "><div id="%1$s" class="footer-widget %2$s">',
		'after_widget'=>'</div></div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>'
	));
	if ( class_exists( '\Elementor\Plugin' )){
	register_sidebar(array(
	  'name' => esc_html__( 'Blog Listing', 'charityhome' ),
	  'id' => 'blog-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'charityhome' ),
	  'before_widget'=>'<div id="%1$s" class="sidebar-widget widget %2$s">',
	  'after_widget'=>'</div>',
	  'before_title' => '<h3 class="title">',
	  'after_title' => '</h3>'
	));
	}
	if ( ! is_object( charityhome_WSH() ) ) {
		return;
	}

	$sidebars = charityhome_set( $theme_options, 'custom_sidebar_name' );

	foreach ( array_filter( (array) $sidebars ) as $sidebar ) {

		if ( charityhome_set( $sidebar, 'topcopy' ) ) {
			continue;
		}

		$name = $sidebar;
		if ( ! $name ) {
			continue;
		}
		$slug = str_replace( ' ', '_', $name );

		register_sidebar( array(
			'name'          => $name,
			'id'            => sanitize_title( $slug ),
			'before_widget' => '<div id="%1$s" class="%2$s widget sidebar-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title">',
			'after_title'   => '</h3>',
		) );
	}

	update_option( 'wp_registered_sidebars', $wp_registered_sidebars );
}

add_action( 'widgets_init', 'charityhome_widgets_init' );

/*---------- Sidebar settings ends ----------*/

add_filter('doing_it_wrong_trigger_error', function () {return false;}, 10, 0);

/*---------- Gutenberg settings ----------*/

function charityhome_gutenberg_editor_palette_styles() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'strong yellow', 'charityhome' ),
            'slug' => 'strong-yellow',
            'color' => '#f7bd00',
        ),
        array(
            'name' => esc_html__( 'strong white', 'charityhome' ),
            'slug' => 'strong-white',
            'color' => '#fff',
        ),
		array(
            'name' => esc_html__( 'light black', 'charityhome' ),
            'slug' => 'light-black',
            'color' => '#242424',
        ),
        array(
            'name' => esc_html__( 'very light gray', 'charityhome' ),
            'slug' => 'very-light-gray',
            'color' => '#797979',
        ),
        array(
            'name' => esc_html__( 'very dark black', 'charityhome' ),
            'slug' => 'very-dark-black',
            'color' => '#000000',
        ),
    ) );
	
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => esc_html__( 'Small', 'charityhome' ),
			'size' => 10,
			'slug' => 'small'
		),
		array(
			'name' => esc_html__( 'Normal', 'charityhome' ),
			'size' => 15,
			'slug' => 'normal'
		),
		array(
			'name' => esc_html__( 'Large', 'charityhome' ),
			'size' => 24,
			'slug' => 'large'
		),
		array(
			'name' => esc_html__( 'Huge', 'charityhome' ),
			'size' => 36,
			'slug' => 'huge'
		)
	) );
	
}
add_action( 'after_setup_theme', 'charityhome_gutenberg_editor_palette_styles' );

/*---------- Gutenberg settings ends ----------*/

/*---------- Enqueue Styles and Scripts ----------*/

function charityhome_enqueue_scripts() {
	
	//styles
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'fontawesome-all', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
	wp_enqueue_style( 'hover', get_template_directory_uri() . '/assets/css/hover.css' );
	wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.css' );
	wp_enqueue_style( 'jquery-bxslider', get_template_directory_uri() . '/assets/css/jquery.bxslider.css' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css' );
	wp_enqueue_style( 'owl-theme-default-min', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css' );
	wp_enqueue_style( 'animate-min', get_template_directory_uri() . '/assets/css/animate.min.css' );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/css/flaticon.css' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.css' );
	wp_enqueue_style( 'charityhome-main', get_stylesheet_uri(), array(), time() );
	wp_enqueue_style( 'charityhome-main-style', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_style( 'charityhome-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );
	wp_enqueue_style( 'charityhome-custom', get_template_directory_uri() . '/assets/css/custom.css' );
	
	
    //scripts
	wp_enqueue_script( 'jquery-ui-core');
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/assets/js/bootstrap.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri().'/assets/js/jquery.bxslider.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri().'/assets/js/owl.carousel.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-parallax', get_template_directory_uri().'/assets/js/jquery-parallax.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-mixitup', get_template_directory_uri().'/assets/js/jquery.mixitup.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-fancybox', get_template_directory_uri().'/assets/js/jquery.fancybox.pack.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-easing', get_template_directory_uri().'/assets/js/jquery.easing.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'circle-progress', get_template_directory_uri().'/assets/js/circle-progress.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-appear', get_template_directory_uri().'/assets/js/jquery.appear.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-countTo', get_template_directory_uri().'/assets/js/jquery.countTo.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri().'/assets/js/isotope.pkgd.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/assets/js/jquery-ui.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'scrollbar', get_template_directory_uri().'/assets/js/scrollbar.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'TweenMax', get_template_directory_uri().'/assets/js/TweenMax.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'wow', get_template_directory_uri().'/assets/js/wow.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'charityhome-main-script', get_template_directory_uri().'/assets/js/custom.js', array( 'jquery' ), '2.1.2', true );
	if( is_singular() ) wp_enqueue_script('comment-reply');
}
add_action( 'wp_enqueue_scripts', 'charityhome_enqueue_scripts' );

/*---------- Enqueue styles and scripts ends ----------*/

/*---------- Google fonts ----------*/

function charityhome_fonts_url() {
	
	$fonts_url = '';

		$font_families['Poppins'] = 'Poppins:300,400,500,600,700';
		$font_families['Roboto+Condensed'] = 'Roboto Condensed:wght@400,700&display=swap';

		$font_families = apply_filters( 'CHARITYHOME/includes/classes/header_enqueue/font_families', $font_families );

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$protocol  = is_ssl() ? 'https' : 'http';
		$fonts_url = add_query_arg( $query_args, $protocol . '://fonts.googleapis.com/css' );

		return esc_url_raw($fonts_url);

}

function charityhome_theme_styles() {
    wp_enqueue_style( 'charityhome-theme-fonts', charityhome_fonts_url(), array(), null );
}

add_action( 'wp_enqueue_scripts', 'charityhome_theme_styles' );
add_action( 'admin_enqueue_scripts', 'charityhome_theme_styles' );

/*---------- Google fonts ends ----------*/

/*---------- More functions ----------*/

// 1) charityhome_set function

/**
 * [charityhome_set description]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */
if ( ! function_exists( 'charityhome_set' ) ) {
	function charityhome_set( $var, $key, $def = '' ) {

		if ( is_object( $var ) && isset( $var->$key ) ) {
			return $var->$key;
		} elseif ( is_array( $var ) && isset( $var[ $key ] ) ) {
			return $var[ $key ];
		} elseif ( $def ) {
			return $def;
		} else {
			return false;
		}
	}
}

// 2) charityhome_add_editor_styles function

function charityhome_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'charityhome_add_editor_styles' );

// 3) Add specific CSS class by filter body class.

$options = charityhome_WSH()->option(); 
if( charityhome_set($options, 'boxed_wrapper') ){

add_filter( 'body_class', function( $classes ) {
    $classes[] = 'boxed_wrapper';
    return $classes;
} );
}
add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .edit-post-layout .components-notice-list {
		display: none !important;
	}
  </style>';
}

function pickMenuForPost() {
	$categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );
	$menuDefinitions = array(
		// Tento kód pridá pre kategóriu článku na stránku aj sekundárne menu pre daný projekt
        // ID kategórie a ID elementor template
		// BOKKU
		44 => '[elementor-template id="12226"]',
		// Vybrať Integrácia štátnych príslušníkov tretích krajín vrátane migrantov
		73 => '[elementor-template id="12220"]',
		// ISE
		70 => '[elementor-template id="12223"]',
		// KSS
		77 => '[elementor-template id="12235"]',
		// TOS
		54 => '[elementor-template id="12229"]',
		// TSP
		63 => '[elementor-template id="12232"]',
		// Ukrajina
		112 => '[elementor-template id="16486"]',
		// Spolu pre komunity 
		117 => '[elementor-template id="23683"]',
		// [Deti] Safer internet SK
		143 => '[elementor-template id="36859"]',
		// [Deti] Vybudovanie domov komplexnej pomoci pre detí
		142 => '[elementor-template id="36900"]',
		// [Deti] Vylúčené komunity
		144 => '[elementor-template id="36901"]',
		// [Hodnoty únie] Národný kontaktný bod SK – CERV 2021-2027
		151 => '[elementor-template id="36902"]',
		// [IT projekty] Budovanie životných situácií pre organizáciu MPSVR SR
		164 => '[elementor-template id="36903"]',
		// [IT projekty] Digitálna transformácia úsekov verejnej správy
		162 => '[elementor-template id="36904"]',
		// [IT projekty] Elektronizácia služieb Národného inšpektorátu práce
		165 => '[elementor-template id="36905"]',
		// [IT projekty] Vybudovanie dohľadového pracoviska kybernetickej bezpečnosti rezortu MPSVR SR
		163 => '[elementor-template id="36906"]',
		// [Odborné vzdelávanie] Podpora a profesionalizácia odborných kapacít v oblasti sociálneho zabezpečenia
		153 => '[elementor-template id="36919"]',
		// [Odborné vzdelávanie] Podpora poskytovania kvalitných komunitných sociálnych služieb
		135 => '[elementor-template id="36921"]',
		// [Odborné vzdelávanie] Rozvoj odborných kompetencií Inšpekcie v sociálnych veciach
		154 => '[elementor-template id="36922"]',
		// [Pracovný trh] Inštitút sociálnej ekonomiky II
		138 => '[elementor-template id="36697"]',
		// [Pracovný trh] Rovnosť príležitostí prospieva všetkým
		139 => '[elementor-template id="36923"]',
		// [Sociálne služby] Podpora opatrovateľskej služby
		147 => '[elementor-template id="12345"]',
		// [Technická pomoc] Stabilizácia administratívnych kapacít gestora horizontálnych princípov
		157 => '[elementor-template id="36924"]',
		// [Technická pomoc] Stabilizácia administratívnych kapacít gestora horizontálnych princípov II.
		158 => '[elementor-template id="36925"]',
		// [Technická pomoc] Technická pomoc pre MPSVR SR 2024
		159 => '[elementor-template id="36926"]',
		// [Technická pomoc] Vytvorenie kapacít pre implementáciu životných situácií pre organizáciu MPSVR SR
		160 => '[elementor-template id="36927"]',
		// [VK,PT,SC] Informačná kampaň na zvyšovanie povedomia verejnosti o vybraných sociálnych témach
		145 => '[elementor-template id="36928"]',
		// [Vylúčené komunity] Integrácia štátnych príslušníkov tretích krajín vrátane migrantov
		132 => '[elementor-template id="36287"]',
		// [Vylúčené komunity] Poskytovanie potravinovej a/alebo základnej materiálnej pomoci najodkázanejším osobám
		136 => '[elementor-template id="36864"]',
	);
	foreach($categories as $category) {
		if(isset($menuDefinitions[$category])) {
			return do_shortcode($menuDefinitions[$category]);
		}
	}
	
	return null;
}

add_shortcode('pickMenuForPost', 'pickMenuForPost');
