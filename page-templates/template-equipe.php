<?php
/**
 * Template Name: Nossa Equipe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

io_page_head( get_the_title(), io( 'head_lead' ), 'Ingá Orthos' );

$groups = array(
	'odonto' => array( 'Ingá Orthos Odontologia', 'Especialistas que atendem crianças, adultos e idosos.' ),
	'kids'   => array( 'Icaraí Ortho Kids', 'Odontopediatras e equipe de apoio da clínica infantil.' ),
	'choque' => array( 'Terapia de Choque', '' ),
);
?>

<?php foreach ( $groups as $key => $info ) : ?>
	<?php $rows = io_team( $key ); ?>
	<?php if ( ! $rows ) { continue; } ?>
	<section class="section<?php echo 'kids' === $key ? ' section--cream' : ' section--tight'; ?>" id="equipe-<?php echo esc_attr( $key ); ?>">
		<div class="wrap">
			<header class="section__head section__head--split">
				<h2><?php echo esc_html( $info[0] ); ?></h2>
				<?php if ( $info[1] ) : ?>
					<p><?php echo esc_html( $info[1] ); ?></p>
				<?php elseif ( 'choque' === $key ) : ?>
					<p><?php io_rich( io( 'note_choque' ) ); ?></p>
				<?php endif; ?>
			</header>
			<div class="team team--bios">
				<?php foreach ( $rows as $r ) : ?>
					<?php io_team_card( $r, true ); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endforeach; ?>

<?php
io_cta_band( 'Quer conhecer a equipe pessoalmente?', 'Agende uma consulta e venha nos visitar.', 'Agendar consulta', io_book_url( 'odonto' ) );
get_footer();
