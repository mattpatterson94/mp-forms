<?php

namespace MpForms\Inc\Admin\Forms;

interface Form_Template {
  public function dir();
  public function db_name();
  public function name();
  public function init_list_table($plugin_text_domain);
  public function list_view();
  public function single_view($submission);
}
