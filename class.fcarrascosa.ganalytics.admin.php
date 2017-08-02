<?php
/**
 * Created by PhpStorm.
 * User: fcarrascosa
 * Date: 2/12/16
 * Time: 0:14
 */

class FCGoogleAnalytics_Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'fc_menu'));
    }

    public function fc_menu() {

        if( empty ($GLOBALS['admin_page_hooks']['fc-plugins']) ) {

            // TODO: Show all plugins installed by this plugin's author in main menu page.

            add_menu_page ( __('FC Plugins', 'fcarrascosa'), __('FC Plugins', 'fcarrascosa'), 'manage_options', 'fc-plugins', array($this, 'fc_options'), 'dashicons-list-view', 66);

            // End of To do
            remove_submenu_page( 'fc-plugins', 'fc-plugins' );

        }

        add_submenu_page( 'fc-plugins' , __('FC GAnalytics Plugin Options', 'fcarrascosa'), __('Google Analytics Options', 'fcarrascosa'), 'manage_options', 'fc-ga-options-page', array($this, 'fc_options') );

    }

    public function fc_options() {

        // Check if user is editor and nonce is valid

        if ( !current_user_can( 'manage_options' ))  {
            wp_die( __( 'You do not have sufficient permissions to access this page. Maybe you are trying to do something dirty?' ) );
        }

        if ( isset($_POST['fc-nonce']) && !wp_verify_nonce($_POST['fc-nonce'],'')) {
            wp_die( __( 'Security error. Are you doing something dirty?' ));
        }

        // Variables for Fields

        $hidden_field_name = 'fc_submit_hidden';

        $fc_google_analytics_code   = 'fc_google_code';
        $google_field_name          = 'fc_google_code';

        // Read if existing option value from database


        $fc_google_analytics_val        = get_option ($fc_google_analytics_code);
        $fc_google_analytics_val_old    = $fc_google_analytics_val;

        // See if the user has posted us some information
        // If they did, this hidden field will be set to 'Y'
        if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y') {

            // Sanitize value for google analytics code

            $fc_google_analytics_val    = sanitize_text_field($_POST[ $google_field_name]);

            // Check if google Analytics code matches the RegEx

            if ( preg_match ( '/^ua-\d{4,9}-\d{1,4}$/i', $fc_google_analytics_val) ) {

                // Save the posted value in the database

                update_option($google_field_name, $fc_google_analytics_val);

                // Display a "settings saved" message on the screen

                ?>
                <div class="updated"><p><strong><?php _e('Settings saved.', 'fcarrascosa'); ?></strong></p></div>
                <?php
            }else {

                // Display an Error Message

                ?>
                <div class="error"><p><strong><?php _e('Your code didn\'t match Google Analytics Code Structure.', 'fcarrascosa'); ?></strong></p></div>
                <?php
            }
        }

        // Now display the settings editing screen

        echo '<div class="wrap">';

        // header

        echo "<h2>" . __( 'FC Plugins', 'fc_theme' ) . "</h2>";

        // settings form
        ?>
        <form name="form1" method="post" action="">
            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
            <?php wp_nonce_field('', 'fc-nonce') ?>
            <h2><?php _e('Google Analytics','fc_theme');?></h2>
            <table>
                <tr>
                    <td>
                        <p>
                            <?php _e('Google Analytics Code:','fc_theme');?>
                        </p>
                    </td>
                    <td>
                        <p>
                            <input type="text" name="<?php echo $google_field_name; ?>" value="<?php echo esc_attr($fc_google_analytics_val); ?>" placeholder="<?php echo esc_attr($fc_google_analytics_val); ?>" size="20">
                        </p>
                    </td>
                </tr>
            </table>
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            <hr>
        </form>
        </div>

        <?php
    }

}

$fcGoogleAnalytics = new FCGoogleAnalytics_Admin();