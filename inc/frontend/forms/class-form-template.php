<?php

namespace MpForms\Inc\Frontend\Forms;

interface Form_Template {
  public function __construct($plugin_name, $version, $plugin_text_domain);
  public function form_view();
}
