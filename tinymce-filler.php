<?php
/**
 * Plugin Name: TinyMCE Filler
 * Plugin URI: http://trepmal.com/
 * Description: Quickly embed filler
 * Version: 1.0
 * Author: Kailey Lampert
 * Author URI: http://kaileylampert.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

$tinymce_filler = new TinyMCE_Filler();

class TinyMCE_Filler {

	var $pluginname = 'Phrases';
	var $buttonname = 'Filler';

	/**
	 * the constructor
	 *
	 * @return void
	 */
	function __construct()  {

		// init process for button control
		add_action('init',                  array( $this, 'addbuttons' ) );
		add_action('admin_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

	}

	/**
	 * prep data to pass to tinymce plugin
	 *
	 * @return void
	 */
	function wp_enqueue_scripts() {
		// hooking on to media-upload is a bit hacky, but it works
		wp_localize_script( 'media-upload', 'mcePhrases', array(
			'pluginName' => esc_js( $this->pluginname ),
			'buttonName' => esc_js( $this->buttonname ),
			'fillers'    => array(
				array(
					esc_js( 'text' )  => esc_js( 'Lorem Ipsum' ),
					esc_js( 'value' ) => esc_js( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris placerat dolor massa.' )
				),
				array(
					esc_js( 'text' )  => esc_js( 'Bacon Ipsum' ),
					esc_js( 'value' ) => esc_js( 'Bacon ipsum dolor sit amet andouille brisket beef ribs ribeye, pork chop pig swine.' )
				),
				array(
					esc_js( 'text' )  => esc_js( 'Lorizzle Ipsum' ),
					esc_js( 'value' ) => esc_js( 'Lorizzle ipsum fo shizzle sizzle shut the shizzle up, im in the shizzle adipiscing pizzle.' )
				),
			),
			'default'    => esc_js( 'Bacon Ipsum' ),
		) );

	}

	/**
	 * register tinymce plugin and button
	 *
	 * @return void
	 */
	function addbuttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		// Add only in Rich Editor mode
		if ( 'true' != get_user_option('rich_editing') )
			return;

		// register tinymce plugin and button
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
		add_filter( 'mce_buttons',          array( $this, 'mce_buttons' ), 0 );

	}

	/**
	 * Load the TinyMCE plugin
	 *
	 * @param array $plugin_array
	 * @return array
	 */
	function mce_external_plugins( $plugin_array ) {

		$plugin_array[ $this->pluginname ] =  plugins_url( 'editor_plugin.js', __FILE__ );

		return $plugin_array;
	}

	/**
	 * insert button into editor
	 *
	 * @param array $buttons
	 * @return array
	 */
	function mce_buttons( $buttons ) {

		$buttons[] = $this->buttonname;

		return $buttons;
	}

} //end class