<?php

namespace MpForms\Inc\Admin\Forms;

use MpForms\Inc\Libraries;

class Form {
  protected $plugin_name;
  protected $version;
  protected $plugin_text_domain;
  protected $form;
  protected $form_name;
  protected $list_table;

  public function __construct($plugin_name, $version, $plugin_text_domain) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->plugin_text_domain = $plugin_text_domain;
  }

  public function enqueue_styles() {
    wp_enqueue_style(
      $this->plugin_name . '-' . $this->form,
      plugin_dir_url( __FILE__ ) . 'assets/css/index.css',
      array(),
      $this->version,
      'all'
    );
  }

  public function enqueue_scripts() {
    $params = array (
      'ajaxurl' => admin_url('admin-ajax.php')
    );

    wp_enqueue_script(
      $this->plugin_name . '-' . $this->form,
      plugin_dir_url( __FILE__ ) . 'assets/js/index.js',
      array( 'jquery' ),
      $this->version,
      false
    );

    wp_localize_script(
      $this->plugin_name . '-' . $this->form,
      'params',
      $params
    );
  }

  public function register_page() {
    $page_hook = add_submenu_page(
      $this->plugin_name, //parent slug
      __( $this->plugin_name, $this->plugin_text_domain ), //page title
      __( $this->form_name, $this->plugin_text_domain ), //menu title
      'manage_options', //capability
      $this->plugin_name, //menu_slug
      array($this, 'page_content' ) //callback for page content
    );

    add_action( 'load-'.$page_hook, array( $this, 'setup_page' ) );
  }

  public function setup_page() {
		$arguments = array(
			'label'		=>	__( 'Submissions Per Page', $this->plugin_text_domain ),
			'default'	=>	30,
			'option'	=>	'submissions_per_page'
    );

		add_screen_option( 'per_page', $arguments );
  }

  public function page_content() {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view') {
      $this->display_single();
      return;
    }

    $this->display_list();
  }

  protected function display_single() {
    $this->submission = $this->get_single();
    $this->single_view();
  }

  protected function get_single() {
    global $wpdb;

		$submission_id = $_REQUEST['submission_id'];
    $wpdb_table = $wpdb->prefix . 'mp_forms_' . $this->form;
    $submission_query = "SELECT * FROM $wpdb_table WHERE id=".$submission_id;
    $query_results = $wpdb->get_results( $submission_query, ARRAY_A  );

    // return result array to prepare_items.
    return $query_results[0];
  }

  protected function display_list() {
    $this->list_table->prepare_items();
    $this->list_view();
  }
}
