<?php

namespace MpForms\Inc\Core;

use MpForms\Inc\Admin\Forms;
use MpForms as NS;

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.

 * @link       http://mattpatterson.xyz
 * @since      1.0.0
 *
 * @author     Matt Patterson
 */

class Activator {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$min_php = '5.6.0';

		// Check PHP Version and deactivate & die if it doesn't meet minimum requirements.
		if ( version_compare( PHP_VERSION, $min_php, '<' ) ) {
					deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'This plugin requires a minmum PHP Version of ' . $min_php );
		}

		Activator::create_database_tables();
	}

	public static function create_database_tables() {
    global $wpdb;

    $plugin_forms = NS\PLUGIN_FORMS;

    foreach($plugin_forms as $form) {
      $new_class = "MpForms\\Inc\\Admin\\Forms\\$form\\Db";
      $new_form = new Forms\Db(new $new_class());
      $new_form->create_database();
    }
	}
}
