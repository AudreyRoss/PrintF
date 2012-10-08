<?php

the_terms( $post->ID, 'StoryType', 'type: ','Breaking', 'Top', 'Regular', 'Meh ' );




function pf_get_image($num=1) {
	global $more;
	$more = 1;
	$link = get_permalink();
	$content = get_the_content();
	$count = substr_count($content, '<img');
	$start = 0;
	for($i=1;$i<=$count;$i++) {
		$imgBeg = strpos($content, '<img', $start);
		$post = substr($content, $imgBeg);
		$imgEnd = strpos($post, '>');
		$postOutput = substr($post, 0, $imgEnd+1);
		$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);;
		$image[$i] = $postOutput;
		$start=$imgEnd+1;
	} 
	if(stristr($image[$num],'<img')) { return $image[$num];  }
	$more = 0;
	return 'Nope';

}

function printf_breaking($id) {
	if (empty($id)) { 
	return false;}
	if (is_array($id)) { $id = $id[0];}
	$query = new WP_Query( 'p='.$id );
	$query->the_post(); 
	//echo '<div class="breaks"> <div style="padding-left: 5%; font-size: 24px; font-weight: bold; font-style: italic;/* background-color: red;*/ width: 95%">Breaking News: </div>';
	echo '<div class="breaks">';
	if ( pf_get_image() != "Nope") {
		echo pf_get_image();
	} 
	?> 
    <span class="entry-title" style="font-size:42px;"><a href="<?php the_permalink() ?>" ><h2><?php the_title(); ?></h2></a></span>
    <p id="timestamp">Posted: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></p>
    <p><?php the_excerpt(); ?> </p>
    <?
	echo '</div>';
}

function printf_top($pic, $nopic) {

	if (count($pic) > 2) { //Do the Carousel ?> 
    <div id="primary"><div id="content" role="main">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script>
        <script type="text/javascript"> 
            $(document).ready(function(){
                $("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 10000, true);
            });
		</script>
    	<div id="featured" >
		<? 
		$count = 0;
		foreach ($pic as $id) {
			$query = new WP_Query( 'p='.$id );
			$query->the_post(); 
        ?>
         	<div id="fragment-<? echo $count; ?>" class="ui-tabs-panel" style="">
         <?
            if ( pf_get_image() != "Nope") {
                echo pf_get_image();
            } 
            //Store title in thingy thingy for the sidebar of the slideshow 
            $tits[] = get_the_title($post->ID);
         ?>
             <div class="info" style="background:#666;
                                    overflow: hidden;
                                    -moz-opacity: 0.70;
                                    opacity: 0.70;
                                    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=70);">
                <!--<h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>-->
                <p><?php the_excerpt(); ?> </p>
             </div>
        </div>
        <?
		$count ++;
		}
        for ($ii = 0; $ii < count($tits); $ii ++) {
			if ($ii == 0) {
				echo '<ul class="ui-tabs-nav"><span style="padding-left: 3%;">Top Stories</span>';
				echo '<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-0"><a href="#fragment-0"><span>'.$tits[$ii].'</span></a></li>';
			} else {
				echo '<li class="ui-tabs-nav-item" id="nav-fragment-'.$ii.'"><a href="#fragment-'.$ii.'"><span>'.$tits[$ii].'</span></a></li>';
			}
			
			if ($ii + 1 == $top) {
				echo '</ul>';
			}
		}
		echo '</div>';
		if (!empty($nopic)) {
			foreach ($nopic as $id) {
				$query = new WP_Query( 'p='.$id );
				$query->the_post(); ?>
				<div class="tops">
					<span class="entry-title"><a href="<?php the_permalink() ?>" ><h2><?php the_title(); ?></h2></a></span>
                    <p id="timestamp">Posted: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></p>
					<p><?php the_excerpt(); ?> </p>
				</div> <?
			}
		}
    } elseif (($tots = (count($pic) + count($nopic))) > 0) {
		$count = 0;
		if ($tots < 2)  { echo '<div id="primary"><div id="content" role="main">';}
		foreach($pic as $id) {
			$query = new WP_Query( 'p='.$id );
			$query->the_post(); 
			if ($tots >1 && $count < 2) { echo '<div class="regs" >';	}
			else { echo '<div class="tops">'; } ?>
				<span class="entry-title"><a href="<?php the_permalink() ?>" ><h2><?php the_title(); ?></h2></a></span>
                <p id="timestamp">Posted: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></p>
                <? echo pf_get_image(); ?>
				<p><?php the_excerpt(); ?> </p>
			</div> <?
			$count ++;
			if ($count == 2) { echo '<div id="primary"><div id="content" role="main">'; }
		}
		
		foreach($nopic as $id) {
			$query = new WP_Query( 'p='.$id );
			$query->the_post(); 
			if ($tots > 1 && $count < 2) { echo '<div class="regs" >';	}
			else { echo '<div class="tops">'; } ?>
            <span class="entry-title"><a href="<?php the_permalink() ?>" ><h2><?php the_title(); ?></h2></a></span>
            <p id="timestamp">Posted: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></p>
					<p><?php the_excerpt(); ?> </p>
				</div> <?
				$count ++;
			if ($count == 2) { echo '<div id="primary"><div id="content" role="main">'; }
		}
		
	} else { echo '<div id="primary"><div id="content" role="main">'; }
}

function printf_regular($ids) {
	?>
    
    <div id="container">
    <?
	foreach ($ids as $id) {
		$query = new WP_Query( 'p='.$id ); 
		//$query= new WP_Query( "taxonomy='NewsType'&term='Regular'->slug&posts_per_page=4" );
		$query->the_post(); ?>
		<div class="regs" style="font-size:12px;">
        	<span class="entry-title" style="font-size:16px;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></span>
            <p id="timestamp">Posted: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></p>
         	<p><?php the_excerpt(); ?> </p>
        </div> <?
	}?>
    
    </div>
    <?
}

 ?>