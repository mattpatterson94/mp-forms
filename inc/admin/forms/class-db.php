<?php

namespace MpForms\Inc\Admin\Forms;

class Db {
  private $form;

  public function __construct($form) {
    $this->form = $form;
  }

  public function create_database() {
    if($this->check_db_not_exists()) {
      dbDelta(
        $this->form->query($this->table_name())
      );
    }
  }

  protected function table_name() {
    global $wpdb;

    return $wpdb->prefix . 'mp_forms_' . $this->form->db_name();
  }

  protected function check_db_not_exists() {
    global $wpdb;

    return $wpdb->get_var( "show tables like '" . $this->table_name() . "'" ) != $this->table_name();
  }
}
