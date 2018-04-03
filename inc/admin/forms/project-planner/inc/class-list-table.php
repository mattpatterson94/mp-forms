<?php

namespace MpForms\Inc\Admin\Forms\Project_Planner\Inc;

use \MpForms\Inc\Libraries;
/**
 * Class for displaying registered WordPress Users
 * in a WordPress-like Admin Table with row actions to
 * perform user meta opeations
 */
class List_Table extends Libraries\WP_List_Table {
  public function prepare_items() {
    // check if a search was performed.
    $submission_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';

    //used by WordPress to build and fetch the _column_headers property
    $this->_column_headers = $this->get_column_info();

    // check and process any actions such as bulk actions.
    $this->handle_table_actions();

    $table_data = $this->fetch_table_data();

    // code to handle data operations like sorting and filtering
    // filter the data in case of a search
    if( $submission_search_key ) {
      $table_data = $this->filter_table_data( $table_data, $submission_search_key );
    }
    // start by assigning your data to the items variable
    $this->items = $table_data;

    $submissions_per_page = $this->get_items_per_page( 'submissions_per_page' );
    $table_page = $this->get_pagenum();

    // provide the ordered data to the List Table
    // we need to manually slice the data based on the current pagination
    $this->items = array_slice( $table_data, ( ( $table_page - 1 ) * $submissions_per_page ), $submissions_per_page );
    // set the pagination arguments
    $total_users = count( $table_data );
    $this->set_pagination_args( array (
      'total_items' => $total_users,
      'per_page'    => $submissions_per_page,
      'total_pages' => ceil( $total_users/$submissions_per_page )
    ) );
  }

  public function fetch_table_data() {
    global $wpdb;

    $wpdb_table = $wpdb->prefix . 'mp_forms_project_planner';

    $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'id';
    $order = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';

    $submission_query = "SELECT
                      *
                    FROM
                      $wpdb_table
                    ORDER BY $orderby $order";

    // query output_type will be an associative array with ARRAY_A.
    $query_results = $wpdb->get_results( $submission_query, ARRAY_A  );

    // return result array to prepare_items.
    return $query_results;
  }

  public function get_columns() {
    $table_columns = array(
      'cb'		=> '<input type="checkbox" />', // to display the checkbox.
      'name'		=> __( 'Name', $this->plugin_text_domain ),
      'time'		=> __( 'Time', $this->plugin_text_domain ),
      'preference'		=> __( 'Preference', $this->plugin_text_domain ),
      'services'		=> __( 'Services', $this->plugin_text_domain ),
      'budget'		=> __( 'Budget', $this->plugin_text_domain ),
      'timeframe'		=> __( 'Timeframe', $this->plugin_text_domain ),
      'status'		=> __( 'Status', $this->plugin_text_domain ),
    );
    return $table_columns;
  }

  public function column_default( $item, $column_name ) {
    switch ( $column_name ) {
      case 'status':
        return 'Pending';
      default:
        return $item[$column_name];
    }
  }


  /**
   * Get value for checkbox column.
   *
   * @param object $item  A row's data.
   * @return string Text to be placed inside the column <td>.
   */
  protected function column_cb( $item ) {
    return sprintf(
    '<label class="screen-reader-text" for="submission_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['name'] ) . '</label>'
    . "<input type='checkbox' name='submissions[]' id='submission_{$item['id']}' value='{$item['id']}' />"
    );
  }

  protected function get_sortable_columns() {
    /*
    * actual sorting still needs to be done by prepare_items.
    * specify which columns should have the sort icon.
    */
    $sortable_columns = array (
      'id' => array( 'id', true ),
      'name'=>'name'
    );

    return $sortable_columns;
  }

  public function no_items() {
    _e( 'No submissions avaliable.', $this->plugin_text_domain );
  }

  // filter the table data based on the search key
  public function filter_table_data( $table_data, $search_key ) {
    $filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
      foreach( $row as $row_val ) {
        if( stripos( $row_val, $search_key ) !== false ) {
          return true;
        }
      }
    } ) );
    return $filtered_table_data;
  }

  // Returns an associative array containing the bulk action.
  public function get_bulk_actions() {
    /*
    * on hitting apply in bulk actions the url paramas are set as
    * ?action=bulk-download&paged=1&action2=-1
    *
    * action and action2 are set based on the triggers above and below the table
    */
    $actions = array(
      'bulk-mark-delete' => 'Move to Trash'
    );
    return $actions;
  }

  public function handle_table_actions() {
    /*
    * Note: Table bulk_actions can be identified by checking $_REQUEST['action'] and $_REQUEST['action2']
    * action - is set if checkbox from top-most select-all is set, otherwise returns -1
    * action2 - is set if checkbox the bottom-most select-all checkbox is set, otherwise returns -1
    */
    // check for individual row actions
    $the_table_action = $this->current_action();
    if ( 'view' === $the_table_action ) {
      $nonce = wp_unslash( $_REQUEST['_wpnonce'] );
      // verify the nonce.
      if ( ! wp_verify_nonce( $nonce, 'view_nonce' ) ) {
        $this->invalid_nonce_redirect();
      }
      else {
        $this->page_view( absint( $_REQUEST['submission_id']) );
        $this->graceful_exit();
      }
    }


    if ( ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'bulk-mark-delete' ) || ( isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] === 'bulk-download' ) ) {
      $nonce = wp_unslash( $_REQUEST['_wpnonce'] );
      /*
      * Note: the nonce field is set by the parent class
      * wp_nonce_field( 'bulk-' . $this->_args['plural'] );
      */
      if ( ! wp_verify_nonce( $nonce, 'bulk-submissions' ) ) { // verify the nonce.
        $this->invalid_nonce_redirect();
      }
      else {
        // include_once( 'views/partials-wp-list-table-demo-bulk-download.php' );
        $this->graceful_exit();
      }
    }
  }

  /*
  * Method for rendering the view column.
  * Adds row action links to the voew column.
  * e.g. url/users.php?page=nds-wp-list-table-demo&action=view_usermeta&user=18&_wpnonce=1984253e5e
  */
  protected function column_name( $item ) {
    $admin_page_url =  admin_url();
    // row action to view submission.
    $query_args_view = array(
      'page'		=>  wp_unslash( $_REQUEST['page'] ),
      'action'	=> 'view',
      'submission_id'	=> absint( $item['id']),
      '_wpnonce'	=> wp_create_nonce( 'view_nonce' ),
    );

    $view_link = esc_url( add_query_arg( $query_args_view, $admin_page_url ) );
    $actions['view'] = '<a href="' . $view_link . '">' . __( 'View', $this->plugin_text_domain ) . '</a>';
    // similarly add row actions for add usermeta.
    $row_value = '<strong>' . $item['name'] . '</strong>';
    return $row_value . $this->row_actions( $actions );
  }
}
