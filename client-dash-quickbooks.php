<?php
/*
Plugin Name: Client Dash Quickbooks Add-on
Description: Integrates Intuit's Quickbooks Online information with Client Dash
Version: 0.1
Author: Kyle Maurer
Author URI: http://realbigmarketing.com/staff/kyle
*/
// Add the Billing tab under the account page
function cdq_tab() {
$cdq_active_tab = $_GET['tab'];
?>
<a href="?page=account&tab=billing" class="nav-tab <?php echo $cdq_active_tab == 'billing' ? 'nav-tab-active' : ''; ?>">Billing</a>
<?php }
add_action('cd_account_tabs', 'cdq_tab');

// Modify the tab content path to include file from this plugin
function cdq_path($cd_tab_path) {
	$cdq_cur_tab = $_GET['tab'];
	if ($cdq_cur_tab == 'billing') {
	$cd_tab_path = plugin_dir_path( __FILE__ ).'layout/billing-tab.php';
	return $cd_tab_path;
	} else {
		return $cd_tab_path;
	}
}
add_filter('cd_tab_path', 'cdq_path');
?>