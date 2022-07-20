<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';
include_once NLS__PLUGIN_PATH . 'includes/class-NlsFileInfo.php';
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
     * @access   public
     * @var      the class    $NlsHunterFbf .
     */
    public $NlsHunterFbf;

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
     * User Data
     */
    private $userData;

    private $model;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      Object    $NlsHunterFbf       The plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($NlsHunterFbf, $version, $debug = false)
    {
        $this->NlsHunterFbf = $NlsHunterFbf;
        $this->model =  $this->NlsHunterFbf->getModel();
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

        //wp_enqueue_style('jquery-ui-theme-smoothness', sprintf('https://ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', wp_scripts()->registered['jquery-ui-core']->ver));
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

        wp_enqueue_script('nls-scroll-to-event', plugin_dir_url(__FILE__) . 'js/scrollToEvent.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-sumo-select', plugin_dir_url(__FILE__) . 'js/jquery.sumoselect.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('mobile-check-js', plugin_dir_url(__FILE__) . 'js/mobileCheck.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-swipe-detect', plugin_dir_url(__FILE__) . 'js/swipeDetect.js', array('jquery'), $this->version, false);
        //wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('slick-js', plugin_dir_url(__FILE__) . 'js/slick.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-jquery-js', plugin_dir_url(__FILE__) . 'js/nlsJquery.js', array('jquery'), $this->version, false);

        // enqueue and localise scripts for handling Ajax Submit CV
        // Don't forget to add the action (apply_cv_function)
        // defined in the  class-NlsHunterFbf-public.php (define_public_hooks)
        wp_localize_script('nls-jquery-js', 'frontend_ajax', ['url' => admin_url('admin-ajax.php')]);

        wp_enqueue_script('nls-form-validation', plugin_dir_url(__FILE__) . 'js/NlsHunterFormValidation.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-search-js', plugin_dir_url(__FILE__) . 'js/jobSearch.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-apply-js', plugin_dir_url(__FILE__) . 'js/jobApply.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-app', plugin_dir_url(__FILE__) . 'js/app.js', array('jquery'), $this->version, false);
        wp_enqueue_script('personal-area-js', plugin_dir_url(__FILE__) . 'js/personalArea.js', array('jquery'), $this->version, false);
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
        // 1. Get Job Code
        $jobCode = $this->model->queryParam('job-code', false, true);

        // 2. Get the CV File ID
        $cvFileId = $this->model->queryParam('cv-file', false, true);

        // 3. Get the additional File ID
        $additionalFileId = $this->model->queryParam('additional-file', false, true);

        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => $this->sentSuccess(),
            'params' => [
                'jobCode' => $jobCode,
                'cvFileId' => $cvFileId,
                'additionalFileId' => $additionalFileId
            ]
        ];
        wp_send_json($response);
    }

    private function verifyUserIsSet()
    {
        //unset($_COOKIE['REICHMAN_USER']);
        if (!$this->NlsHunterFbf->userLoggedIn()) {
            $response = [
                'status' => self::STATUS_ERROR,
                'html' => '<p>' . __('The User is not logged in, please log in', 'NlsHunterFbf') . '</p>',
                'params' => []
            ];
            wp_send_json($response);
            die(403);
        }
        return;
    }

    /**
     * User data fetch functions
     */
    public function get_user_cv_files()
    {
        $response = $this->get_user_file_list();
        wp_send_json($response);
    }

    public function get_user_file_list($isCvFiles = true)
    {
        $this->verifyUserIsSet();
        $user = $this->NlsHunterFbf->getNlsUser();
        $files = $this->model->getFilesInfo($isCvFiles ? $user->cvList->list : $user->fileList->list, $user->cardId);
        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => render('personal/fileList', [
                'files' => $files,
                'type' => $isCvFiles ? 'cv-list' : 'file-list'
            ]),
            'params' => [
                'count' => $isCvFiles ? $user->cvList->count : $user->fileList->count,
                'label' => __($isCvFiles ? $user->cvList->label : $user->fileList->label, 'NlsHunterFbf'),
            ]
        ];
        wp_send_json($response);
    }

    public function get_user_applied_jobs()
    {
        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => '<p>APPLIED JOBS</p>',
            'params' => []
        ];
        wp_send_json($response);
    }

    public function get_user_agent_jobs()
    {
        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => '<p>AGENT JOBS</p>',
            'params' => []
        ];
        wp_send_json($response);
    }

    public function get_user_area_jobs()
    {
        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => '<p>AREA JOBS</p>',
            'params' => []
        ];
        wp_send_json($response);
    }

    public function download_file()
    {
        $fileId = $this->model->queryParam('fileId', false, true);
        $user = $this->NlsHunterFbf->getNlsUser();
        if (!$fileId || !$user->cardId) {
            $response = [
                'status' => self::STATUS_ERROR,
                'title' => __('Something went wrong', 'NlsHunterFbf'),
                'message' => __('The requested file could not be found for the user.', 'NlsHunterFbf'),
                'params' => [
                    'fileId' => $fileId
                ]
            ];
            wp_send_json($response);
            wp_die();
        }

        $file = $this->model->fileGetWithContent($fileId, $user->cardId);
        $fileName = trim($file->Name) . '.' . trim($file->Type);
        $fileUrl = $this->saveLocalFile($fileName, $file->FileContent);

        if (!$fileUrl) {
            $response = [
                'status' => self::STATUS_ERROR,
                'title' => __('Something went wrong', 'NlsHunterFbf'),
                'message' => __('Could not prepare the file for download', 'NlsHunterFbf'),
                'params' => [
                    'fileId' => $fileId
                ]
            ];
            wp_send_json($response);
            wp_die();
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'fileUrl' => $fileUrl,
            'params' => [
                'fileName' => $fileName,
            ]
        ];
        wp_send_json($response);
        wp_die();
    }

    private function getFilePath($fileName)
    {
        $file = 'public/tmp/' . session_id() . '/' . $fileName;
        return NLS__PLUGIN_PATH . $file;
    }

    private function getFileUrl($fileName)
    {
        $file = 'public/tmp/' . session_id() . '/' . $fileName;
        return NLS__PLUGIN_URL . $file;
    }

    private function saveLocalFile($fileName, $fileData)
    {
        $path = $this->getFilePath($fileName);

        $dirname = dirname($path);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        // open the output file for writing
        $ifp = fopen($path, 'wb');

        fwrite($ifp, $fileData);

        // clean up the file resource
        fclose($ifp);

        return file_exists($path) ? $this->getFileUrl($fileName) : false;
    }

    public function delete_file($fileId)
    {
        $fileId = $this->model->queryParam('fileId', false, true);
        $user = $this->NlsHunterFbf->getNlsUser();
        if (!$fileId || !$user->cardId) {
            $response = [
                'status' => self::STATUS_ERROR,
                'html' => '<p>Something went wrong: file delete error.</p>',
                'params' => [
                    'fileId' => $fileId
                ]
            ];
            wp_send_json($response);
        }

        $file = $this->model->fileDelete($user->cardId, $fileId);

        $response = [
            'status' => self::STATUS_SUCCESS,
            'fileUrl' => $file,
            'params' => [
                'fileName' => $file,
            ]
        ];
        wp_send_json($response);
    }

    public function new_file()
    {
        $file = key_exists('file', $_FILES) ? $_FILES['file'] : false;
        $type = $this->model->queryParam('type', false, true);
        $user = $this->NlsHunterFbf->getNlsUser();
        if ($file && $user->cardId) {
            $res = $this->model->insertNewFile($user, $file, $type === 'cv-list');
        }
        if (!$res) {
            $response = [
                'status' => self::STATUS_ERROR,
                'html' => '<p>Something went wrong: file upload error.</p>',
                'params' => [
                    'file' => $file
                ]
            ];
            wp_send_json($response);
        }


        $fileObj = new NlsFileInfo();
        $fileObj->id = $res;
        $fileObj->name = $file['name'];
        $fileObj->updateDate = time();
        $fileObj->mimeType = $file['type'];

        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => render('personal/fileItem', ['fileObj' => $fileObj]),
            'params' => [
                'fileId' => $res,
            ]
        ];
        wp_send_json($response);
    }

    public function add_edit_hunter()
    {
        $formData = $_POST;

        $response = [
            'status' => self::STATUS_SUCCESS,
            'html' => 'SUCCESS',
            'params' => [
                'fileId' => '1',
            ]
        ];
        wp_send_json($response);
    }

    /**
     * Mail
     */
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
        $searchParams = $this->model->searchParams(true);
        $page = intval($this->model->queryParam('page', 0, true));
        $jobs = $this->model->getJobHunterExecuteNewQuery2($searchParams, null, $page + 1);
        $jobDetailsPageUrl = $this->model->getJobDetailsPageUrl();

        ob_start();

        foreach ($jobs['list'] as $job) {
            echo render('job/nlsJobCard', [
                'model' => $this->model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . '?jobcode=' .  NlsHelper::proprtyValue($job, 'JobCode')
            ]);
        }
        wp_send_json([
            'results' => htmlentities(ob_get_clean()),
            'count' => count($jobs['list']),
            'page' => $page + 1
        ]);
    }
}
