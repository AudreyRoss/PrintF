<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header();  ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="wp-content/themes/printf-theme/jquery.masonry.min.js"></script>
<script>
  $(function(){
    
    $('#container').masonry({
      itemSelector: '.regs'
    });

  });
</script>

<?
if (isset($_GET['breaking'])) {
	$break = $_GET['breaking'];
} else {
	$break = $_GET['break'];
}
$top = $_GET['top'];
$count = 0;
$topLimit=get_option('printf_ztop');
$RegLimit=get_option('printf_xreg');
$BreakLimit=1;
    $recentPosts = new WP_Query();
    $recentPosts->query('showposts=5');
	$recentPosts->the_post();
?>
<?php
//$top = 3;
//initialize the arrays
$topNewsPicture = array();
$topNewsNoPicture = array();
$Regular=array();
$topNews=array();
$breakingNewsPosts=array();
// Get URL of first image in a post
function is_there_image($post_id) {
    //$post=get_post($post_id);
	$query = new WP_Query( 'p='.$post_id );
	$query->the_post(); 
	global $post;
	global $topNewsNoPicture;
	global $topNewsPicture;
	
	// no image found put in the no image array
	if(pf_get_image()=='Nope'){
		array_push($topNewsNoPicture, $post_id);
	}
	else {
	array_push($topNewsPicture, $post_id);}
}

//check the last x days, give an array of each of
//breaking news , top w/ pic, top w/o pic, and regular

$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'NewsType',
			'field' => 'slug',
			'terms' => 'breaking'
		)
	)
);

$loop =  new WP_Query( $args ); 
//Note: this needs to expire after a while (x days)
$i=0;
while ( $loop->have_posts() && $i < $BreakLimit ) : $loop->the_post();  
 array_push($breakingNewsPosts, $post->ID);
 $i++;
endwhile; 


$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'NewsType',
			'field' => 'slug',
			'terms' => 'top'
		)
	)
);

$loop = new WP_Query( $args );  
//Note: this needs to expire after a while (x days)<br />
//also, if there is no top story in last x days choose most recent top story
$i=0;
while ( $loop->have_posts() && $i <= $topLimit ) : $loop->the_post();  
 array_push($topNews, $post->ID);
 $i++;
endwhile; 

//check the top news array to see which posts have pictures
array_walk($topNews, "is_there_image");

////REGULAR
$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'NewsType',
			'field' => 'slug',
			'terms' => 'regular'
		)
	)
);
$loop = new WP_Query( $args );  
$i=0;
while ( $loop->have_posts() && $i < $RegLimit ) : $loop->the_post(); 
 array_push($Regular, $post->ID);
 $i++;
endwhile; 

?>
			
			<?php if ( have_posts() ) :
			/*
			$breakingNewsPosts[] = 69;
			$topNewsPicture = array(84, 74);
			$topNewsNoPicture[] = 67;
			$Regular = array(82, 78);*/
			
 ?> 
				<?php twentyeleven_content_nav( 'nav-above' );  //Oh hey. Maybe this is why it doesn't work with other themes....

				printf_breaking($breakingNewsPosts);
				// echo '<div id="primary"><div id="content" role="main">'; 
                printf_top($topNewsPicture, $topNewsNoPicture);
				printf_regular($Regular);       
				twentyeleven_content_nav( 'nav-below' ); //Oh hey. Maybe this is why it doesn't work with other themes....
				?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>