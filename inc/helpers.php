<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================================
   Leitura de conteúdo: valor salvo no painel OU o padrão definido no schema
   ========================================================================== */

/** Achata as seções do schema em [chave => definição]. */
function io_flat( $sections ) {
	$flat = array();
	foreach ( $sections as $section ) {
		foreach ( $section['fields'] as $key => $def ) {
			$flat[ $key ] = $def;
		}
	}
	return $flat;
}

/** ID da página em exibição. */
function io_post_id() {
	$id = get_queried_object_id();
	return $id ? $id : get_the_ID();
}

/** Dados salvos de uma página. */
function io_saved( $post_id ) {
	static $cache = array();
	if ( ! isset( $cache[ $post_id ] ) ) {
		$data              = get_post_meta( $post_id, '_io_data', true );
		$cache[ $post_id ] = is_array( $data ) ? $data : array();
	}
	return $cache[ $post_id ];
}

/** Campo da página atual. */
function io( $key, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : io_post_id();
	$saved   = io_saved( $post_id );
	if ( array_key_exists( $key, $saved ) ) {
		return $saved[ $key ];
	}
	$flat = io_flat( io_schema_for( get_page_template_slug( $post_id ) ) );
	return isset( $flat[ $key ]['default'] ) ? $flat[ $key ]['default'] : '';
}

/** Campo das configurações gerais (menu "Ingá Orthos"). */
function io_o( $key ) {
	static $opts = null;
	static $flat = null;
	if ( null === $opts ) {
		$opts = get_option( 'io_options', array() );
		$opts = is_array( $opts ) ? $opts : array();
		$flat = io_flat( io_options_all_sections() );
	}
	if ( array_key_exists( $key, $opts ) ) {
		return $opts[ $key ];
	}
	return isset( $flat[ $key ]['default'] ) ? $flat[ $key ]['default'] : '';
}

/* ==========================================================================
   Imagens
   ========================================================================== */

/** URL de uma imagem: ID de anexo ou "theme:arquivo.webp" (imagem do tema). */
function io_img( $val, $size = 'large' ) {
	if ( is_numeric( $val ) && (int) $val > 0 ) {
		$url = wp_get_attachment_image_url( (int) $val, $size );
		return $url ? $url : '';
	}
	if ( is_string( $val ) && 0 === strpos( $val, 'theme:' ) ) {
		return IO_URI . '/assets/img/' . ltrim( substr( $val, 6 ), '/' );
	}
	return '';
}

