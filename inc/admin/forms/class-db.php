<?php

namespace MpForms\Inc\Admin\Forms;

class Db {
  protected $form_name;

  public function create_database() {
    if($this->check_db_not_exists()) {
      dbDelta($this->query());
    }
  }

  protected function table_name() {
    global $wpdb;

    return $wpdb->prefix . 'mp_forms_' . $this->form_name;
  }

  protected function check_db_not_exists() {
    global $wpdb;

    return $wpdb->get_var( "show tables like '" . $this->table_name() . "'" ) != $this->table_name();
  }
}
