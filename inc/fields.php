<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Motor de campos do painel: desenha os formulários e higieniza os dados.
 * Tipos: text, textarea, select, icon, image, repeater.
 */

function io_icon_choices() {
	return array(
		'braces'   => 'Aparelho (ortodontia)',
		'child'    => 'Criança',
		'baby'     => 'Bebê',
		'implant'  => 'Implante',
		'canal'    => 'Canal (endodontia)',
		'gum'      => 'Gengiva (periodontia)',
		'tooth'    => 'Dente',
		'bone'     => 'Osso (ortopedia)',
		'wave'     => 'Ondas / pulso',
		'family'   => 'Família',
		'monitor'  => 'Tecnologia / monitor',
		'star'     => 'Estrela',
		'pin'      => 'Localização',
		'clock'    => 'Horário',
		'tongue'   => 'Língua',
		'calendar' => 'Calendário',
		'phone'    => 'Telefone',
		'mail'     => 'E-mail',
		'check'    => 'Confirmação',
	);
}

/* ==========================================================================
   Desenho dos campos
   ========================================================================== */

function io_field_html( $name, $def, $value ) {
	$type = isset( $def['type'] ) ? $def['type'] : 'text';
	ob_start();
	echo '<div class="io-field io-field--' . esc_attr( $type ) . '">';

	if ( ! empty( $def['label'] ) && 'repeater' !== $type ) {
		echo '<label class="io-label">' . esc_html( $def['label'] ) . '</label>';
	}

	switch ( $type ) {
		case 'textarea':
			printf(
				'<textarea name="%s" rows="%d">%s</textarea>',
				esc_attr( $name ),
				isset( $def['rows'] ) ? (int) $def['rows'] : 3,
				esc_textarea( (string) $value )
			);
			break;

		case 'select':
		case 'icon':
			$options = 'icon' === $type ? io_icon_choices() : $def['options'];
			echo '<select name="' . esc_attr( $name ) . '">';
			foreach ( $options as $k => $label ) {
				printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( (string) $value, (string) $k, false ), esc_html( $label ) );
			}
			echo '</select>';
			break;

		case 'image':
			$url = io_img( $value, 'medium' );
			echo '<div class="io-image" data-io-image>';
			echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '">';
			echo '<div class="io-image__preview">' . ( $url ? '<img src="' . esc_url( $url ) . '" alt="">' : '<span>Sem imagem</span>' ) . '</div>';
			echo '<div class="io-image__btns"><button type="button" class="button io-image-pick">Escolher imagem</button> <button type="button" class="button-link io-image-clear">Remover</button></div>';
			echo '</div>';
			break;

		case 'repeater':
			$rows = is_array( $value ) ? $value : array();
			echo '<div class="io-repeater" data-io-repeater>';
			echo '<div class="io-repeater__title">' . esc_html( $def['label'] ) . '</div>';
			echo '<div class="io-repeater__rows">';
			foreach ( $rows as $i => $row ) {
				echo io_repeater_row( $name, $def, $i, is_array( $row ) ? $row : array() ); // phpcs:ignore WordPress.Security.EscapeOutput
			}
			echo '</div>';
			echo '<template class="io-repeater__tpl">' . io_repeater_row( $name, $def, '__i__', array() ) . '</template>'; // phpcs:ignore WordPress.Security.EscapeOutput
			echo '<button type="button" class="button button-secondary io-repeater-add">+ ' . esc_html( isset( $def['add'] ) ? $def['add'] : 'Adicionar item' ) . '</button>';
			echo '</div>';
			break;

		default:
			printf( '<input type="text" name="%s" value="%s">', esc_attr( $name ), esc_attr( (string) $value ) );
	}

	if ( ! empty( $def['help'] ) ) {
		echo '<p class="io-help">' . esc_html( $def['help'] ) . '</p>';
	}
	echo '</div>';
	return ob_get_clean();
}

function io_repeater_row( $name, $def, $i, $row ) {
	$title_key = isset( $def['item_label'] ) ? $def['item_label'] : '';
	$title     = '';
	if ( $title_key && isset( $row[ $title_key ] ) && is_string( $row[ $title_key ] ) ) {
		$title = wp_strip_all_tags( $row[ $title_key ] );
	}
	ob_start();
	echo '<details class="io-row" data-title-key="' . esc_attr( $title_key ) . '"><summary>';
	echo '<span class="io-row__title">' . esc_html( '' !== $title ? $title : 'Novo item' ) . '</span>';
	echo '<span class="io-row__tools"><button type="button" class="io-up" title="Mover para cima">↑</button><button type="button" class="io-down" title="Mover para baixo">↓</button><button type="button" class="io-del" title="Remover">✕</button></span>';
	echo '</summary><div class="io-row__body">';
	foreach ( $def['fields'] as $k => $f ) {
		$v = isset( $row[ $k ] ) ? $row[ $k ] : ( isset( $f['default'] ) ? $f['default'] : '' );
		echo io_field_html( $name . '[' . $i . '][' . $k . ']', $f, $v ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</div></details>';
	return ob_get_clean();
}

/** Desenha todas as seções; $get( $key, $def ) devolve o valor atual do campo. */
function io_render_sections( $sections, $get ) {
	foreach ( $sections as $section ) {
		echo '<details class="io-section" open><summary>' . esc_html( $section['label'] ) . '</summary><div class="io-section__body">';
		foreach ( $section['fields'] as $key => $def ) {
			echo io_field_html( 'io[' . $key . ']', $def, call_user_func( $get, $key, $def ) ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</div></details>';
	}
}

/* ==========================================================================
   Higienização
   ========================================================================== */

function io_sanitize( $def, $value ) {
	$type = isset( $def['type'] ) ? $def['type'] : 'text';

	switch ( $type ) {
		case 'textarea':
			return wp_kses( (string) $value, io_kses_allowed() );

		case 'select':
		case 'icon':
			$options = 'icon' === $type ? io_icon_choices() : $def['options'];
			$value   = (string) $value;
			if ( array_key_exists( $value, $options ) ) {
				return $value;
			}
			reset( $options );
			return (string) key( $options );

		case 'image':
			$value = (string) $value;
			if ( ctype_digit( $value ) ) {
				return (int) $value;
			}
			if ( preg_match( '/^theme:[A-Za-z0-9_\-.\/]+$/', $value ) ) {
				return $value;
			}
			return '';

		case 'repeater':
			$out = array();
			foreach ( (array) $value as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$clean = array();
				$has   = false;
				foreach ( $def['fields'] as $k => $f ) {
					$v         = io_sanitize( $f, isset( $row[ $k ] ) ? $row[ $k ] : '' );
					$clean[ $k ] = $v;
					if ( ! in_array( $f['type'], array( 'select', 'icon' ), true ) && '' !== $v && 0 !== $v ) {
						$has = true;
					}
				}
				if ( $has ) {
					$out[] = $clean;
				}
			}
			return $out;

		default:
			$v = trim( sanitize_text_field( (string) $value ) );
			return $v;
	}
}

/** Higieniza tudo o que veio do formulário, segundo o schema. */
function io_sanitize_all( $sections, $input ) {
	$out = array();
	foreach ( io_flat( $sections ) as $key => $def ) {
		if ( isset( $input[ $key ] ) ) {
			$raw = $input[ $key ];
		} else {
			$raw = ( isset( $def['type'] ) && 'repeater' === $def['type'] ) ? array() : '';
		}
		$out[ $key ] = io_sanitize( $def, $raw );
	}
	return $out;
}
