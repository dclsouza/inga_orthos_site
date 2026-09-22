<?php
/**
 * Template Name: Terapia de Choque
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$msg = 'Olá! Gostaria de marcar uma consulta.';
?>

<!-- Destaque -->
<section class="c-hero">
	<div class="wrap c-hero__in">
		<div class="c-hero__copy">
			<p class="eyebrow"><?php echo esc_html( io( 'c_eyebrow' ) ); ?></p>
			<h1><?php echo esc_html( io( 'c_title' ) ); ?></h1>
			<p class="c-hero__sub"><?php echo esc_html( io( 'c_sub' ) ); ?></p>
			<p class="lead"><?php io_rich( io( 'c_lead' ) ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--gold" href="<?php echo esc_url( io_wa_url( 'choque', $msg ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( io( 'c_cta' ) ); ?></a>
				<?php if ( io_o( 'choque_ig_url' ) ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( io_o( 'choque_ig_url' ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'instagram' ); ?><?php echo esc_html( io_o( 'choque_ig_handle' ) ); ?></a>
				<?php endif; ?>
			</div>
			<ul class="c-hero__facts">
				<?php if ( io_o( 'choque_hours' ) ) : ?>
					<li><?php io_icon( 'clock' ); ?><?php echo esc_html( io_o( 'choque_hours' ) ); ?></li>
				<?php endif; ?>
				<?php if ( io_o( 'choque_note' ) ) : ?>
					<li><?php io_icon( 'check' ); ?><?php echo esc_html( io_o( 'choque_note' ) ); ?></li>
				<?php endif; ?>
			</ul>
		</div>
		<figure class="c-hero__photo">
			<?php echo io_img_tag( io( 'c_image' ), 'Médico aplicando a terapia de ondas de choque em um paciente', array( 'loading' => 'eager', 'fetchpriority' => 'high' ), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</figure>
	</div>
</section>

<!-- Como funciona -->
<section class="section">
	<div class="wrap c-how">
		<div>
			<h2><?php echo esc_html( io( 'c_how_title' ) ); ?></h2>
			<div class="prose"><?php io_paragraphs( io( 'c_how_text' ) ); ?></div>
		</div>
		<aside class="c-cond">
			<h3><?php echo esc_html( io( 'c_cond_title' ) ); ?></h3>
			<ul class="tags tags--light">
				<?php foreach ( io_lines( io( 'c_conditions' ) ) as $c ) : ?>
					<li><?php echo esc_html( $c ); ?></li>
				<?php endforeach; ?>
			</ul>
		</aside>
	</div>
</section>

<!-- Áreas -->
<section class="section c-areas-wrap">
	<div class="wrap">
		<header class="section__head">
			<h2><?php echo esc_html( io( 'c_areas_title' ) ); ?></h2>
		</header>
		<div class="choque__areas">
			<?php foreach ( (array) io( 'c_areas' ) as $a ) : ?>
				<section>
					<h3><?php io_icon( $a['icon'] ); ?><?php echo esc_html( $a['title'] ); ?></h3>
					<ul>
						<?php foreach ( io_lines( $a['items'] ) as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Depoimentos -->
<?php $cq = io_quotes( 'choque' ); ?>
<?php if ( $cq ) : ?>
<section class="section section--cream">
	<div class="wrap">
		<?php io_quote_cards( $cq ); ?>
	</div>
</section>
<?php endif; ?>

<!-- Contato -->
<section class="section section--tight">
	<div class="wrap k-contact">
		<?php io_place_block( 'choque' ); ?>
		<div class="k-contact__cta">
			<h2>Comece a recuperar a sua qualidade de vida.</h2>
			<p>Fale com a equipe pelo WhatsApp e agende a sua avaliação.</p>
			<a class="btn btn--dark" href="<?php echo esc_url( io_wa_url( 'choque', $msg ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( io( 'c_cta' ) ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
