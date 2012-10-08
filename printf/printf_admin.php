<?
// create custom plugin settings menu
add_action('admin_menu', 'printf_create_menu');

function printf_create_menu() {

	//create new top-level menu
	add_menu_page('PrintF Settings', 'PrintF Settings', 'administrator', __FILE__, 'printf_settings_page',plugins_url('f.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'printf-settings-group', 'printf_ydays' );
	register_setting( 'printf-settings-group', 'printf_ztop' );
	register_setting( 'printf-settings-group', 'printf_xreg' );
}

function printf_settings_page() {
?>
<div class="wrap">
<h2>PrintF Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'printf-settings-group' ); ?>
    <?php do_settings_sections( 'printf-settings-group' ); ?>
    <table class="form-table">
         
        <tr valign="top">
        <th scope="row">Number of days to look back through for posts</th>
        <td><input type="text" name="printf_ydays" value="<?php echo get_option('printf_ydays'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Max number of top stories to display</th>
        <td><input type="text" name="printf_ztop" value="<?php echo get_option('printf_ztop'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Max number of regular stories to display</th>
        <td><input type="text" name="printf_xreg" value="<?php echo get_option('printf_xreg'); ?>" /></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>