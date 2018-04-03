<?php

namespace MpForms\Inc\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://mattpatterson.xyz
 * @since      1.0.0
 *
 * @author    Matt Patterson
 */

class Frontend {

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
	 * @since		1.0.0
	 * @param		string $plugin_name       The name of this plugin.
	 * @param		string $version    The version of this plugin.
	 * @param		string $plugin_text_domain	The text domain of this plugin
	 */
	public function __construct($plugin_name, $version, $plugin_text_domain, $forms) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;

		foreach($forms as $form) {
			$new_class = "MpForms\\Inc\\Frontend\\Forms\\$form\\$form";
			$this->forms[$form] = new $new_class($this->plugin_name, $this->version, $this->plugin_text_domain);
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		foreach($this->forms as $form) {
			$form->enqueue_styles();
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		foreach($this->forms as $form) {
			$form->enqueue_scripts();
		}
	}

	public function display_form($atts) {
		$attributes = shortcode_atts(
			array('form' => null), $atts, $this->plugin_text_domain
		);

		if(!isset($attributes['form']) || !in_array($attributes['form'], array_keys($this->forms))) {
			echo "Please choose a valid form. eg [$this->plugin_text_domain form='project_planner']";
			return;
		}

		$this->forms[$attributes['form']]->display_form();
	}

	/**
	 * Register the Shortcodes to display the forms.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode($this->plugin_text_domain, array($this, 'display_form'));
	}

	/**
	 * Register the Actions to handle/process the forms
	 *
	 * @since    1.0.0
	 */
	public function register_actions() {
		foreach($this->forms as $key => $form) {
			add_action("admin_post_nopriv_" . $key. "_process", array($form, 'process_form'));
    	add_action("admin_post_" . $key. "_process", array($form, 'process_form'));
		}
	}
}