/** Tag <img> completa (com srcset quando é imagem da biblioteca). */
function io_img_tag( $val, $alt = '', $attrs = array(), $size = 'large' ) {
	$attrs = wp_parse_args(
		$attrs,
		array(
			'loading' => 'lazy',
			'alt'     => $alt,
		)
	);
	if ( is_numeric( $val ) && (int) $val > 0 ) {
		return wp_get_attachment_image( (int) $val, $size, false, $attrs );
	}
	$url = io_img( $val );
	if ( ! $url ) {
		return '';
	}
	$html = '<img src="' . esc_url( $url ) . '"';
	foreach ( $attrs as $k => $v ) {
		$html .= ' ' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
	return $html . '>';
}

/* ==========================================================================
   Texto
   ========================================================================== */

function io_kses_allowed() {
	return array(
		'a'      => array(
			'href'   => array(),
			'target' => array(),
			'rel'    => array(),
		),
		'strong' => array(),
		'em'     => array(),
		'br'     => array(),
	);
}

/** Texto de várias linhas em uma linha visual (quebras viram <br>). */
function io_rich( $text ) {
	echo wp_kses( nl2br( (string) $text ), io_kses_allowed() ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/** Texto com parágrafos (linha em branco = novo parágrafo). */
function io_paragraphs( $text ) {
	echo wpautop( wp_kses( (string) $text, io_kses_allowed() ) ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/** Linhas não vazias de um textarea. */
function io_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	$lines = array_map( 'trim', $lines );
	return array_values( array_filter( $lines, 'strlen' ) );
}

/* ==========================================================================
   Unidades, contatos, links
   ========================================================================== */

function io_units() {
	return array(
		'odonto' => 'Ingá Orthos Odontologia',
		'kids'   => 'Icaraí Ortho Kids',
		'choque' => 'Terapia de Choque',
	);
}

/** Todos os dados de uma unidade (nome, endereço, WhatsApp...). */
function io_unit( $u ) {
	$fields = array( 'name', 'short', 'topbar', 'address', 'wa', 'wa_label', 'wa2', 'wa2_label', 'phones', 'email', 'hours', 'note', 'ig_url', 'ig_handle' );
	$out    = array( 'key' => $u );
	foreach ( $fields as $f ) {
		$out[ $f ] = io_o( $u . '_' . $f );
	}
	$out['wa']     = preg_replace( '/\D/', '', (string) $out['wa'] );
	$out['wa2']    = preg_replace( '/\D/', '', (string) $out['wa2'] );
	$out['phones'] = io_lines( $out['phones'] );
	return $out;
}

/** Link do WhatsApp da unidade, com mensagem opcional. */
function io_wa_url( $unit, $msg = '' ) {
	$n   = preg_replace( '/\D/', '', (string) io_o( $unit . '_wa' ) );
	$url = 'https://wa.me/' . $n;
	if ( $msg ) {
		$url .= '?text=' . rawurlencode( $msg );
	}
	return $url;
}

function io_tel_href( $phone ) {
	$d = preg_replace( '/\D/', '', (string) $phone );
	if ( strlen( $d ) <= 11 ) {
		$d = '55' . $d;
	}
	return 'tel:+' . $d;
}

/** Permalink da página que usa um determinado modelo. */
function io_page_url( $template ) {
	static $cache = array();
	if ( ! isset( $cache[ $template ] ) ) {
		$q                  = get_posts(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
				'meta_value'  => $template, // phpcs:ignore WordPress.DB.SlowDBQuery
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		$cache[ $template ] = $q ? get_permalink( $q[0] ) : home_url( '/' );
	}
	return $cache[ $template ];
}

/**
 * Resolve links do painel. Aceita URL completa, âncora (#agendar)
 * ou atalhos: @home @quem-somos @equipe @instalacoes @servicos @kids @choque @contato @english @blog
 */
function io_url( $v ) {
	$v = trim( (string) $v );
	if ( '' === $v ) {
		return '';
	}
	if ( '@' !== $v[0] ) {
		return $v;
	}
	$key = substr( $v, 1 );
	if ( 'home' === $key ) {
		return home_url( '/' );
	}
	if ( 'blog' === $key ) {
		$p = (int) get_option( 'page_for_posts' );
		return $p ? get_permalink( $p ) : home_url( '/' );
	}
	$map = array(
		'quem-somos'  => 'template-quem-somos.php',
		'equipe'      => 'template-equipe.php',
		'instalacoes' => 'template-instalacoes.php',
		'servicos'    => 'template-servicos.php',
		'kids'        => 'template-kids.php',
		'choque'      => 'template-choque.php',
		'contato'     => 'template-contato.php',
		'english'     => 'template-english.php',
	);
	if ( isset( $map[ $key ] ) ) {
		return io_page_url( 'page-templates/' . $map[ $key ] );
	}
	return home_url( '/' );
}

/** Em qual "aba" estamos: odonto (padrão), kids ou choque. */
function io_context() {
	static $ctx = null;
	if ( null !== $ctx ) {
		return $ctx;
	}
	$ctx = 'odonto';
	if ( is_page() ) {
		$tpl = get_page_template_slug();
		if ( 'page-templates/template-kids.php' === $tpl ) {
			$ctx = 'kids';
		} elseif ( 'page-templates/template-choque.php' === $tpl ) {
			$ctx = 'choque';
		}
	}
	return $ctx;
}

/** Imprime um ícone do sprite. */
function io_icon( $id, $class = 'ic' ) {
	echo '<svg class="' . esc_attr( $class ) . '" aria-hidden="true" focusable="false"><use href="#i-' . esc_attr( $id ) . '"/></svg>';
}

/** Equipe filtrada por unidade: odonto, kids ou choque ("both" aparece em odonto e kids). */
function io_team( $group = '' ) {
	$rows = io_o( 'team' );
	$rows = is_array( $rows ) ? $rows : array();
	if ( '' === $group ) {
		return $rows;
	}
	$out = array();
	foreach ( $rows as $r ) {
		$g = isset( $r['group'] ) ? $r['group'] : 'odonto';
		if ( $g === $group || ( 'both' === $g && in_array( $group, array( 'odonto', 'kids' ), true ) ) ) {
			$out[] = $r;
		}
	}
	return $out;
}

/** Depoimentos, opcionalmente só de uma unidade. */
function io_quotes( $unit = '' ) {
	$rows = io_o( 'quotes' );
	$rows = is_array( $rows ) ? $rows : array();
	if ( '' === $unit ) {
		return $rows;
	}
	return array_values(
		array_filter(
			$rows,
			function ( $r ) use ( $unit ) {
				return isset( $r['unit'] ) && $r['unit'] === $unit;
			}
		)
	);
}
