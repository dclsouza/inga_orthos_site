<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	io_page_head( get_the_title(), '', get_the_date() );
	?>
	<article class="section section--tight">
		<div class="wrap wrap--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="post-hero"><?php the_post_thumbnail( 'io-card' ); ?></figure>
			<?php endif; ?>
			<div class="prose"><?php the_content(); ?></div>
			<nav class="post-nav" aria-label="Outras publicações">
				<?php previous_post_link( '%link', '← %title' ); ?>
				<?php next_post_link( '%link', '%title →' ); ?>
			</nav>
		</div>
	</article>
	<?php
endwhile;
io_cta_band( 'Ficou com alguma dúvida?', 'Fale com a nossa equipe pelo WhatsApp.', 'Agendar consulta', io_book_url( 'odonto' ) );
get_footer();
