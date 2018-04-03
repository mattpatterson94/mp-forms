<?php

namespace MpForms\Inc\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://mattpatterson.xyz
 * @since      1.0.0
 *
 * @author    Matt Patterson
 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;


	/**
	 * The forms of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $forms   The forms available for this plugin
	 */
	private $forms = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name	The name of this plugin.
	 * @param    string $version	The version of this plugin.
	 * @param	 string $plugin_text_domain	The text domain of this plugin
	 * @param	 array $forms	The available forms for this plugin
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain, $forms) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;

		foreach($forms as $form) {
			$new_class = "MpForms\\Inc\\Admin\\Forms\\$form\\$form";
			array_push($this->forms, new $new_class($this->plugin_name, $this->version, $this->plugin_text_domain));
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		foreach($this->forms as $form) {
			$form->enqueue_styles();
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		foreach($this->forms as $form) {
			$form->enqueue_scripts();
		}
	}

	/**
	 * Callback for the admin menu
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		add_menu_page(
			__( 'MP Forms', $this->plugin_text_domain ), //page title
			__( 'MP Forms', $this->plugin_text_domain ), //menu title
			'manage_options', //capability
			$this->plugin_name //menu_slug
		);

		foreach($this->forms as $form) {
			$form->register_page();
		}
	}

	/**
	 *
	 * @since    1.0.0
	 */
	public function the_form_response() {
		if(isset($_POST['nds_add_user_meta_nonce']) && wp_verify_nonce($_POST['nds_add_user_meta_nonce'], 'nds_add_user_meta_form_nonce')) {
			$nds_user_meta_key = sanitize_key( $_POST['nds']['user_meta_key'] );
			$nds_user_meta_value = sanitize_text_field( $_POST['nds']['user_meta_value'] );
			$nds_user =  get_user_by( 'login',  $_POST['nds']['user_select'] );
			$nds_user_id = absint( $nds_user->ID ) ;

			// server processing logic
			if( isset( $_POST['ajaxrequest'] ) && $_POST['ajaxrequest'] === 'true' ) {
				// server response
				echo '<pre>';
				print_r( $_POST );

				echo '</pre>';
				wp_die();
			}

			// server response
			$admin_notice = "success";
			$this->custom_redirect( $admin_notice, $_POST );
			exit;
		}
		else {
			wp_die(
				__('Invalid nonce specified', $this->plugin_name),
				__('Error', $this->plugin_name),
				array(
					'response' 	=> 403,
					'back_link' => 'admin.php?page=' . $this->plugin_name,
				)
			);
		}
	}

	/**
	 * Redirect
	 *
	 * @since    1.0.0
	 */
	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect(
			esc_url_raw(
				add_query_arg(
					array(
						'nds_admin_add_notice' => $admin_notice,
						'nds_response' => $response,
					),
					admin_url('admin.php?page='. $this->plugin_name )
				)
			)
		);
	}


	/**
	 * Print Admin Notices
	 *
	 * @since    1.0.0
	 */
	public function print_plugin_admin_notices() {
		if(isset($_REQUEST['nds_admin_add_notice'])) {
			if( $_REQUEST['nds_admin_add_notice'] === "success") {
				$html =	'
						<div class="notice notice-success is-dismissible">
							<p><strong>The request was successful. </strong></p><br>';

				$html .= '<pre>' . htmlspecialchars( print_r( $_REQUEST['nds_response'], true) ) . '</pre>
						</div>';

				echo $html;
			}
			// handle other types of form notices
		} else {
			return;
		}
	}
}
