<?php
/*
Plugin Name: Client Dash Quickbooks Add-on
Description: Integrates Intuit's Quickbooks Online information with Client Dash
Version: 0.1
Author: Kyle Maurer
Author URI: http://realbigmarketing.com/staff/kyle
*/

class CDQBO {

	public function __construct() {
		add_action('admin_notices', array( $this, 'notices' ) );
	}
// Notices for if CD is not active
	public function notices() {
	if (!is_plugin_active( 'client-dash/client-dash.php' )) {
	echo '<div class="error">Client Dash Quickbooks Online requires <b>Client Dash</b>. Please install and activate <b>Client Dash</b> to continue using.</div>';
	}
}

// Add the Billing tab under the account page

}
$cdqbo = new CDQBO;