<?php
/*
Plugin Name: CD QBO 
Description: Starting point for making an addon for Client Dash
Version: 0.1.1
Author: Kyle Maurer
Author URI: http://realbigmarketing.com/staff/kyle
*/

//This is the beginning of the integration of the intuit example
?>
<script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
  <script>
    // Runnable uses dynamic URLs so we need to detect our current //
    // URL to set the grantUrl value   ########################### //
    /*######*/ var parser = document.createElement('a');/*#########*/
    /*######*/parser.href = document.url;/*########################*/
    // end runnable specific code snipit ##########################//
    intuit.ipp.anywhere.setup({
        menuProxy: '',
        grantUrl: '' 
        // outside runnable you can point directly to the oauth.php page
    });
    
  </script>

<?php
require_once("config.php");
require_once('/v3-php-sdk-2.0.4/config.php');  // Default V3 PHP SDK (v2.0.1) from IPP
require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
require_once(PATH_SDK_ROOT . 'DataService/DataService.php');
require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');
error_reporting(E_ERROR | E_PARSE);

if(!isset($_SESSION['token'])){
  echo "<h3>You are not currently authenticated</h3>";
} else {
  $token = unserialize($_SESSION['token']);
  $requestValidator = new OAuthRequestValidator(
  $token['oauth_token'], $token['oauth_token_secret'], OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);
  $realmId = $_SESSION['realmId'];

  // uncomment any of these to see more information 
  //echo "realmId: $realmId <br />";
  //echo "oauth token: ". $token['oauth_token'] . "<br />";
  //echo "oauth secret: ". $token['oauth_token'] . "<br />";
  /*echo "<pre><h2>Session Variables</h2>";
    var_dump($_SESSION);
    echo "</pre>"; */
  
  $serviceType = $_SESSION['dataSource'];
  $serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);
  
  $dataService = new DataService($serviceContext);
  
  $startPosition = 1;
  $maxResults = 10;
  $allCustomers = $dataService->FindAll('Customer', $startPosition, $maxResults);
  
  echo "<pre><h2>Customers List</h2>";
  var_dump($allCustomers);
  echo "</pre>";
  
  //This is the end of the integration
}

class MyCDExtension {
	/*
	* These variables you can change
	*/
	// Define the plugin name
	private $plugin = 'QuickBooks Integration';
	// Setup your prefix
	private $pre = 'QBInt';
	// Set this to be name of your content block
	private $block_name = 'QuickBooks';
	// Set the tab slug and name
	private $tab = 'QuickBooks';
	// Set this to the page you want your tab to appear on (account, help and reports exist in Client Dash)
	private $page = 'account';

	/*
	* Now let's setup our options
	* You can change the strings to be more unique
	* If you change the variable names, you'll need to update the
	* references in the register_settings() and settings_display() functions
	*/
	// A checkbox option
	private $cb_option = '_checkbox';
	// A text field option
	private $text_option = '_text';
	// A URL/text field option
	private $url_option = '_url';

	/*
	* This constructor function sets up what happens when the plugin
	* is activated. It is where you'll place all your actions, filters
	* and other setup components.
	*/
	public function __construct() {
		add_action( 'admin_notices', array( $this, 'notices' ) );
		add_action( 'plugins_loaded', array( $this, 'content_block' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'cd_settings_general_tab', array( $this, 'settings_display' ), 11 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );
	}

	public function content_block() {
		cd_content_block( $this->block_name, $this->page, $this->tab, array( $this, 'tab_contents' ) );
	}

	public function register_styles() {
		wp_register_style( $this->pre , plugin_dir_url(__FILE__).'style.css' );
		$page = get_current_screen();
		$tab = $_GET['tab'];

		if ( $page->id != $this->page && $tab != $this->tab )
			return;

		wp_enqueue_style( $this->pre );
	}

	// Notices for if CD is not active (no need to change)
	public function notices() {
		if ( !is_plugin_active( 'client-dash/client-dash.php' ) ) { ?>
		<div class="error">
			<p><?php echo $this->plugin; ?> requires <a href="http://w.org/plugins/client-dash">Client Dash</a>.
			Please install and activate <b>Client Dash</b> to continue using.</p>
		</div>
		<?php
		}
	}

	// Register settings
	public function register_settings() {
		register_setting( 'cd_options_general', $this->pre.$this->cb_option );
		register_setting( 'cd_options_general', $this->pre.$this->text_option, 'esc_html' );
		register_setting( 'cd_options_general', $this->pre.$this->url_option, 'esc_url_raw' );
	}

	// Add settings to General tab
	public function settings_display() {
		?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><h3><?php echo $this->plugin; ?> settings</th>
			</tr>
			<tr><td><b>These do not save at this time!!</b></td></tr>
			<tr valign="top">
				<th scope="row">
					<label for="ConsumerKey">Consumer Key</label>
				</th>
				<td><input type="text" 
					id="ConsumerKey" 
					name="ConsumerKey" 
					value="<?php echo get_option("ConsumerKey"); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="ConsumerSecret">Consumer Secret</label>
				</th>
				<td><input type="text" 
					id="ConsumerSecret" 
					name="ConsumerSecret" 
					value="<?php echo get_option("ConsumerSecret"); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
	<?php }

	// Insert the tab contents
	public function tab_contents() {
		// CHANGE THIS
		echo 'This is where your tab content goes.';
	}
}
// Instantiate the class
$mycdextension = new MyCDExtension;