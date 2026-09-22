<?php
/**
 * Template Name: Icaraí Ortho Kids
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$msg = 'Olá! Gostaria de agendar uma consulta para meu filho(a).';
?>

<!-- Destaque Kids -->
<section class="k-hero">
	<div class="wrap k-hero__in">
		<div class="k-hero__copy">
			<p class="eyebrow"><?php echo esc_html( io( 'k_eyebrow' ) ); ?></p>
			<h1><?php io_rich( io( 'k_title' ) ); ?></h1>
			<p class="lead"><?php io_rich( io( 'k_lead' ) ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--dark" href="<?php echo esc_url( io_wa_url( 'kids', $msg ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( io( 'k_cta' ) ); ?></a>
				<?php if ( io_o( 'kids_ig_url' ) ) : ?>
					<a class="btn btn--line" href="<?php echo esc_url( io_o( 'kids_ig_url' ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'instagram' ); ?><?php echo esc_html( io_o( 'kids_ig_handle' ) ); ?></a>
				<?php endif; ?>
			</div>
			<p class="k-hero__where"><?php io_icon( 'pin' ); ?><span><?php io_rich( io_o( 'kids_address' ) ); ?></span></p>
		</div>
		<div class="k-hero__visual">
			<?php echo io_img_tag( io( 'k_image' ), 'Dentista sorrindo com uma criança na cadeira do consultório', array( 'loading' => 'eager', 'fetchpriority' => 'high' ), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo io_img_tag( 'theme:mascote-kids.png', '', array( 'class' => 'k-hero__giraffe' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>

<!-- Frases -->
<?php $tags = (array) io( 'taglines' ); ?>
<?php if ( $tags ) : ?>
<section class="k-tags" aria-label="Nosso jeito de cuidar">
	<div class="wrap">
		<ul>
			<?php foreach ( $tags as $t ) : ?>
				<li><?php io_icon( 'star' ); ?><p><?php io_rich( $t['text'] ); ?></p></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<!-- Serviços -->
<section class="section k-services">
	<div class="wrap">
		<header class="section__head section__head--split">
			<h2><?php echo esc_html( io( 'ks_title' ) ); ?></h2>
			<p><?php io_rich( io( 'ks_text' ) ); ?></p>
		</header>
		<ul class="k-cards">
			<?php foreach ( (array) io( 'kservices' ) as $s ) : ?>
				<li>
					<span class="ico-round"><?php io_icon( $s['icon'] ); ?></span>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p><?php io_rich( $s['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- Fotos -->
<section class="section section--tight">
	<div class="wrap k-photos">
		<?php echo io_img_tag( io( 'k_photo1' ), 'Icaraí Ortho Kids', array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php echo io_img_tag( io( 'k_photo2' ), 'Ambiente colorido da clínica infantil', array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>

<!-- Equipe -->
<?php $kteam = io_team( 'kids' ); ?>
<?php if ( $kteam ) : ?>
<section class="section section--kids-soft" id="equipe-kids">
	<div class="wrap">
		<header class="section__head section__head--split">
			<h2><?php echo esc_html( io( 'k_team_title' ) ); ?></h2>
			<p><?php io_rich( io( 'k_team_text' ) ); ?></p>
		</header>
		<div class="team team--bios">
			<?php foreach ( $kteam as $r ) : ?>
				<?php io_team_card( $r, true ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Depoimentos da unidade -->
<?php $kq = io_quotes( 'kids' ); ?>
<?php if ( $kq ) : ?>
<section class="section">
	<div class="wrap">
		<?php io_quote_cards( $kq ); ?>
	</div>
</section>
<?php endif; ?>

<!-- Contato -->
<section class="section section--tight">
	<div class="wrap k-contact">
		<?php io_place_block( 'kids', 'place--kids' ); ?>
		<div class="k-contact__cta">
			<h2>Vamos marcar a primeira visita?</h2>
			<p>Chame a gente pelo WhatsApp e conte a idade do seu pequeno. Cuidamos do resto.</p>
			<a class="btn btn--dark" href="<?php echo esc_url( io_wa_url( 'kids', $msg ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?>Agendar na Ortho Kids</a>
		</div>
	</div>
</section>

<?php
get_footer();
