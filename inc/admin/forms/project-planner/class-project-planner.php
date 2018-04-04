<?php

namespace MpForms\Inc\Admin\Forms\Project_Planner;

use \MpForms\Inc\Libraries;
use \MpForms\Inc\Admin\Forms as Forms;

class Project_Planner implements Forms\Form_Template {
  private $list_table;
  private $plugin_text_domain;
  private $submission;

  /**
	 * The directory name for this form
  */
  public function dir() {
    return 'project-planner';
  }

  /**
	 * The db name for this form
  */
  public function db_name() {
    return 'project_planner';
  }

  /**
	 * The name of the form
  */
  public function name() {
    return 'Project Planner';
  }

  /**
	 * Relative instance of the List table
  */
  public function init_list_table($plugin_text_domain) {
    $this->plugin_text_domain = $plugin_text_domain;
		$this->list_table = new Inc\List_Table( $this->plugin_text_domain );
  }

  /**
	 * Render list view of the form submissions
  */
  public function list_view() {
    $this->list_table->prepare_items();
    include_once( 'assets/views/list.php' );
  }

  /**
	 * Render single view of the form submissions
  */
  public function single_view($submission) {
    $this->submission = $submission;
    include_once( 'assets/views/single.php' );
  }
}
