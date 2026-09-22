<?php
/**
 * Blog (lista de publicações), arquivos e busca.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

if ( is_home() && get_option( 'page_for_posts' ) ) {
	$title = get_the_title( (int) get_option( 'page_for_posts' ) );
	$lead  = 'Dicas de saúde bucal, ortopedia e novidades da clínica.';
} elseif ( is_search() ) {
	$title = 'Resultados da busca';
	$lead  = sprintf( 'Resultados para "%s".', get_search_query() );
} elseif ( is_archive() ) {
	$title = wp_strip_all_tags( get_the_archive_title() );
	$lead  = '';
} else {
	$title = 'Blog';
	$lead  = 'Dicas de saúde bucal, ortopedia e novidades da clínica.';
}
io_page_head( $title, $lead, 'Blog' );
?>

<section class="section section--tight">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="post-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'io-card' ); ?></a>
						<?php endif; ?>
						<div class="post-card__body">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
							<a class="link" href="<?php the_permalink(); ?>">Ler mais<?php io_icon( 'arrow' ); ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => 'Anterior',
					'next_text' => 'Próxima',
				)
			);
			?>
		<?php else : ?>
			<div class="empty">
				<h2>Nenhuma publicação por aqui ainda.</h2>
				<p>Assim que a clínica publicar dicas e novidades, elas aparecem nesta página. Para escrever a primeira, acesse <strong>Posts &gt; Adicionar novo</strong> no painel do WordPress.</p>
				<a class="btn btn--dark btn--sm" href="<?php echo esc_url( home_url( '/' ) ); ?>">Voltar para o início</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
