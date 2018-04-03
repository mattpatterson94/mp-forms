<?php

namespace MpForms\Inc\Admin\Forms\Project_Planner;

use \MpForms\Inc\Admin\Forms as Forms;

class Db extends Forms\Db {
  public function __construct() {
    $this->form_name = 'project_planner';
  }

  public function query() {
    $sql = "CREATE TABLE `". $this->table_name . "` ( ";
    $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
    $sql .= "  `services`  varchar(255), ";
    $sql .= "  `budget`  varchar(255), ";
    $sql .= "  `timeframe`  varchar(255), ";
    $sql .= "  `files`  varchar(255), ";
    $sql .= "  `details`  text, ";
    $sql .= "  `name`  varchar(255), ";
    $sql .= "  `phone`  varchar(255), ";
    $sql .= "  `email`  varchar(255), ";
    $sql .= "  `time`  varchar(255), ";
    $sql .= "  `preference`  varchar(255), ";
    $sql .= "  `status`  varchar(255), ";
    $sql .= "  PRIMARY KEY `project_planner_id` (`id`) ";
    $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
  }
}
