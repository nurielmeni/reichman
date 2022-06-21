<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/public
 * @author     Meni Nuriel <nurielmeni@gmail.com>
 */
class NlsHunterFbf_Public
{
    /**
     * Fields names
     */
    const SID = 'sid';

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $NlsHunterFbf    The ID of this plugin.
     */
    private $NlsHunterFbf;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /** 
     * Show log messages
     */
    private $debug;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $NlsHunterFbf       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($NlsHunterFbf, $version, $debug = false)
    {
        $this->NlsHunterFbf = $NlsHunterFbf;
        $this->version = $version;
        $this->debug = $debug;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('NlsHunterFbf', plugin_dir_url(__FILE__) . 'css/NlsHunterFbf-public.css', array(), $this->version, 'all');
        wp_enqueue_style('NlsHunterFbf-responsive', plugin_dir_url(__FILE__) . 'css/NlsHunterFbf-public-responsive.css', array(), $this->version, 'all');
        wp_enqueue_style('sumoselect', plugin_dir_url(__FILE__) . 'css/sumoselect.min.css', array(), $this->version, 'all');
        wp_enqueue_style('front-page-loader', plugin_dir_url(__FILE__) . 'css/loader.css', array(), $this->version, 'all');
        wp_enqueue_style('slick', plugin_dir_url(__FILE__) . 'css/slick.css', array(), $this->version, 'all');

        if (is_rtl()) {
            wp_enqueue_style('sumoselect-rtl', plugin_dir_url(__FILE__) . 'css/sumoselect-rtl.css', array(), $this->version, 'all');
        }

        wp_enqueue_style('jquery-ui-theme-smoothness', sprintf('https://ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', wp_scripts()->registered['jquery-ui-core']->ver));
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('mobile-check-js', plugin_dir_url(__FILE__) . 'js/mobileCheck.js', array('jquery'), $this->version, false);
        wp_enqueue_script('slick-js', plugin_dir_url(__FILE__) . 'js/slick.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-search-js', plugin_dir_url(__FILE__) . 'js/jobSearch.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-apply-js', plugin_dir_url(__FILE__) . 'js/jobApply.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-form-validation', plugin_dir_url(__FILE__) . 'js/NlsHunterForm.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-swipe-detect', plugin_dir_url(__FILE__) . 'js/swipeDetect.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-sumo-select', plugin_dir_url(__FILE__) . 'js/jquery.sumoselect.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-app', plugin_dir_url(__FILE__) . 'js/app.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-ui-datepicker');
        //wp_enqueue_script('jquery-datepicker-he', plugin_dir_url(__FILE__) . 'js/datepicker-he.js', array('jquery'), $this->version, false);

        // enqueue and localise scripts for handling Ajax Submit CV
        // Don't forget to add the action (apply_cv_function)
        // defined in the  class-NlsHunterFbf-public.php (define_public_hooks)
        wp_localize_script('nls-form-validation', 'frontend_ajax', ['url' => admin_url('admin-ajax.php')]);
    }

    /**
     * Helper function to write log messages
     */
    public function writeLog($message, $level = 'debug')
    {
        if (!$this->debug) return;

        $logFile = NLS__PLUGIN_PATH . 'logs/default.log';

        $data = date("Ymd") . ' ' . $level . ' ' . $message;
        file_put_contents($logFile, $data, FILE_APPEND);
    }

    /*
     * Return the pager data to the search result module
     */
    public function apply_for_job_function()
    {
        $response = ['status' => self::STATUS_SUCCESS, 'html' => $this->sentSuccess()];
        wp_send_json($response);
    }

    public function sendHtmlMail($jobcode, $files, $fields, $i, $msg = '')
    {
        // Change the $fields value for strongSide to include the name and not the id
        $to = get_option(NlsHunterFbf_Admin::TO_MAIL);
        $bcc = get_option(NlsHunterFbf_Admin::BCC_MAIL);
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        if (strlen($bcc) > 0) array_push($headers, 'Bcc: ' . $bcc);

        $subject = __('CV Applied from Reichman Jobs Site', 'NlsHunterFbf') . ': ';
        $subject .= $jobcode ? $jobcode : $msg;

        $attachments = $files ?: [];

        $body = render('mail/mailApply', [
            'fields' => $fields,
            'i' => $i
        ]);

        global $phpmailer;
        add_action('phpmailer_init', function (&$phpmailer) {
            $phpmailer->SMTPKeepAlive = true;
        });

        //add_filter('wp_mail_from', get_option(NlsHunterFbf_Admin::FROM_MAIL));
        //add_filter('wp_mail_from_name', get_option(NlsHunterFbf_Admin::FROM_NAME));

        $result =  wp_mail($to, $subject, $body, $headers, $attachments);
        //$this->writeLog("\nMail Result: $result");

        return $result;
    }

    private function sentSuccess($msg = '')
    {
        return render('mail/mailSuccess', ['msg' => $msg]);
    }

    private function sentError($msg = '')
    {
        return render('mail/mailError', ['msg' => $msg]);
    }

    public function results_page_function()
    {
        return "MORE RESULTS";
    }
}
