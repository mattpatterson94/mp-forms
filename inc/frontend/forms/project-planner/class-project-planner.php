<?php

namespace MpForms\Inc\Frontend\Forms\Project_Planner;

use \MpForms\Inc\Frontend\Forms as Forms;

class Project_Planner extends Forms\Form implements Forms\Form_Template {
  /**
	 * Initializes the form and sets the name and namespace of the form
	 */
  public function __construct( $plugin_name, $version, $plugin_text_domain) {
    parent::__construct($plugin_name, $version, $plugin_text_domain);

    $this->form = 'project_planner';
    $this->form_name = 'Project Planner';
  }

  /**
	 * Renders the form view, called in parent
	 */
  public function form_view() {
    include_once( 'assets/views/form.php' );
  }

  /**
	 * This sets the form fields into the object's state.
	 */
  protected function set_form_fields() {
    $this->fields = array(
      'services' => strip_tags($_POST['services']),
      'budget' => strip_tags($_POST['budget']),
      'timeframe' => strip_tags($_POST['timeframe']),
      'files' => strip_tags($_POST['files']),
      'details' => strip_tags($_POST['details']),
      'name' => strip_tags($_POST['contact_name']),
      'phone' => strip_tags($_POST['contact_phone']),
      'email' => strip_tags($_POST['contact_email']),
      'time' => strip_tags($_POST['contact_time']),
      'preference' => strip_tags($_POST['contact_preference'])
    );
  }

  /**
	 * Render the email HTML, ready to be sent to wp_mail
	 */
  protected function render_mail_html() {
    $html = "";

    $html .= "
      <h1>Project Planner Enquiry</h1>
      <br>
      <h3>Services needed: " . $this->fields['services'] . "<h3>
      <h3>Budget: " . $this->fields['budget'] . "<h3>
      <h3>Timeframe: " . $this->fields['timeframe'] . "<h3>

      <h3>Project Details</h3>
      <p><strong>Details:</strong> " . $this->fields['details'] . "</p>
      <p><strong>Files:</strong> " . $this->fields['files'] . "</p>

      <h3>Contact Details:</h3>
      <p><strong>Name:</strong>&nbsp; " . $this->fields['name'] . "</p>
      <p><strong>Phone:</strong>&nbsp; " . $this->fields['phone'] . "</p>
      <p><strong>Email:</strong>&nbsp; " . $this->fields['email'] . "</p>
      <p><strong>Best time to call:</strong>&nbsp; " . $this->fields['time'] . "</p>
      <p><strong>Preferred method of contact:</strong>&nbsp; " . $this->fields['preference'] . "</p>
    ";

    return $html;
  }
}
