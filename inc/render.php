<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================================
   Componentes de exibição reutilizados pelas páginas
   ========================================================================== */

/** Iniciais para o avatar de quem não tem foto ("Dra. Ana Carolina" => "AC"). */
function io_initials( $name ) {
	$name  = preg_replace( '/^(Dra?\.|Dr|Dra)\s+/iu', '', trim( (string) $name ) );
	$parts = preg_split( '/\s+/', $name );
	$out   = '';
	foreach ( array_slice( (array) $parts, 0, 2 ) as $p ) {
		$out .= mb_strtoupper( mb_substr( $p, 0, 1 ) );
	}
	return $out;
}

/** Topo das páginas internas. */
function io_page_head( $title, $lead = '', $eyebrow = '' ) {
	?>
	<section class="page-head">
		<div class="wrap page-head__in">
			<?php if ( $eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $lead ) : ?>
				<p class="lead"><?php io_rich( $lead ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/** Faixa verde de chamada para agendar. */
function io_cta_band( $title, $text, $label, $url ) {
	?>
	<section class="cta-band">
		<div class="wrap cta-band__in">
			<div>
				<h2><?php echo esc_html( $title ); ?></h2>
				<p><?php io_rich( $text ); ?></p>
			</div>
			<a class="btn btn--gold" href="<?php echo esc_url( $url ); ?>"><?php io_icon( 'calendar' ); ?><?php echo esc_html( $label ); ?></a>
		</div>
	</section>
	<?php
}

/** Link para o formulário de agendamento (página Contatos) já com a unidade. */
function io_book_url( $unit = 'odonto' ) {
	return add_query_arg( 'unidade', $unit, io_url( '@contato' ) ) . '#agendar';
}

/** Cartão de unidade da página inicial. */
function io_unit_card( $row ) {
	$u    = isset( $row['unit'] ) ? $row['unit'] : 'odonto';
	$d    = io_unit( $u );
	$mod  = 'odonto' === $u ? 'inga' : $u;
	$btn  = 'kids' === $u ? 'btn btn--sun btn--sm' : 'btn btn--dark btn--sm';
	$logo = '';
	if ( 'odonto' === $u ) {
		$logo = io_img_tag( 'theme:logo-simbolo.png', '', array( 'class' => 'unit__logo unit__logo--mark' ) );
	} elseif ( 'kids' === $u ) {
		$logo = io_img_tag( io_o( 'logo_kids' ), $d['name'], array( 'class' => 'unit__logo' ) );
	} else {
		$logo = io_img_tag( io_o( 'logo_choque' ), $d['name'], array( 'class' => 'unit__logo unit__logo--wide' ) );
	}
	?>
	<article class="unit unit--<?php echo esc_attr( $mod ); ?>">
		<div class="unit__media"><?php echo io_img_tag( isset( $row['image'] ) ? $row['image'] : '', isset( $row['title'] ) ? $row['title'] : '', array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		<div class="unit__body">
			<?php echo $logo; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<h3><?php echo esc_html( $row['title'] ); ?><small><?php echo esc_html( $row['subtitle'] ); ?></small></h3>
			<p><?php io_rich( $row['text'] ); ?></p>
			<p class="unit__where"><?php io_icon( 'pin' ); ?><?php echo esc_html( $d['short'] ); ?></p>
			<div class="unit__actions">
				<a class="<?php echo esc_attr( $btn ); ?>" href="<?php echo esc_url( io_url( $row['btn_url'] ) ); ?>"><?php echo esc_html( $row['btn_label'] ); ?></a>
				<a class="link" href="<?php echo esc_url( io_wa_url( $u, 'Olá! Gostaria de marcar uma consulta na ' . $d['name'] . '.' ) ); ?>" target="_blank" rel="noopener">WhatsApp<?php io_icon( 'arrow' ); ?></a>
			</div>
		</div>
	</article>
	<?php
}

/** Cartão de profissional. */
function io_team_card( $r, $show_bio = false ) {
	$photo = io_img_tag( isset( $r['photo'] ) ? $r['photo'] : '', isset( $r['name'] ) ? $r['name'] : '', array(), 'medium_large' );
	?>
	<article class="doc<?php echo $photo ? '' : ' doc--nophoto'; ?>">
		<?php if ( $photo ) : ?>
			<?php echo $photo; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php else : ?>
			<div class="doc__mono" aria-hidden="true"><?php echo esc_html( io_initials( $r['name'] ) ); ?></div>
		<?php endif; ?>
		<h3><?php echo esc_html( $r['name'] ); ?></h3>
		<?php if ( ! empty( $r['role'] ) ) : ?>
			<p><?php echo esc_html( $r['role'] ); ?></p>
		<?php endif; ?>
		<?php if ( $show_bio && ! empty( $r['bio'] ) ) : ?>
			<p class="doc__bio"><?php echo esc_html( $r['bio'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $r['cro'] ) ) : ?>
			<span><?php echo esc_html( $r['cro'] ); ?></span>
		<?php endif; ?>
	</article>
	<?php
}

/** Depoimentos. */
function io_quote_cards( $rows ) {
	if ( ! $rows ) {
		return;
	}
	?>
	<div class="quotes">
		<?php foreach ( $rows as $q ) : ?>
			<figure class="quote">
				<?php io_icon( 'quote', 'quote__mark' ); ?>
				<blockquote><?php echo esc_html( $q['quote'] ); ?></blockquote>
				<figcaption>
					<b><?php echo esc_html( $q['name'] . ( ! empty( $q['meta'] ) ? ', ' . $q['meta'] : '' ) ); ?></b>
					<?php
					$units = io_units();
					echo esc_html( isset( $units[ $q['unit'] ] ) ? io_o( $q['unit'] . '_name' ) : '' );
					?>
				</figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Bloco de contato de uma unidade (endereço, WhatsApp, telefones, e-mail, horário). */
function io_place_block( $unit, $extra_class = '' ) {
	$d = io_unit( $unit );
	?>
	<article class="place <?php echo esc_attr( $extra_class ); ?>">
		<h3><?php echo esc_html( $d['name'] ); ?></h3>
		<p><?php io_icon( 'pin' ); ?><span><?php io_rich( $d['address'] ); ?></span></p>
		<?php if ( $d['wa'] ) : ?>
			<p><?php io_icon( 'whatsapp' ); ?><span>
				<a href="<?php echo esc_url( 'https://wa.me/' . $d['wa'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $d['wa_label'] ); ?></a>
				<?php if ( $d['wa2'] ) : ?>
					· <a href="<?php echo esc_url( 'https://wa.me/' . $d['wa2'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $d['wa2_label'] ); ?></a>
				<?php endif; ?>
			</span></p>
		<?php endif; ?>
		<?php if ( $d['phones'] ) : ?>
			<p><?php io_icon( 'phone' ); ?><span>
				<?php
				$links = array();
				foreach ( $d['phones'] as $ph ) {
					$links[] = '<a href="' . esc_url( io_tel_href( $ph ), array( 'tel' ) ) . '">' . esc_html( $ph ) . '</a>';
				}
				echo implode( ' · ', $links ); // phpcs:ignore WordPress.Security.EscapeOutput
				?>
			</span></p>
		<?php endif; ?>
		<?php if ( $d['hours'] ) : ?>
			<p><?php io_icon( 'clock' ); ?><span><?php echo esc_html( $d['hours'] ); ?></span></p>
		<?php endif; ?>
		<?php if ( $d['note'] ) : ?>
			<p><?php io_icon( 'check' ); ?><span><?php echo esc_html( $d['note'] ); ?></span></p>
		<?php endif; ?>
		<?php if ( $d['email'] ) : ?>
			<p><?php io_icon( 'mail' ); ?><span><a href="mailto:<?php echo esc_attr( $d['email'] ); ?>"><?php echo esc_html( $d['email'] ); ?></a></span></p>
		<?php endif; ?>
		<?php if ( $d['ig_url'] ) : ?>
			<p><?php io_icon( 'instagram' ); ?><span><a href="<?php echo esc_url( $d['ig_url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $d['ig_handle'] ); ?></a></span></p>
		<?php endif; ?>
	</article>
	<?php
}

/** Formulário de agendamento (continua no WhatsApp da unidade escolhida). */
function io_booking_form( $title, $button ) {
	$data = array();
	foreach ( io_units() as $k => $label ) {
		$data[ $k ] = array(
			'phone' => preg_replace( '/\D/', '', (string) io_o( $k . '_wa' ) ),
			'name'  => io_o( $k . '_name' ),
		);
	}
	?>
	<form class="form" id="agendar" novalidate data-units="<?php echo esc_attr( wp_json_encode( $data ) ); ?>">
		<h3><?php echo esc_html( $title ); ?></h3>
		<label>Seu nome
			<input type="text" name="nome" autocomplete="name" required>
		</label>
		<label>Onde você quer ser atendido?
			<select name="unidade" required>
				<?php foreach ( io_units() as $k => $label ) : ?>
					<option value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( io_o( $k . '_name' ) . ' (' . io_o( $k . '_short' ) . ')' ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Como podemos ajudar? <span class="opt">(opcional)</span>
			<textarea name="msg" rows="3" placeholder="Ex.: quero avaliar um aparelho ortodôntico"></textarea>
		</label>
		<button class="btn btn--dark btn--block" type="submit"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( $button ); ?></button>
		<p class="form__hint" role="status" aria-live="polite"></p>
	</form>
	<?php
}

/** Menu de emergência se nenhum menu foi atribuído. */
function io_fallback_menu() {
	echo '<ul class="nav__list">';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 2,
		)
	);
	echo '</ul>';
}
