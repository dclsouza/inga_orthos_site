<?php
/**
 * Página genérica (sem modelo especial).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	io_page_head( get_the_title() );
	?>
	<article class="section section--tight">
		<div class="wrap wrap--narrow">
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
