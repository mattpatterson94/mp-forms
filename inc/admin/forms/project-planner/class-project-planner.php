<?php

namespace MpForms\Inc\Admin\Forms\Project_Planner;

use \MpForms\Inc\Libraries;
use \MpForms\Inc\Admin\Forms as Forms;

class Project_Planner extends Forms\Form implements Forms\Form_Template {
  public function __construct( $plugin_name, $version, $plugin_text_domain) {
    parent::__construct($plugin_name, $version, $plugin_text_domain);

    $this->form = 'project_planner';
    $this->form_name = 'Project Planner';
  }

  public function setup_page() {
    parent::setup_page();

		$this->list_table = new Inc\List_Table( $this->plugin_text_domain );
  }

  public function list_view() {
    include_once( 'assets/views/list.php' );
  }

  public function single_view() {
    include_once( 'assets/views/single.php' );
  }
}
