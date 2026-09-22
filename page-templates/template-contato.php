<?php
/**
 * Template Name: Contatos
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Fale com a gente' );
$q = rawurlencode( io_o( 'maps_query' ) );
?>

<section class="section section--tight contato">
	<div class="wrap">
		<div class="contato__grid">
			<?php io_booking_form( io( 'form_title' ), io( 'form_btn' ) ); ?>
			<div class="places">
				<?php io_place_block( 'odonto' ); ?>
				<?php io_place_block( 'kids', 'place--kids' ); ?>
				<?php io_place_block( 'choque' ); ?>
			</div>
		</div>

		<div class="map">
			<iframe title="Mapa da Ingá Orthos" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
				src="<?php echo esc_url( 'https://www.google.com/maps?q=' . $q . '&output=embed' ); ?>"></iframe>
			<a class="map__link btn btn--dark btn--sm" href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . $q ); ?>" target="_blank" rel="noopener">Como chegar</a>
		</div>
	</div>
</section>

<?php
get_footer();
