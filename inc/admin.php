<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================================
   Caixa "Conteúdo da página" em cada página que usa um modelo do tema
   ========================================================================== */

function io_add_meta_box() {
	add_meta_box( 'io_page_fields', 'Conteúdo desta página (Ingá Orthos)', 'io_meta_box_cb', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'io_add_meta_box' );

function io_meta_box_cb( $post ) {
	$tpl      = get_page_template_slug( $post );
	$sections = io_schema_for( $tpl );
	wp_nonce_field( 'io_save_page', 'io_nonce' );

	if ( ! $sections ) {
		echo '<p>Esta página não tem campos especiais. Para editar textos e fotos organizados, escolha um <strong>Modelo</strong> do tema no painel lateral (ex.: "Página Inicial", "Icaraí Ortho Kids") e clique em <strong>Atualizar</strong>. O texto livre desta página pode ser escrito no editor acima.</p>';
		return;
	}

	$saved = get_post_meta( $post->ID, '_io_data', true );
	$saved = is_array( $saved ) ? $saved : array();

	echo '<p class="io-intro">Edite os textos e as fotos abaixo e clique em <strong>Atualizar</strong>. Campos que você não mexer continuam com o texto original. Contatos, equipe e depoimentos ficam no menu <strong>Ingá Orthos</strong>, à esquerda.</p>';
	io_render_sections(
		$sections,
		function ( $key, $def ) use ( $saved ) {
			if ( array_key_exists( $key, $saved ) ) {
				return $saved[ $key ];
			}
			return isset( $def['default'] ) ? $def['default'] : '';
		}
	);
}

function io_save_page( $post_id ) {
	if ( ! isset( $_POST['io_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['io_nonce'] ) ), 'io_save_page' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$sections = io_schema_for( get_page_template_slug( $post_id ) );
	if ( ! $sections ) {
		return;
	}
	$input = isset( $_POST['io'] ) ? wp_unslash( $_POST['io'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	update_post_meta( $post_id, '_io_data', io_sanitize_all( $sections, is_array( $input ) ? $input : array() ) );
}
add_action( 'save_post_page', 'io_save_page' );

/* ==========================================================================
   Menu "Ingá Orthos": unidades, equipe, depoimentos, marca
   ========================================================================== */

function io_admin_menu() {
	$screens = io_options_screens();
	$first   = true;
	foreach ( $screens as $slug => $screen ) {
		$page_slug = 'io-' . $slug;
		if ( $first ) {
			add_menu_page( 'Ingá Orthos: ' . $screen['title'], 'Ingá Orthos', 'edit_pages', $page_slug, 'io_options_screen', 'dashicons-heart', 21 );
			add_submenu_page( $page_slug, 'Ingá Orthos: ' . $screen['title'], $screen['title'], 'edit_pages', $page_slug, 'io_options_screen' );
			$first = false;
		} else {
			add_submenu_page( 'io-contatos', 'Ingá Orthos: ' . $screen['title'], $screen['title'], 'edit_pages', $page_slug, 'io_options_screen' );
		}
	}
}
add_action( 'admin_menu', 'io_admin_menu' );

function io_options_screen() {
	$page   = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$slug   = preg_replace( '/^io-/', '', $page );
	$screens = io_options_screens();
	if ( ! isset( $screens[ $slug ] ) ) {
		return;
	}
	$screen = $screens[ $slug ];
	$saved  = get_option( 'io_options', array() );
	$saved  = is_array( $saved ) ? $saved : array();

	echo '<div class="wrap io-wrap"><h1>' . esc_html( $screen['title'] ) . '</h1>';
	if ( isset( $_GET['updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<div class="notice notice-success is-dismissible"><p>Alterações salvas.</p></div>';
	}
	if ( ! empty( $screen['intro'] ) ) {
		echo '<p class="io-intro">' . esc_html( $screen['intro'] ) . '</p>';
	}
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="io_save_options"><input type="hidden" name="screen" value="' . esc_attr( $slug ) . '">';
	wp_nonce_field( 'io_save_options', 'io_nonce' );
	io_render_sections(
		$screen['sections'],
		function ( $key, $def ) use ( $saved ) {
			if ( array_key_exists( $key, $saved ) ) {
				return $saved[ $key ];
			}
			return isset( $def['default'] ) ? $def['default'] : '';
		}
	);
	submit_button( 'Salvar alterações' );
	echo '</form></div>';
}

function io_save_options() {
	if ( ! isset( $_POST['io_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['io_nonce'] ) ), 'io_save_options' ) ) {
		wp_die( 'Sessão expirada. Volte e tente de novo.' );
	}
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( 'Sem permissão.' );
	}
	$slug    = isset( $_POST['screen'] ) ? sanitize_key( wp_unslash( $_POST['screen'] ) ) : '';
	$screens = io_options_screens();
	if ( ! isset( $screens[ $slug ] ) ) {
		wp_die( 'Tela inválida.' );
	}
	$input = isset( $_POST['io'] ) ? wp_unslash( $_POST['io'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$clean = io_sanitize_all( $screens[ $slug ]['sections'], is_array( $input ) ? $input : array() );
	$all   = get_option( 'io_options', array() );
	$all   = is_array( $all ) ? $all : array();
	update_option( 'io_options', array_merge( $all, $clean ) );
	wp_safe_redirect( add_query_arg( array( 'page' => 'io-' . $slug, 'updated' => 1 ), admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_post_io_save_options', 'io_save_options' );

/* ==========================================================================
   CSS e JS do painel
   ========================================================================== */

function io_admin_assets( $hook ) {
	$is_page   = in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && 'page' === get_post_type();
	$is_screen = false !== strpos( (string) $hook, '_page_io-' );
	if ( ! $is_page && ! $is_screen ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style( 'io-admin', IO_URI . '/assets/admin/admin.css', array(), filemtime( IO_DIR . '/assets/admin/admin.css' ) );
	wp_enqueue_script( 'io-admin', IO_URI . '/assets/admin/admin.js', array(), filemtime( IO_DIR . '/assets/admin/admin.js' ), true );
}
add_action( 'admin_enqueue_scripts', 'io_admin_assets' );
