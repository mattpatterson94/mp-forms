<?php

global $wpdb;
/**
 * The form to be loaded on the plugin's admin page
 */
	if( current_user_can( 'edit_users' ) ) {
?>

<div class="wrap">
	<h2><?php _e( 'Project Planner Submissions', $this->plugin_text_domain); ?></h2>
	<div id="mp-forms-project-planner">
		<div id="nds-post-body">
			<form id="nds-user-list-form" method="get">
				<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
				<?php
					$this->list_table->search_box( __( 'Find', $this->plugin_text_domain ), 'mpforms-submission-find');
					$this->list_table->display();
				?>
			</form>
		</div>
	</div>
</div>

	<?php
	}
	else {
	?>
		<p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p>
	<?php
	}
