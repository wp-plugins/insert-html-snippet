<?php
require( dirname( __FILE__ ) . '../../../../../wp-load.php' );
if(!current_user_can('manage_options')){
	exit;
}
global $wpdb;

if($_POST){
	
	update_option('xyz_credit_link','ihs');
}


?>