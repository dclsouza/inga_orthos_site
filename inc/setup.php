<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ao ativar o tema: cria as páginas (cada uma com seu modelo), define a página
 * inicial e o blog, monta os menus e ativa links bonitos. Nada é sobrescrito
 * se as páginas já existirem.
 */

function io_default_pages() {
	$t = 'page-templates/';
	return array(
		'home'    => array( 'title' => 'Página Inicial', 'slug' => 'inicio', 'tpl' => $t . 'template-home.php' ),
		'quem'    => array( 'title' => 'Quem somos', 'slug' => 'quem-somos', 'tpl' => $t . 'template-quem-somos.php' ),
		'equipe'  => array( 'title' => 'Nossa Equipe', 'slug' => 'nossa-equipe', 'tpl' => $t . 'template-equipe.php', 'parent' => 'quem' ),
		'inst'    => array( 'title' => 'Instalações', 'slug' => 'instalacoes', 'tpl' => $t . 'template-instalacoes.php', 'parent' => 'quem' ),
		'serv'    => array( 'title' => 'Serviços', 'slug' => 'servicos', 'tpl' => $t . 'template-servicos.php' ),
		'choque'  => array( 'title' => 'Terapia de Choque', 'slug' => 'terapia-de-choque', 'tpl' => $t . 'template-choque.php' ),
		'blog'    => array( 'title' => 'Blog', 'slug' => 'blog', 'tpl' => '' ),
		'english' => array( 'title' => 'English', 'slug' => 'english', 'tpl' => $t . 'template-english.php' ),
		'kids'    => array( 'title' => 'Icaraí Ortho Kids', 'slug' => 'icarai-ortho-kids', 'tpl' => $t . 'template-kids.php' ),
		'contato' => array( 'title' => 'Contatos', 'slug' => 'contatos', 'tpl' => $t . 'template-contato.php' ),
	);
}

function io_find_page( $def ) {
	if ( $def['tpl'] ) {
		$found = get_posts(
			array(
				'post_type'   => 'page',
				'post_status' => array( 'publish', 'draft', 'private' ),
				'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
				'meta_value'  => $def['tpl'], // phpcs:ignore WordPress.DB.SlowDBQuery
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		return $found ? (int) $found[0] : 0;
	}
	$p = get_page_by_path( $def['slug'] );
	return $p ? (int) $p->ID : 0;
}

function io_activate() {
	$ids = array();
	foreach ( io_default_pages() as $key => $def ) {
		$id = io_find_page( $def );
		if ( ! $id ) {
			$args = array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $def['title'],
				'post_name'    => $def['slug'],
				'post_content' => '',
			);
			if ( ! empty( $def['parent'] ) && isset( $ids[ $def['parent'] ] ) ) {
				$args['post_parent'] = $ids[ $def['parent'] ];
			}
			if ( $def['tpl'] ) {
				$args['page_template'] = $def['tpl'];
			}
			$id = wp_insert_post( $args );
		}
		$ids[ $key ] = (int) $id;
	}

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}
	if ( ! empty( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}
	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	if ( in_array( get_option( 'blogname' ), array( '', 'WordPress', 'My WordPress Website' ), true ) ) {
		update_option( 'blogname', 'Ingá Orthos' );
	}
	if ( '' === get_option( 'blogdescription' ) || 'Just another WordPress site' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'Odontologia, Icaraí Ortho Kids e Terapia de Choque em Niterói' );
	}

	io_build_menus( $ids );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'io_activate' );

function io_build_menus( $ids ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations = is_array( $locations ) ? $locations : array();

	if ( empty( $locations['primary'] ) ) {
		$menu_id = wp_create_nav_menu( 'Menu principal' );
		if ( ! is_wp_error( $menu_id ) ) {
			$item = function ( $page_key, $parent_item = 0 ) use ( $menu_id, $ids ) {
				return wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $ids[ $page_key ] ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $page_key ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-parent-id' => $parent_item,
					)
				);
			};
			$item( 'home' );
			$quem = $item( 'quem' );
			$item( 'equipe', $quem );
			$item( 'inst', $quem );
			$item( 'serv' );
			$item( 'choque' );
			$item( 'blog' );
			$item( 'english' );
			$item( 'kids' );
			$item( 'contato' );
			$locations['primary'] = $menu_id;
		}
	}

	if ( empty( $locations['footer'] ) ) {
		$fid = wp_create_nav_menu( 'Menu do rodapé' );
		if ( ! is_wp_error( $fid ) ) {
			foreach ( array( 'quem', 'equipe', 'serv', 'kids', 'choque', 'blog', 'contato' ) as $k ) {
				wp_update_nav_menu_item(
					$fid,
					0,
					array(
						'menu-item-title'     => get_the_title( $ids[ $k ] ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $k ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
			$locations['footer'] = $fid;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}

/** Ícone do site (favicon) padrão do tema, se nenhum foi definido no Personalizar. */
function io_default_favicon() {
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" type="image/png" href="' . esc_url( IO_URI . '/assets/img/favicon.png' ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'io_default_favicon', 5 );
