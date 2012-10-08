<?
/*
		Plugin Name: PrintF
		Plugin URI: http://wordpressfornews.dreamhosters.com/wp/
		Description: Plugin for dynamically generating the front page depending on the types of posts.
		Author: Yee Wai, Audrey Ross, Lorena Villa
		Version: 1.0
		*/
		
		
include('printf_admin.php');
include('featured-widget.php');


add_action( 'init', 'create_NewsType_taxonomy', 0 );
 
function create_NewsType_taxonomy() {
	if (!taxonomy_exists('NewsType')) {
		register_taxonomy( 'NewsType',
		  array( 'hierarchical' => false, 
		  'orderby'    => 'count',
		));
 
		wp_insert_term('Breaking', 'NewsType');
		wp_insert_term('Top', 'NewsType');
		wp_insert_term('Featured', 'NewsType');
		wp_insert_term('Regular', 'NewsType');
		
	}
}


function add_NewsType_box() {
remove_meta_box('tagsdiv-NewsType','post','core');
	add_meta_box('NewsType_box_ID', __('Story Category'), 'your_styling_function', 'post', 'side', 'core');
}	
 
function add_NewsType_menus() {
 
	if ( ! is_admin() )
		return;
 
	add_action('admin_menu','add_NewsType_box' );//,
	/* Use the save_post action to save new post data */
	add_action('save_post', 'save_taxonomy_data');
}
 
add_NewsType_menus();


// This function gets called in edit-form-advanced.php
function your_styling_function($post) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_NewsType' ) . '" />';
 
 
	// Get all toryCategory taxonomy terms
	$NewsTypes = array('breaking','top', 'regular', 'featured');
 
?>
<!-- Display NewsTypes as options -->
<?php 
	$names = wp_get_object_terms($post->ID, 'NewsType'); 
	?>
    
    <? /* 

	 */?>
	<select name='post_NewsType' id='post_NewsType'>
	<!-- Display NewsTypes as options -->
    <?php 
	$names = wp_get_object_terms($post->ID, 'NewsType'); 
	?>
	<?php 
	foreach ($NewsTypes as $NewsType) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($NewsType, $names[0]->slug)) 
			echo "<option class='NewsType-option' value='" . $NewsType . "' selected>" . ucwords($NewsType) . "</option>\n"; 
		else
			echo "<option class='NewsType-option' value='" . $NewsType . "'>" . ucwords($NewsType) . "</option>\n"; 
	}
   ?>
   <option class='NewsType-option' value='' <?php if (!count($names)) echo "selected";?>>Not displayed</option>
</select>  
<?php
}

/////SAVING////////////////////////////////////////


function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.
 
 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_NewsType' )) {
    	return $post_id;
  	}
 
  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    	return $post_id;
 
  	// Check permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
      		return $post_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $post_id ) )
      	return $post_id;
  	}
 
  	// OK, we're authenticated: we need to find and save the data
	$post = get_post($post_id);
	if (($post->post_type == 'post') || ($post->post_type == 'page')) { 
           // OR $post->post_type != 'revision'
           $NewsType = $_POST['post_NewsType'];
	   wp_set_object_terms( $post_id, $NewsType, 'NewsType' );
        }
	return $NewsType;
 
}
?>

