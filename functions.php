<?php
/**
 * Tema Ingá Orthos.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'IO_VERSION', '1.0.0' );
define( 'IO_DIR', get_template_directory() );
define( 'IO_URI', get_template_directory_uri() );

require_once IO_DIR . '/inc/helpers.php';
require_once IO_DIR . '/inc/render.php';
require_once IO_DIR . '/inc/schema-options.php';
require_once IO_DIR . '/inc/schema-pages.php';
require_once IO_DIR . '/inc/fields.php';
require_once IO_DIR . '/inc/admin.php';
require_once IO_DIR . '/inc/setup.php';

/**
 * Suporte do tema, menus e tamanhos de imagem.
 */
function io_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus(
		array(
			'primary' => 'Menu principal (topo)',
			'footer'  => 'Menu do rodapé',
		)
	);

	add_image_size( 'io-hero', 2000, 1100, false );
	add_image_size( 'io-card', 1200, 900, false );
}
add_action( 'after_setup_theme', 'io_setup' );

/**
 * CSS e JS do site.
 */
function io_assets() {
	wp_enqueue_style(
		'io-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Figtree:wght@400;500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'io-main', IO_URI . '/assets/css/main.css', array( 'io-fonts' ), filemtime( IO_DIR . '/assets/css/main.css' ) );
	wp_enqueue_style( 'io-pages', IO_URI . '/assets/css/pages.css', array( 'io-main' ), filemtime( IO_DIR . '/assets/css/pages.css' ) );
	wp_enqueue_script( 'io-main', IO_URI . '/assets/js/main.js', array(), filemtime( IO_DIR . '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'io_assets' );

/**
 * Identidade de cada aba: a página da Ortho Kids e a da Terapia de Choque
 * ganham uma classe própria (cores, logo e contatos da unidade).
 */
function io_body_class( $classes ) {
	$classes[] = 'unit-' . io_context();
	return $classes;
}
add_filter( 'body_class', 'io_body_class' );

/**
 * O primeiro item do menu (Página Inicial) fica ativo também no blog/single? Não: só o item correto.
 * Remove a barra de admin do cálculo do header sticky via CSS (ver main.css).
 */
