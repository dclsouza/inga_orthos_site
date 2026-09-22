<?php
/**
 * Template Name: Página Inicial
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$wa_msg = 'Olá! Gostaria de marcar uma consulta.';
?>

<!-- Destaque -->
<section class="hero">
	<div class="hero__photo" aria-hidden="true">
		<?php echo io_img_tag( io( 'hero_image' ), '', array( 'loading' => 'eager', 'fetchpriority' => 'high' ), 'io-hero' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
	<div class="wrap hero__in">
		<div class="hero__copy">
			<p class="eyebrow"><?php echo esc_html( io( 'hero_eyebrow' ) ); ?></p>
			<h1><?php echo esc_html( io( 'hero_title_1' ) ); ?> <span><?php echo esc_html( io( 'hero_title_2a' ) ); ?> <strong><?php echo esc_html( io( 'hero_title_2b' ) ); ?></strong></span></h1>
			<p class="lead"><?php io_rich( io( 'hero_lead' ) ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--dark" href="<?php echo esc_url( io_book_url( 'odonto' ) ); ?>"><?php io_icon( 'calendar' ); ?><?php echo esc_html( io( 'hero_cta1' ) ); ?></a>
				<a class="btn btn--line" href="<?php echo esc_url( io_wa_url( 'odonto', $wa_msg ) ); ?>" target="_blank" rel="noopener"><?php io_icon( 'whatsapp' ); ?><?php echo esc_html( io( 'hero_cta2' ) ); ?></a>
			</div>
			<ul class="trust">
				<?php foreach ( (array) io( 'trust' ) as $t ) : ?>
					<li><?php io_icon( $t['icon'] ); ?><span><?php io_rich( $t['text'] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<!-- Barra de especialidades -->
<div class="wrap">
	<ul class="spec-bar" aria-label="Principais especialidades">
		<?php foreach ( (array) io( 'specbar' ) as $s ) : ?>
			<li><a href="<?php echo esc_url( io_url( $s['url'] ) ); ?>"><?php io_icon( $s['icon'] ); ?><span><b><?php echo esc_html( $s['title'] ); ?></b><?php echo esc_html( $s['text'] ); ?></span></a></li>
		<?php endforeach; ?>
	</ul>
</div>

<!-- Três espaços -->
<section class="section" id="unidades">
	<div class="wrap">
		<header class="section__head section__head--split">
			<h2><?php io_rich( io( 'units_title' ) ); ?></h2>
			<p><?php io_rich( io( 'units_text' ) ); ?></p>
		</header>
		<div class="units">
			<?php foreach ( (array) io( 'units' ) as $row ) : ?>
				<?php io_unit_card( $row ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Estrutura -->
<section class="section section--tight" id="clinica">
	<div class="wrap">
		<div class="estrutura">
			<div class="estrutura__intro">
				<p class="eyebrow"><?php echo esc_html( io( 'est_eyebrow' ) ); ?></p>
				<h2><?php echo esc_html( io( 'est_title' ) ); ?></h2>
				<p><?php io_rich( io( 'est_text' ) ); ?></p>
				<a class="btn btn--line btn--sm estrutura__btn" href="<?php echo esc_url( io_url( '@instalacoes' ) ); ?>"><?php echo esc_html( io( 'est_link_label' ) ); ?><?php io_icon( 'arrow' ); ?></a>
			</div>
			<div class="estrutura__grid">
				<?php foreach ( (array) io( 'est_cards' ) as $c ) : ?>
					<figure class="card-photo">
						<?php echo io_img_tag( $c['image'], $c['caption'], array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<figcaption><span class="ico-round"><?php io_icon( $c['icon'] ); ?></span><?php echo esc_html( $c['caption'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- Números -->
<section class="facts" aria-label="Ingá Orthos em números">
	<div class="wrap facts__in">
		<?php foreach ( (array) io( 'facts' ) as $f ) : ?>
			<div><strong><?php echo esc_html( $f['title'] ); ?></strong><span><?php echo esc_html( $f['text'] ); ?></span></div>
		<?php endforeach; ?>
	</div>
</section>

<!-- Equipe (prévia) -->
<section class="section" id="equipe">
	<div class="wrap">
		<header class="section__head section__head--split">
			<h2><?php echo esc_html( io( 'team_title' ) ); ?></h2>
			<p><?php io_rich( io( 'team_text' ) ); ?></p>
		</header>
		<div class="team">
			<?php
			$shown = 0;
			foreach ( io_team( 'odonto' ) as $r ) {
				if ( empty( $r['photo'] ) ) {
					continue;
				}
				io_team_card( $r );
				if ( ++$shown >= 4 ) {
					break;
				}
			}
			?>
		</div>
		<p class="team__more team__more--center"><a class="btn btn--dark btn--sm" href="<?php echo esc_url( io_url( '@equipe' ) ); ?>"><?php echo esc_html( io( 'team_link_label' ) ); ?><?php io_icon( 'arrow' ); ?></a></p>
	</div>
</section>

<!-- Depoimentos -->
<?php if ( io_quotes() ) : ?>
<section class="section section--cream" id="depoimentos">
	<div class="wrap">
		<header class="section__head">
			<h2><?php echo esc_html( io( 'quotes_title' ) ); ?></h2>
		</header>
		<?php io_quote_cards( io_quotes() ); ?>
		<?php if ( io_o( 'doctoralia_url' ) ) : ?>
			<p class="quotes__more"><a class="link" href="<?php echo esc_url( io_o( 'doctoralia_url' ) ); ?>" target="_blank" rel="noopener">Ver mais avaliações no Doctoralia<?php io_icon( 'arrow' ); ?></a></p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php io_cta_band( io( 'cta_title' ), io( 'cta_text' ), io( 'cta_label' ), io_book_url( 'odonto' ) ); ?>

<?php
get_footer();
