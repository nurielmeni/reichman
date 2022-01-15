<?php
require_once 'Hunter/NlsCards.php';
require_once 'Hunter/NlsSecurity.php';
require_once 'Hunter/NlsDirectory.php';
require_once 'Hunter/NlsSearch.php';
require_once 'Hunter/NlsHelper.php';
/**
 * Description of class-NlsHunterFbf-modules
 *
 * @author nurielmeni
 */
class NlsHunterFbf_model
{


    private $nlsSecutity;
    private $auth;
    private $nlsCards;
    private $nlsDirectory;

    private $regions;

    public function __construct()
    {
        try {
            $this->nlsSecutity = new NlsSecurity();
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not create Model.', 'NlsHunterFbf'),
                __('Error: NlsHunterFbf_model: ', 'NlsHunterFbf')
            );
            return null;
        }
        $this->auth = $this->nlsSecutity->isAuth();

        if (!$this->auth) {
            $username = get_option(NlsHunterFbf_Admin::NLS_SECURITY_USERNAME);
            $password = get_option(NlsHunterFbf_Admin::NLS_SECURITY_PASSWORD);
            $this->auth = $this->nlsSecutity->authenticate($username, $password);

            // Check if Auth is OK and convert to object
            if ($this->nlsSecutity->isAuth() === false) {
                $this->nlsAdminNotice('Authentication Error', 'Can not connect to Niloos Service.');
                $this->nlsPublicNotice('Authentication Error', 'Can not connect to Niloos Service.');
            }
        }

        // Load all the select options for the module
        if (!wp_doing_ajax()) {
            //$this->loadSelectOptions();
        }
    }


    public function front_add_message()
    {
        add_filter('the_content', 'front_display_message');
    }

    public function front_display_message($content)
    {

        $content = "<div class='your-message'>You did it!</div>\n\n" . $content;
        return $content;
    }

    public function nlsPublicNotice($title, $notice)
    {
        $cont = '<div class="notice notice-error"><label>' . $title . '</label><p>' . $notice . '</p></div>';

        add_action('the_post', function ($post) use ($cont) {
            echo $cont;
        });
    }

    public function nlsAdminNotice($title, $notice)
    {
        add_action('admin_notices', function () use ($title, $notice) {
            $class = 'notice notice-error';
            printf('<div class="%1$s"><label>%2$s</label><p>%3$s</p></div>', esc_attr($class), esc_html($title), esc_html($notice));
        });
    }

    /**
     * Gets a card by email or phone
     */
    public function getCardByEmailOrCell($email, $cell)
    {
        $card = [];
        if (!empty($email)) {
            $card = $this->nlsCards->ApplicantHunterExecuteNewQuery2('', '', '', '', $email);
        }
        if (count($card) === 0 && !empty($cell)) {
            $card = $this->nlsCards->ApplicantHunterExecuteNewQuery2('', $cell, '', '', '');
        }
        return $card;
    }

    /**
     * Add file to card
     */
    public function insertNewFile($cardId, $file)
    {
        $fileContent = file_get_contents($file['path']);
        return $this->nlsCards->insertNewFile($cardId, $fileContent, $file['name'], $file['ext']);
    }

    /**
     * Init cards service
     */
    public function initCardService()
    {
        try {
            if ($this->auth !== false && !$this->nlsCards) {
                $this->nlsCards = new NlsCards([
                    'auth' => $this->auth,
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Card Services.', 'NlsHunterFbf'),
                __('Error: Card Services: ', 'NlsHunterFbf')
            );
            return null;
        }
    }

    /**
     * Init directory service
     */
    public function initDirectoryService()
    {
        try {
            if ($this->auth !== false && !$this->nlsDirectory) {
                $this->nlsDirectory = new NlsDirectory([
                    'auth' => $this->auth
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Directory Services.', 'NlsHunterFbf'),
                __('Error: Directory Services: ', 'NlsHunterFbf')
            );
            return null;
        }
    }

    /**
     * Init search service
     */
    public function initSearchService()
    {
        try {
            if ($this->auth !== false && !$this->nlsSearch) {
                $this->nlsSearch = new NlsSearch([
                    'auth' => $this->auth,
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Search Services.', 'NlsHunterFbf'),
                __('Error: Search Services: ', 'NlsHunterFbf')
            );
            return null;
        }
    }

    /**
     * Handler for the Search Slug
     */
    public function loadSelectOptions()
    {
        $this->initDirectoryService();

        // if no directory empty form
        if ($this->auth !== false &&  $this->nlsDirectory) {
            $this->regions = $this->nlsDirectory->getListByName('Regions');
        } else {
            $this->nlsAdminNotice(
                __('Could not connect to Hunter Directory Services', 'NlsHunterFbf'),
                __('Authentication Error', 'NlsHunterFbf')
            );
            $this->regions = [];
        }
    }

    public function getJobsBySupplierId($supplierId = null)
    {
        $this->initCardService();

        $supplierId = $supplierId ? $supplierId : get_option(NlsHunterFbf_Admin::NSOFT_SUPPLIER_ID);
        // Look to see if the search page was submited and get options
        $jobs = $this->nlsCards->jobsGetByFilter([
            'supplierId' => $supplierId,
            'lastId' => 0,
            'countPerPage' => get_option(NlsHunterFbf_Admin::NLS_JOBS_COUNT),
        ]);

        return $jobs;
    }

    public function searchJobByJobCode($jobCode)
    {
        return $this->nlsCards->searchJobByJobCode($jobCode);
    }
}
