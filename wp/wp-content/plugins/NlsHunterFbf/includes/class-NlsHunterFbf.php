<?php
include_once 'class-NlsUser.php';

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/includes
 * @author     Your Name <email@example.com>
 */

class NlsHunterFbf
{
	const SEARCH_PAGE_SLUG = 'search_page';
	const SEARCH_RESULTS_PAGE_SLUG = 'search_results_page';
	const JOB_DETAILS_PAGE_SLUG = 'job_deatails_page';
	const USER_CREDENTIALS = 'nls_user_credentials';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      NlsHunterFbf_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $NlsHunterFbf    The string used to uniquely identify this plugin.
	 */
	public $NlsHunterFbf;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The job search results.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @var      array    $searchResultJobs    The jobs of the search result.
	 */
	private $searchResultJobs;

	/**
	 * The job details of the current job Id.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @var      array    $jobDetails    The jobs of the search result.
	 */
	private $jobDetails;

	/**
	 * The model instance
	 */
	private $model;

	/**
	 * The modules instance
	 */
	private $modules;

	/**
	 * User Data
	 */

	private $nlsUser;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function __construct($requestUserId = '33120')
	{
		if (defined('NlsHunterFbf_VERSION')) {
			$this->version = NlsHunterFbf_VERSION;
		} else {
			$this->version = '2.0.0';
		}
		$this->NlsHunterFbf = 'NlsHunterFbf';

		$this->load_dependencies();
		$this->loader = new NlsHunterFbf_Loader();

		$this->set_locale();

		// Instantiate the modules class
		try {
			$this->model = new NlsHunterFbf_model();
			$this->nlsUser = new NlsUser($this->model, ['requestUserId' => $requestUserId]); // 33120
			if (!$this->nlsUser->isLoggedIn()) throw new Exception(__('The User is not logged in, please log in', 'NlsHunterFbf'));
			$this->modules = new NlsHunterFbf_modules($this->model, $this->nlsUser);
		} catch (\Exception $e) {
			$this->addErrorToPage($e->getMessage(), "Error: Could not create Niloos Module.");
			return null;
			//throw new \Exception("Error: Could not create Niloos Module.\n" . $e->getMessage());
		}

		//$this->setUserCredentials();


		$this->define_admin_hooks();
		$this->define_shortcodes();
		//$this->add_fbf_widget();
		$this->define_public_hooks();

		/**
		 *  Load the search results or the job details
		 *  If Search Results page loads the jobs to $searchResultJobs
		 *  If JobDetails Loads the Job Data to $jobDetails
		 * */
	}

	public function userLoggedIn()
	{
		if (!$this->nlsUser) return false;
		return $this->nlsUser->isLoggedIn();
	}

	public function getNlsUser()
	{
		return $this->nlsUser;
	}

	public function getModel()
	{
		return $this->model;
	}

	public function addFlash($message, $subject = '', $type = 'info')
	{
		$flash = '<div class="nls-flash-message-wrapper flex">';
		$flash .= '<div class="nls-flash-message ' . $type . '">';
		$flash .= '<div><strong>' . $subject . '</strong> ' . $message . '</div><strong>x</strong>';
		$flash .= '</div></div>';
		return $flash;
	}


	private function setUserCredentials($userId = null)
	{
		$userId = $userId ? $userId : $this->model->queryParam('user-id', false, true);
		//if (!$userId) return false;

		$wp_session = WP_Session::get_instance();
		$this->userData = $wp_session[self::USER_CREDENTIALS] ? $wp_session[self::USER_CREDENTIALS] : false;

		if (!$this->userData) {
			$applicant = $this->model->applicantGetByFilter2(['entityLocalName' => 'Oz']);
		}

		return $this->userData;
	}

