<?php
/**
 * Template Name: Quem somos
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Ingá Orthos' );
?>

<section class="section">
	<div class="wrap about">
		<div class="about__text">
			<h2><?php echo esc_html( io( 'intro_title' ) ); ?></h2>
			<div class="prose"><?php io_paragraphs( io( 'intro_text' ) ); ?></div>
		</div>
		<figure class="about__photo">
			<?php echo io_img_tag( io( 'intro_image' ), 'Recepção da Ingá Orthos', array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</figure>
	</div>
</section>

<section class="section section--cream">
	<div class="wrap">
		<ol class="timeline">
			<?php foreach ( (array) io( 'timeline' ) as $t ) : ?>
				<li>
					<span class="timeline__year"><?php echo esc_html( $t['year'] ); ?></span>
					<h3><?php echo esc_html( $t['title'] ); ?></h3>
					<p><?php io_rich( $t['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="section__head">
			<h2><?php echo esc_html( io( 'pillars_title' ) ); ?></h2>
		</header>
		<ul class="pillars">
			<?php foreach ( (array) io( 'pillars' ) as $p ) : ?>
				<li>
					<span class="ico-round"><?php io_icon( $p['icon'] ); ?></span>
					<h3><?php echo esc_html( $p['title'] ); ?></h3>
					<p><?php io_rich( $p['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="linkcards">
			<a class="linkcard" href="<?php echo esc_url( io_url( '@equipe' ) ); ?>"><strong>Nossa equipe</strong><span>Conheça quem cuida de você</span><?php io_icon( 'arrow' ); ?></a>
			<a class="linkcard" href="<?php echo esc_url( io_url( '@instalacoes' ) ); ?>"><strong>Instalações</strong><span>Veja os ambientes da clínica</span><?php io_icon( 'arrow' ); ?></a>
		</div>
	</div>
</section>

<?php
io_cta_band( 'Vamos cuidar do seu sorriso?', 'Escolha a unidade e continue a conversa pelo WhatsApp.', 'Agendar consulta', io_book_url( 'odonto' ) );
get_footer();
