<?php

global $wpdb;
/**
 * The form to be loaded on the plugin's admin page
 */
	if( current_user_can( 'edit_users' ) ) {
?>

<?php echo $this->submission['name']; ?><br>
<?php echo $this->submission['time']; ?><br>
<?php echo $this->submission['preference']; ?><br>
<?php echo $this->submission['services']; ?><br>
<?php echo $this->submission['budget']; ?><br>
<?php echo $this->submission['timeframe']; ?><br>
<?php echo $this->submission['files']; ?><br>
<?php echo $this->submission['details']; ?><br>
<?php echo $this->submission['phone']; ?><br>
<?php echo $this->submission['email']; ?><br>

	<?php
	}
	else {
	?>
		<p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p>
	<?php
	}
