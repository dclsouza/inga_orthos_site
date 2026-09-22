<?php
/**
 * Template Name: English
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Ingá Orthos' );
?>

<div lang="en">
	<section class="section">
		<div class="wrap about about--text">
			<div class="about__text">
				<h2><?php echo esc_html( io( 'en_title' ) ); ?></h2>
				<div class="prose"><?php io_paragraphs( io( 'en_text' ) ); ?></div>
			</div>
		</div>
	</section>

	<section class="section section--cream">
		<div class="wrap">
			<div class="units">
				<?php foreach ( (array) io( 'en_units' ) as $row ) : ?>
					<?php
					$u   = $row['unit'];
					$d   = io_unit( $u );
					$mod = 'odonto' === $u ? 'inga' : $u;
					?>
					<article class="unit unit--<?php echo esc_attr( $mod ); ?> unit--text">
						<div class="unit__body">
							<h3><?php echo esc_html( $row['title'] ); ?><small><?php echo esc_html( $d['short'] ); ?></small></h3>
							<p><?php io_rich( $row['text'] ); ?></p>
							<div class="unit__actions">
								<a class="btn btn--dark btn--sm" href="<?php echo esc_url( io_wa_url( $u, "Hello! I'd like to book an appointment." ) ); ?>" target="_blank" rel="noopener">WhatsApp</a>
								<span class="unit__phone"><?php echo esc_html( $d['wa_label'] ); ?></span>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php io_cta_band( io( 'en_contact_title' ), io( 'en_contact_text' ), io( 'en_contact_btn' ), io_wa_url( 'odonto', "Hello! I'd like to book an appointment." ) ); ?>
</div>

<?php
get_footer();
