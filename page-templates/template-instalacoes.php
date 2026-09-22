<?php
/**
 * Template Name: Instalações
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Ingá Orthos' );
?>

<section class="section section--tight">
	<div class="wrap">
		<ul class="gallery">
			<?php foreach ( (array) io( 'gallery' ) as $g ) : ?>
				<?php
				$full = io_img( $g['image'], 'full' );
				if ( ! $full ) {
					continue;
				}
				?>
				<li>
					<a href="<?php echo esc_url( $full ); ?>" data-lightbox data-caption="<?php echo esc_attr( $g['caption'] ); ?>">
						<?php echo io_img_tag( $g['image'], $g['caption'], array(), 'io-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<span><?php echo esc_html( $g['caption'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
io_cta_band( 'Venha conhecer de perto.', 'Agende uma visita e sinta o acolhimento da clínica.', 'Agendar consulta', io_book_url( 'odonto' ) );
get_footer();
