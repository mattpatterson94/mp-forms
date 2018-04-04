<?php

namespace MpForms\Inc\Frontend\Forms\Project_Planner;

use \MpForms\Inc\Frontend\Forms as Forms;

class Project_Planner implements Forms\Form_Template {
  /**
	 * Renders the form view, called in parent
	 */
  public function view() {
    include_once( 'assets/views/form.php' );
  }

  /**
	 * The directory name for this form
  */
  public function dir() {
    return 'project-planner';
  }

  /**
	 * The DB prefix for this form
  */
  public function db_name() {
    return 'project_planner';
  }

  /**
	 * The subject for email notifications of this form type
  */
  public function mail_subject() {
    return "A new project planner enquiry";
  }

  /**
	 * The fail response for a mail sendout
  */
  public function mail_fail_response() {
    return array(
      'status' => 'failure',
      'message' => 'There was an error sending your project plan, please check your email address and try again.'
    );
  }

  /**
	 * The success response for a mail sendout
  */
  public function mail_success_response() {
    return array(
      'status' => 'success',
      'message' => '<svg width="100" class="is-animated swing" viewBox="0 0 32 40"><use xlink:href="#happy-face" href="#happy-face"></use></svg><br>Thank you for submitting your form, we will be in touch very shortly!'
    );
  }

  /**
	 * This sets the form fields into the object's state.
	 */
  public function parse_fields($fields) {
    return array(
      'services' => strip_tags($fields['services']),
      'budget' => strip_tags($fields['budget']),
      'timeframe' => strip_tags($fields['timeframe']),
      'files' => strip_tags($fields['files']),
      'details' => strip_tags($fields['details']),
      'name' => strip_tags($fields['contact_name']),
      'phone' => strip_tags($fields['contact_phone']),
      'email' => strip_tags($fields['contact_email']),
      'time' => strip_tags($fields['contact_time']),
      'preference' => strip_tags($fields['contact_preference'])
    );
  }

  /**
	 * Render the email HTML, ready to be sent to wp_mail
	 */
  public function render_mail_html($fields) {
    $html = "";

    $html .= "
      <h1>Project Planner Enquiry</h1>
      <br>
      <h3>Services needed: " . $fields['services'] . "<h3>
      <h3>Budget: " . $fields['budget'] . "<h3>
      <h3>Timeframe: " . $fields['timeframe'] . "<h3>

      <h3>Project Details</h3>
      <p><strong>Details:</strong> " . $fields['details'] . "</p>
      <p><strong>Files:</strong> " . $fields['files'] . "</p>

      <h3>Contact Details:</h3>
      <p><strong>Name:</strong>&nbsp; " . $fields['name'] . "</p>
      <p><strong>Phone:</strong>&nbsp; " . $fields['phone'] . "</p>
      <p><strong>Email:</strong>&nbsp; " . $fields['email'] . "</p>
      <p><strong>Best time to call:</strong>&nbsp; " . $fields['time'] . "</p>
      <p><strong>Preferred method of contact:</strong>&nbsp; " . $fields['preference'] . "</p>
    ";

    return $html;
  }
}
