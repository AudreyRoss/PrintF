<? 
// Start class soup_widget //

class printf_featured_widget extends WP_Widget {

// Constructor //

	function printf_featured_widget() {
		$widget_ops = array( 'classname' => 'printf_featured_widget', 'description' => 'Displays links to featured stories.' ); 
		$control_ops = array( 'id_base' => 'printf_featured_widget' ); 
		$this->WP_Widget( 'printf_featured_widget', 'PrintF: Featured', $widget_ops, $control_ops ); 
	}
	
	/**
     * Outputs the content of the widget.
     *
     * @args            The array of form elements
     * @instance
     */
	function widget($args, $instance) {
        // TODO
		extract( $args );
		$title 		= apply_filters('widget_title', $instance['printf_featured_tit']); // the widget title
		$featured_limit 	= $instance['printf_wfeatured']; // the number of posts to show
		$col1=$instance['printf_featured_col1'];
		$col2=$instance['printf_featured_col2'];
		echo $before_widget;
		echo '<div style="padding: 3% 5% 8% 5%;
		border-radius: 11px; 
-moz-border-radius: 11px; 
-webkit-border-radius: 11px; 
border: 1px outset #A1A1A1;
		background-image: linear-gradient(bottom, '.$col1.' 50%, '.$col2.' 100%);
background-image: -o-linear-gradient(bottom, '.$col1.' 50%, '.$col2.' 100%);
background-image: -moz-linear-gradient(bottom, '.$col1.' 50%, '.$col2.' 100%);
background-image: -webkit-linear-gradient(bottom, '.$col1.' 50%, '.$col2.' 100%);
background-image: -ms-linear-gradient(bottom, '.$col1.' 50%, '.$col2.' 100%);

background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0.5, '.$col1.'),
	color-stop(1, '.$col2.')
);">';

		echo $before_title . $title . $after_title;
		$args = array(
		'tax_query' => array(
			array(
				'taxonomy' => 'NewsType',
				'field' => 'slug',
				'terms' => 'featured'	//[YO YO YO] Change this to featured whenever audrey gets around to making it. 
				)
			),
			'posts_per_page' => $featured_limit
		);
		$query = new WP_Query( $args );
		echo '<ul style="list-style: none">';
		while ( $query->have_posts() ) : $query->the_post(); ?>
			<li style="border-top: thin solid #A1A1A1">
			<a href="<?php the_permalink() ?>" ><?php the_title(); ?></a>
			</li>
		<? endwhile;
		echo '</ul>';
		echo '</div>';
		echo $after_widget;
    } // end widget
    
    /**
     * Processes the widget's options to be saved.
     *
     * @new_instance    The previous instance of values before the update.
     * @old_instance    The new instance of values to be generated via the update.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
		$instance['printf_wfeatured'] = strip_tags(stripslashes($new_instance['printf_wfeatured']));
		$instance['printf_featured_tit'] = strip_tags(stripslashes($new_instance['printf_featured_tit']));
		$instance['printf_featured_col1'] = strip_tags(stripslashes($new_instance['printf_featured_col1']));
		$instance['printf_featured_col2'] = strip_tags(stripslashes($new_instance['printf_featured_col2']));
			
		return $instance;
    } // end widget
    
    /**
     * Generates the administration form for the widget.
     *
     * @instance    The array of keys and values for the widget.
     */
    function form($instance) {
		//retrieve data
        $instance = wp_parse_args(
        (array)$instance,
        array(
            'printf_wfeatured' => '6',
			'printf_featured_tit' => 'Featured Stories', 
			'printf_featured_col1'=> '#DEDEDE',
			'printf_featured_col2' => '#F7F7F7'
        	)
		);
			
		$printf_wfeatured = strip_tags(stripslashes($instance['printf_wfeatured'])); 
		$printf_featured_tit = strip_tags(stripslashes($instance['printf_featured_tit']));
		?>
		<div>
        	<label for="<?php echo $this->get_field_id('printf_featured_tit'); ?>">
                Title <br />
            </label>
			<input type="text" 
            		name="<?php echo $this->get_field_name('printf_featured_tit'); ?>" 
                    id="<?php echo $this->get_field_id('printf_featured_tit'); ?>" 
                    value="<?php echo $instance['printf_featured_tit']; ?>" 
                    class="widefat" />
            <br /><br />
            <label for="<?php echo $this->get_field_id('printf_wfeatured'); ?>">
                Number of posts to show: 
            </label>
			<input type="text" 
            		name="<?php echo $this->get_field_name('printf_wfeatured'); ?>" 
                    id="<?php echo $this->get_field_id('printf_wfeatured'); ?>" 
                    value="<?php echo $instance['printf_wfeatured']; ?>" 
                    size="3" />
             <br /><br />
            <label for="<?php echo $this->get_field_id('printf_featured_col1'); ?>">
                Top Background Color:
            </label>
			<input type="text" 
            		name="<?php echo $this->get_field_name('printf_featured_col1'); ?>" 
                    id="<?php echo $this->get_field_id('printf_featured_col1'); ?>" 
                    value="<?php echo $instance['printf_featured_col1']; ?>" 
                    size="7" />
             <br />
            <label for="<?php echo $this->get_field_id('printf_featured_col2'); ?>">
                Bottom Background Color:
            </label>
			<input type="text" 
            		name="<?php echo $this->get_field_name('printf_featured_col2'); ?>" 
                    id="<?php echo $this->get_field_id('printf_featured_col2'); ?>" 
                    value="<?php echo $instance['printf_featured_col2']; ?>" 
                    size="7" />

		</div>
		
		<?
    } // end form
    
} // end class
add_action('widgets_init', create_function('', 'register_widget("printf_featured_widget");'));
?>
		