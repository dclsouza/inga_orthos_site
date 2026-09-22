<?php
/**
 * Template Name: Serviços
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Ingá Orthos Odontologia' );
?>

<section class="section section--cream" id="especialidades">
	<div class="wrap spec">
		<div class="spec__intro">
			<h2><?php echo esc_html( io( 'serv_title' ) ); ?></h2>
			<p><?php io_rich( io( 'serv_text' ) ); ?></p>
			<?php if ( io( 'serv_image' ) ) : ?>
				<figure class="spec__fig">
					<?php echo io_img_tag( io( 'serv_image' ), '', array(), 'medium_large' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					<figcaption><?php echo esc_html( io( 'serv_caption' ) ); ?></figcaption>
				</figure>
			<?php endif; ?>
		</div>
		<ul class="spec__list">
			<?php foreach ( (array) io( 'services' ) as $s ) : ?>
				<li>
					<h3><?php echo esc_html( $s['name'] ); ?></h3>
					<p><?php io_rich( $s['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="section__head">
			<h2><?php echo esc_html( io( 'more_title' ) ); ?></h2>
		</header>
		<div class="linkcards">
			<a class="linkcard linkcard--kids" href="<?php echo esc_url( io_url( '@kids' ) ); ?>"><strong>Icaraí Ortho Kids</strong><span><?php echo esc_html( io( 'more_kids' ) ); ?></span><?php io_icon( 'arrow' ); ?></a>
			<a class="linkcard" href="<?php echo esc_url( io_url( '@choque' ) ); ?>"><strong>Terapia de Choque</strong><span><?php echo esc_html( io( 'more_choque' ) ); ?></span><?php io_icon( 'arrow' ); ?></a>
		</div>
	</div>
</section>

<?php
io_cta_band( 'Vamos planejar o seu tratamento?', 'Agende uma avaliação e conheça as melhores opções para o seu caso.', 'Agendar consulta', io_book_url( 'odonto' ) );
get_footer();