	public function addErrorToPage($message, $subject)
	{
		add_action('the_post', function () use ($message, $subject) {
			echo $this->addFlash(
				$message,
				$subject,
				'error'
			);
		});
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - NlsHunterFbf_Loader. Orchestrates the hooks of the plugin.
	 * - NlsHunterFbf_i18n. Defines internationalization functionality.
	 * - NlsHunterFbf_Admin. Defines all hooks for the admin area.
	 * - NlsHunterFbf_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-NlsHunterFbf-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-NlsHunterFbf-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-NlsHunterFbf-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-NlsHunterFbf-public.php';

		require_once 'class-NlsHunterFbf-model.php';
		require_once 'class-NlsHunterFbf-modules.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the NlsHunterFbf_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new NlsHunterFbf_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new NlsHunterFbf_Admin($this->get_NlsHunterFbf(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('admin_menu', $plugin_admin, 'NlsHunterFbf_plugin_menu');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		// Set to true to get log messages in file /logs/default.log
		$debug = false;

		$plugin_public = new NlsHunterFbf_Public($this->get_NlsHunterFbf(), $this->get_version(), $debug);

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		//$this->loader->add_action('wp_body_open', $plugin_public, 'add_code_on_body_open');

		// THE AJAX APPLY CV ADD ACTIONS
		$this->loader->add_action('wp_ajax_apply_for_job', $plugin_public, 'apply_for_job_function');
		$this->loader->add_action('wp_ajax_nopriv_apply_for_job', $plugin_public, 'apply_for_job_function'); // need this to serve non logged in users

		// THE AJAX RESULTS PAGE
		$this->loader->add_action('wp_ajax_results_page', $plugin_public, 'results_page_function');
		$this->loader->add_action('wp_ajax_nopriv_results_page', $plugin_public, 'results_page_function'); // need this to serve non logged in users

		/**
		 * User data functions
		 */
		// THE AJAX CV FILES
		$this->loader->add_action('wp_ajax_get_user_cv_files', $plugin_public, 'get_user_cv_files');
		$this->loader->add_action('wp_ajax_nopriv_get_user_cv_files', $plugin_public, 'get_user_cv_files');
		// THE AJAX FILE LIST
		$this->loader->add_action('wp_ajax_get_user_file_list', $plugin_public, 'get_user_file_list');
		$this->loader->add_action('wp_ajax_nopriv_get_user_file_list', $plugin_public, 'get_user_file_list');
		// THE AJAX APPLIED JOBS
		$this->loader->add_action('wp_ajax_get_user_applied_jobs', $plugin_public, 'get_user_applied_jobs');
		$this->loader->add_action('wp_ajax_nopriv_get_user_applied_jobs', $plugin_public, 'get_user_applied_jobs');
		// THE AJAX AGENT PAGE
		$this->loader->add_action('wp_ajax_get_user_agent_jobs', $plugin_public, 'get_user_agent_jobs');
		$this->loader->add_action('wp_ajax_nopriv_get_user_agent_jobs', $plugin_public, 'get_user_agent_jobs');
		// THE AJAX AREA JOBS
		$this->loader->add_action('wp_ajax_get_user_area_jobs', $plugin_public, 'get_user_area_jobs');
		$this->loader->add_action('wp_ajax_nopriv_get_user_area_jobs', $plugin_public, 'get_user_area_jobs');

		// THE AJAX DOWNLOAD FILE
		$this->loader->add_action('wp_ajax_download_file', $plugin_public, 'download_file');
		$this->loader->add_action('wp_ajax_nopriv_download_file', $plugin_public, 'download_file');
		// THE AJAX DELETE FILE
		$this->loader->add_action('wp_ajax_delete_file', $plugin_public, 'delete_file');
		$this->loader->add_action('wp_ajax_nopriv_delete_file', $plugin_public, 'delete_file');
		// THE AJAX NEW FILE
		$this->loader->add_action('wp_ajax_new_file', $plugin_public, 'new_file');
		$this->loader->add_action('wp_ajax_nopriv_new_file', $plugin_public, 'new_file');
	}

	/**
	 * Register all of the shortcodes related to the plugin
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_shortcodes()
	{

		// Add Shortcode
		add_shortcode('nls_hunter_categories', [$this->modules, 'nlsHunterCategories_render']);
		add_shortcode('nls_hot_jobs', [$this->modules, 'nlsHotJobs_render']);
		add_shortcode('nls_hunter_search', [$this->modules, 'nlsHunterSearch_render']);
		add_shortcode('nls_hunter_search_results', [$this->modules, 'nlsHunterSearchResults_render']);
		add_shortcode('nls_hunter_personal_dashboard', [$this->modules, 'nlsHunterPersonalDashboard_render']);
		add_shortcode('nls_hunter_personal_module', [$this->modules, 'nlsHunterPersonalModule_render']);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_NlsHunterFbf()
	{
		return $this;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    NlsHunterFbf_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	/**
	 * Retrieve the search results for search results page
	 *
	 * @since     2.0.0
	 * @return    array    The search results.
	 */
	public function get_searchResults()
	{
		return $this->searchResultsUrl;
	}

	/**
	 * Retrieve the Job details for the current job ID.
	 *
	 * @since     2.0.0
	 * @return    array    The Job details for the current job ID.
	 */
	public function get_jobDetails()
	{
		return $this->jobDetails;
	}
}
