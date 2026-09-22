<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$ctx = io_context();
?>
</main>

<footer class="footer">
	<div class="wrap footer__in">
		<div class="footer__brand">
			<?php echo io_img_tag( io_o( 'logo_odonto_light' ), 'Ingá Orthos, odontologia e ortopedia', array(), 'medium' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<p><?php echo esc_html( io_o( 'footer_tagline' ) ); ?></p>
		</div>

		<nav class="footer__nav" aria-label="Rodapé">
			<h4>Navegue</h4>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer__list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<div class="footer__units">
			<h4>Unidades</h4>
			<?php foreach ( io_units() as $k => $label ) : ?>
				<?php $d = io_unit( $k ); ?>
				<p>
					<b><?php echo esc_html( $d['name'] ); ?></b>
					<a href="<?php echo esc_url( 'https://wa.me/' . $d['wa'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $d['wa_label'] ); ?></a>
				</p>
			<?php endforeach; ?>
		</div>

		<div class="footer__social">
			<h4>Siga a gente</h4>
			<?php foreach ( io_units() as $k => $label ) : ?>
				<?php $d = io_unit( $k ); ?>
				<?php if ( $d['ig_url'] ) : ?>
					<a href="<?php echo esc_url( $d['ig_url'] ); ?>" target="_blank" rel="noopener"><?php io_icon( 'instagram' ); ?><?php echo esc_html( $d['ig_handle'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="wrap">
		<div class="footer__legal">
			<p><?php echo esc_html( io_o( 'legal' ) ); ?></p>
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Ingá Orthos. Todos os direitos reservados.</p>
		</div>
	</div>
</footer>

<a class="wa-float" href="<?php echo esc_url( io_wa_url( $ctx, 'Olá! Gostaria de marcar uma consulta.' ) ); ?>" target="_blank" rel="noopener" aria-label="Falar no WhatsApp"><?php io_icon( 'whatsapp' ); ?></a>

<?php wp_footer(); ?>
</body>
</html>
