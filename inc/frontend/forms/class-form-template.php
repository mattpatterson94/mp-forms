<?php

namespace MpForms\Inc\Frontend\Forms;

interface Form_Template {
  public function view();
  public function dir();
  public function db_name();
  public function mail_subject();
  public function mail_fail_response();
  public function mail_success_response();
  public function parse_fields($fields);
  public function render_mail_html($fields);
}
