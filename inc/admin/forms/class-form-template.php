<?php

namespace MpForms\Inc\Admin\Forms;

interface Form_Template {
  public function __construct($plugin_name, $version, $plugin_text_domain);
  public function setup_page();
  public function single_view();
  public function list_view();
}
