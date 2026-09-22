<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
io_page_head( 'Página não encontrada', 'O endereço que você acessou não existe mais ou foi digitado errado.', 'Erro 404' );
?>
<section class="section section--tight">
	<div class="wrap">
		<div class="empty">
			<h2>Vamos te levar de volta.</h2>
			<p>Use o menu no topo ou volte para a página inicial.</p>
			<a class="btn btn--dark btn--sm" href="<?php echo esc_url( home_url( '/' ) ); ?>">Ir para o início</a>
		</div>
	</div>
</section>
<?php
get_footer();
