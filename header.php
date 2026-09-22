<?php
/**
 * Cabeçalho: barra superior + logo + menu.
 * O logo, os contatos e o botão de agendar mudam conforme a "aba" (Ingá, Ortho Kids ou Terapia de Choque).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$ctx  = io_context();
$unit = io_unit( $ctx );
$logo = 'kids' === $ctx ? io_o( 'logo_kids' ) : ( 'choque' === $ctx ? io_o( 'logo_choque' ) : io_o( 'logo_odonto' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0c2a1a">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/sprite' ); ?>

<a class="skip" href="#conteudo">Ir para o conteúdo</a>

<div class="topbar">
	<div class="wrap topbar__in">
		<p class="topbar__loc"><?php io_icon( 'pin' ); ?><span><?php echo esc_html( $unit['topbar'] ); ?></span></p>
		<div class="topbar__right">
			<a class="topbar__wa" href="<?php echo esc_url( io_wa_url( $ctx ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( $unit['wa_label'] ); ?></a>
			<a class="topbar__cta" href="<?php echo esc_url( io_book_url( $ctx ) ); ?>">Agendar consulta</a>
		</div>
	</div>
</div>

<header class="header" id="topo">
	<div class="wrap header__in">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>, página inicial">
			<?php echo io_img_tag( $logo, $unit['name'], array( 'loading' => 'eager' ), 'medium' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</a>
		<nav class="nav" id="menu" aria-label="Principal">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav__list',
					'fallback_cb'    => 'io_fallback_menu',
					'depth'          => 2,
				)
			);
			?>
			<a class="nav__intranet" href="<?php echo esc_url( io_o( 'intranet_url' ) ); ?>" target="_blank" rel="noopener">
				Intranet
				<svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8.5" r="3.5"/><path d="M5 20c.5-4 3.3-6 7-6s6.500 2 7 6"/></svg>
			</a>
		</nav>
		<button class="burger" type="button" aria-expanded="false" aria-controls="menu" aria-label="Abrir menu"><span></span><span></span><span></span></button>
	</div>
</header>

<main id="conteudo">
