<?php

namespace MpForms\Inc\Frontend\Forms;
use \MpForms as NS;

class Form {
  protected $plugin_name;
  protected $version;
  protected $plugin_text_domain;
  protected $fields;

  public function __construct($plugin_name, $version, $plugin_text_domain, $form) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->plugin_text_domain = $plugin_text_domain;
    $this->form = $form;
  }

  /**
	 * Enqueue the form styles
	 */
  public function enqueue_styles() {
    wp_enqueue_style(
      $this->plugin_name . '-' . $this->form->dir(),
      plugin_dir_url( __FILE__ ) . str_replace('_', '-', $this->form->dir()) . '/assets/css/index.css',
      array(),
      $this->version,
      'all'
    );
  }

  /**
	 * Enqueue the form scripts
	 */
  public function enqueue_scripts() {
    wp_enqueue_script(
      $this->plugin_name . '-' . $this->form->dir(),
      plugin_dir_url( __FILE__ ) . str_replace('_', '-', $this->form->dir()) . '/assets/build/index.js',
      array( 'jquery' ),
      $this->version,
      false
    );
  }

  /**
	 * This function is used to display the form view
   * Form view is called in the child, for relative reasons
	 */
  public function display_form() {
    $this->form->view();
  }

  /**
	 * This function processes the user-submitted form
   * Sets the headers, verifies the data, sends notification via email and saves to db
   * Returns a response of the outcome of the email send
	 */
  public function process_form() {
    $this->headers();
    $this->verify();
    $this->set_form_fields();

    $this->save_to_db();
    $response = $this->send_mail();

    echo json_encode($response);
  }

  /**
	 * Sets the form fields from post to the state
  */
  private function set_form_fields() {
    $this->fields = $this->form->parse_fields($_POST);
  }

  /**
	 * Sets the headers of the response
	 */
  private function headers() {
    header('Content-Type: application/json');
  }

  /**
	 * Verify the form is valid and can be sent successfully
   * Verifies email address is valid, and runs a check on captcha
	 */
  protected function verify() {
    if(!$this->is_valid_email($_POST['contact_email'])) {
      echo json_encode(
        array(
          'status' => 'failure',
          'message' => 'Invalid email address, please fix and try again.'
        )
      );
      exit;
    }

    if(!$this->check_human()) {
      echo json_encode(
        array(
          'status' => 'failure',
          'message' => 'Please verify you are not a robot.'
        )
      );
      exit;
    }
  }

  /**
	 * Checks email address is valid using regex
	 */
  public function is_valid_email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
	 * Sends a post request to recaptcha to ensure the user is not a robot
	 */
  public function check_human() {
    $secret = NS\PLUGIN_CAPTCHA_SECRET;
    $captcha = $_POST['g-recaptcha-response'];

    if(!$captcha) return false;

    $opts = array('http' =>
      array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => "secret=" . $secret . "&response=" . $captcha
      )
    );

    $context  = stream_context_create($opts);

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);
    $response = json_decode($response, true);

    if(!$response["success"]) {
      error_log($response['error_codes']);
    }

    return $response["success"];
  }

  /**
	 * Sets up the config and sends the processed form to the admin
   * Returns a response which can be read and parsed
	 */
  private function send_mail() {
    $to = get_option('admin_email');
    $subject = $this->form->mail_subject();
    $email = 'noreply@bonafidedesignco.com';
    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Bona Fide Design Co <'. $email , '>');

    $message = $this->form->render_mail_html($this->fields);
    $sent = wp_mail($to, $subject, $message, $headers);

    return $this->handle_mail_response($sent);
  }

  /**
	 * Used to check mail response and return necessary information in a readable way to send to user
	 */
  private function handle_mail_response($response) {
    if(!$response) {
      return $this->form->mail_fail_response();
    }

    return $this->form->mail_success_response();
  }

  /**
	 * Save the form data to the database, to be read by admins
	 */
	public function save_to_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'mp_forms_' . $this->form->db_name();
		$wpdb->insert($table_name, $this->fields);
	}
}
