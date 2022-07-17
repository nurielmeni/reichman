<?php
require_once 'Hunter/NlsCards.php';
require_once 'Hunter/NlsSecurity.php';
require_once 'Hunter/NlsDirectory.php';
require_once 'Hunter/NlsSearch.php';
require_once 'Hunter/NlsHelper.php';
require_once 'Hunter/NlsFilter.php';
/**
 * Description of class-NlsHunterFbf-modules
 *
 * @author nurielmeni
 */
class NlsHunterFbf_model
{
    const STATUS_OPEN = 1;


    private $nlsSecutity;
    private $auth;
    private $nlsCards;
    private $nlsSearch;
    private $nlsDirectory;
    private $supplierId;

    private $nlsFlashCache  = false;

    private $countPerPage = 10;
    private $countHotJobs = 6;

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
        $this->countPerPage = get_option(NlsHunterFbf_Admin::NLS_JOBS_COUNT, 10);
        $this->countHotJobs = get_option(NlsHunterFbf_Admin::NLS_HOT_JOBS_COUNT, 6);
        $this->supplierId = $this->queryParam('sid', get_option(NlsHunterFbf_Admin::NSOFT_SUPPLIER_ID));
        $this->nlsFlashCache = $this->queryParam('flash-cache', false) ? true : false;

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

        // Load data on ajax calls
        if (!wp_doing_ajax()) {
        }
    }

    public function queryParam($param, $default = '', $post = false)
    {
        if ($post) {
            return isset($_POST[$param]) ? $_POST[$param] : $default;
        }
        return isset($_GET[$param]) ? $_GET[$param] : $default;
    }

    public function getSearchResultsPageUrl()
    {
        $language = get_bloginfo('language');
        $searcResultsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_EN);
        $searcResultsPageUrl = get_page_link($searcResultsPageId);
        return $searcResultsPageUrl;
    }

    public function getJobDetailsPageUrl()
    {
        $language = get_bloginfo('language');
        $jobDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_EN);
        $jobDetailsPageUrl = get_page_link($jobDetailsPageId);
        return $jobDetailsPageUrl;
    }

    public function getPersonalPageUrl()
    {
        $language = get_bloginfo('language');
        $jobDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_PERSONAL_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_PERSONAL_PAGE_EN);
        $jobDetailsPageUrl = get_page_link($jobDetailsPageId);
        return $jobDetailsPageUrl;
    }

    public function searchParams($post = false)
    {
        $params['keyword'] = $this->queryParam('keywords', '', $post);
        $params['category'] = $this->queryParam('job-category', [], $post);
        $params['scope'] = $this->queryParam('job-scope', [], $post);
        $params['rank'] = $this->queryParam('job-rank', [], $post);
        $params['date-range'] = $this->queryParam('date-range', '', $post);
        $params['employmentType'] = $this->queryParam('employments-type', [], $post);
        $params['location'] = $this->queryParam('job-location', [], $post);

        return $params;
    }

    public function nlsGetSupplierId()
    {
        return $this->supplierId;
    }

    public function nlsGetCountPerPage()
    {
        return intval($this->countPerPage);
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

    private function nlsPublicNotice($title, $notice)
    {
        $cont = '<div class="notice notice-error"><label>' . $title . '</label><p>' . $notice . '</p></div>';

        add_action('the_post', function ($post) use ($cont) {
            echo $cont;
        });
    }

    private function nlsAdminNotice($title, $notice)
    {
        add_action('admin_notices', function () use ($title, $notice) {
            $class = 'notice notice-error';
            printf('<div class="%1$s"><label>%2$s</label><p>%3$s</p></div>', esc_attr($class), esc_html($title), esc_html($notice));
        });
    }

    public function notice($title, $notice)
    {
        if (is_admin()) $this->nlsAdminNotice($title, $notice);
        else $this->nlsPublicNotice($title, $notice);
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

        return true;
    }

    public function emailFrequency()
    {
        return [
            [
                'id' => 1,
                'name' => __('Daily', 'NlsHunterFbf')
            ],
            [
                'id' => 2,
                'name' => __('Weekly', 'NlsHunterFbf')
            ],
            [
                'id' => 3,
                'name' => __('Monthly', 'NlsHunterFbf')
            ],
        ];
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

        return true;
    }

    public function searchJobByJobCode($jobCode)
    {
        return $this->nlsCards->searchJobByJobCode($jobCode);
    }

    /**
     * Return the categories
     */
    public function categories()
    {
        $this->initDirectoryService();
        $categories = $this->nlsDirectory->getCategories();
        return $categories;
    }

    public function jobScopes()
    {
        $this->initDirectoryService();

        $cacheKey = 'JOB_SCOPES';
        $jobScopes = wp_cache_get($cacheKey);

        if (false === $jobScopes) {
            $jobScopes = $this->nlsDirectory->getJobScopes();
            wp_cache_set($cacheKey, $jobScopes, 'directory', 20 * 60);
        }

        return is_array($jobScopes) ? $jobScopes : [];
    }

    public function jobRanks()
    {
        $this->initDirectoryService();

        $cacheKey = 'JOB_RANKS';
        $jobRanks = wp_cache_get($cacheKey);

        if (false === $jobRanks) {
            $jobRanks = $this->nlsDirectory->getJobRanks();
            wp_cache_set($cacheKey, $jobRanks, 'directory', 20 * 60);
        }

        return is_array($jobRanks) ? $jobRanks : [];
    }

    public function getDateRange()
    {
        return [
            [
                'id' => 'today',
                'name' => __('Today', 'NlsHunterFbf'),
            ],
            [
                'id' => 'lastWeek',
                'name' => __('Last Week', 'NlsHunterFbf'),
            ],
            [
                'id' => 'lastMonth',
                'name' => __('Last Month', 'NlsHunterFbf'),
            ],
            [
                'id' => 'all',
                'name' => __('All', 'NlsHunterFbf'),
            ]
        ];
    }

    public function professionalFields()
    {
        $this->initDirectoryService();

        $cacheKey = 'PROFESSIONAL_FIELD';
        $professionalFields = wp_cache_get($cacheKey);

        if (false === $professionalFields) {
            $professionalFields = $this->nlsDirectory->getProfessionalFields();
            wp_cache_set($cacheKey, $professionalFields, 'directory', 20 * 60);
        }

        return is_array($professionalFields) ? $professionalFields : [];
    }

    public function employmentForm()
    {
        $this->initDirectoryService();

        $cacheKey = 'EMPLOYMENT_FORM';
        $employmentForm = wp_cache_get($cacheKey);

        if (false === $employmentForm) {
            $employmentForm = $this->nlsDirectory->getEmploymentForm();
            wp_cache_set($cacheKey, $employmentForm, 'directory', 20 * 60);
        }

        return is_array($employmentForm) ? $employmentForm : [];
    }

    public function getEmployers($page = null, $searchPhrase = '')
    {
        $searchPhrase = trim($searchPhrase);
        $cache_key = 'nls_hunter_employers_' . get_bloginfo('language');
        if ($this->nlsFlashCache) wp_cache_delete($cache_key);

        $employers = wp_cache_get($cache_key);
        if (false === $employers) {
            $employers = [];
            $jobs = $this->getJobHunterExecuteNewQuery2([], null, 0, 10000);
            if (!$jobs || !is_array($jobs) || !key_exists('list', $jobs)) return [];
            foreach ($jobs['list'] as $job) {
                if (property_exists($job, 'EmployerId') && $job->EmployerId !== null) {
                    //$data['EmployerEntityTypeCode'] = $job->EmployerEntityTypeCode;
                    $data['EmployerName'] = $job->EmployerName;
                    //$data['EmployerPartyUtilizerId'] = $job->EmployerPartyUtilizerId;
                    $data['LogoPath'] = $job->LogoPath;

                    $employers[$job->EmployerId] = (object) $data;
                }
            }

            wp_cache_set($cache_key, $employers, '', $this->nlsCacheTime);
        }
        if ($page !== null && is_int($page)) {
            $window = intval(get_option(NlsHunterFbf_Admin::NLS_EMPLOYERS_COUNT, 1000));
            if (strlen($searchPhrase) > 0) {
                $employers = array_filter($employers, function ($employer) use ($searchPhrase) {
                    return stripos($employer->EmployerName, $searchPhrase) !== false;
                });
            }
            return array_slice($employers, $page * $window, $window);
        }
        return $employers;
    }

    public function getEmployerData($employerId)
    {
        $employers = $this->getEmployers();
        if (!is_array($employers)) return null;
        return key_exists($employerId, $employers) ? $employers[$employerId] : null;
    }

    /**
     * Uses the card service to get jobs (depricted)
     * The search is noe done by Search service (getJobHunterExecuteNewQuery2)
     */
    public function getJobsGetByFilter($searchParams, $lastId, $sendToAgent = false)
    {
        $this->initCardService();

        if (!is_array($searchParams)) return [];

        $jobs = $this->nlsCards->jobsGetByFilter([
            'keywords' => key_exists('keywords', $searchParams) ? $searchParams['keywords'] : '',
            'categoryId' => key_exists('categoryIds', $searchParams) ? $searchParams['categoryIds'] : [],
            'regionValue' => key_exists('regionValues', $searchParams) ? $searchParams['regionValues'] : [],
            'employmentType' => key_exists('employmentTypes', $searchParams) ? $searchParams['employmentTypes'] : [],
            'jobScope' => key_exists('jobScopes', $searchParams) ? $searchParams['jobScopes'] : [],
            'jobLocation' => key_exists('jobLocations', $searchParams) ? $searchParams['jobLocations'] : [],
            'employerId' => key_exists('employerId', $searchParams) ? $searchParams['employerId'] : '',
            'updateDate' => key_exists('updateDate', $searchParams) ? $searchParams['updateDate'] : '',
            'supplierId' => $this->nlsGetSupplierId(),
            'lastId' => $lastId,
            'countPerPage' => $this->nlsGetCountPerPage(),
            'status' => self::STATUS_OPEN,
            'sendToAgent' => $sendToAgent
        ]);

        return $jobs;
    }

    public function getHotJobs($professionalFields = null, $count)
    {
        $searchParams = is_array($professionalFields) ? ['' => $professionalFields] : [];
        return $this->getJobHunterExecuteNewQuery2($searchParams, null, 0, $count ? $count : $this->countHotJobs);
    }

    private function joinVals($param)
    {
        if (!$param || !is_array($param)) return '';
        return implode('_', $param);
    }

    // For keywords search
    private function addSearchTerm(&$arr, $term)
    {
        $field = new FilterField('Description', SearchPhrase::ONE_OR_MORE, $term, NlsFilter::TERMS_NON_ANALAYZED);
        $arr[] = $field;

        $field = new FilterField('Requiremets', SearchPhrase::ONE_OR_MORE, $term, NlsFilter::TERMS_NON_ANALAYZED);
        $arr[] = $field;

        $field = new FilterField('JobTitle', SearchPhrase::ONE_OR_MORE, $term, NlsFilter::TERMS_NON_ANALAYZED);
        $arr[] = $field;
    }

    public function getJobHunterExecuteNewQuery2($searchParams, $hunterId = null, $page = 0, $resultRowLimit = null)
    {
        $this->initSearchService();
        $resultRowLimit = $resultRowLimit ? $resultRowLimit : $this->nlsGetCountPerPage();
        $resultRowOffset = is_int($page) ? $page * $resultRowLimit : false;

        if (!is_array($searchParams)) return [];

        $filter = new NlsFilter();

        $keyword = key_exists('keyword', $searchParams) && strlen($searchParams['keyword']) > 0 ? $searchParams['keyword'] : false;
        $category = key_exists('category', $searchParams) && count($searchParams['category']) > 0 ? $searchParams['category'] : false;
        $scope = key_exists('scope', $searchParams) && count($searchParams['scope']) > 0 ? $searchParams['scope'] : false;
        $rank = key_exists('rank', $searchParams) && count($searchParams['rank']) > 0 ? $searchParams['rank'] : false;
        $dateRange = key_exists('date-range', $searchParams) && strlen($searchParams['date-range']) > 0 ? $searchParams['date-range'] : false;
        $employmentForm = key_exists('employmentForm', $searchParams) && strlen($searchParams['employmentForm']) > 0 ? $searchParams['employmentForm'] : false;
        $employmentType = key_exists('employmentType', $searchParams) && count($searchParams['employmentType']) > 0 ? $searchParams['employmentType'] : false;

        $cache_key = 'nls_hunter_jobs_';
        $cache_key .= $category ? $this->joinVals($category) : '';
        $cache_key .= $scope ? $this->joinVals($scope) : '';
        $cache_key .= $rank ? $this->joinVals($rank) : '';
        $cache_key .= $dateRange ? $this->joinVals($dateRange) : '';
        $cache_key .= $employmentType ? $this->joinVals($employmentType) : '';
        $cache_key .= $keyword ? $keyword : '';
        $cache_key .= $resultRowOffset . '_' . $resultRowLimit;
        $hashedKey = hash('md5', $cache_key);

        if ($this->nlsFlashCache) wp_cache_delete($hashedKey);

        $jobs = wp_cache_get($hashedKey);


        if (false === $jobs) {
            if (!$this->initSearchService()) return ['totalHits' => 0, 'list' => []];

            if (!is_array($searchParams)) $jobs = [];
            $filter = new NlsFilter();

            $filter->addSuplierIdFilter($this->nlsGetSupplierId());

            if ($category) {
                $filterField = new FilterField('JobProfessionalFields', SearchPhrase::EXACT, $category, NlsFilter::NESTED);
                $nestedFilterField = new FilterField('JobProfessionalFieldInfo_CategoryId', SearchPhrase::ALL, $category, NlsFilter::NUMERIC_VALUES);
                $filterField->setNested($nestedFilterField);
                $filter->addWhereFilter($filterField, is_array($filterField) ? WhereCondition::C_OR : WhereCondition::C_AND);
            }

            if ($scope) {
                $filterField = [];
                foreach ($scope as $value) {
                    $filterFieldOption = new FilterField('JobScope', SearchPhrase::EXACT, $value, NlsFilter::NUMERIC_VALUES);
                    $filterField[] = $filterFieldOption;
                }
                $filter->addWhereFilter($filterField, is_array($filterField) ? WhereCondition::C_OR : WhereCondition::C_AND);
            }

            if ($rank) {
                $filterField = new FilterField('Rank', SearchPhrase::EXACT, $rank, NlsFilter::NUMERIC_VALUES);
                $filter->addWhereFilter($filterField, is_array($filterField) ? WhereCondition::C_OR : WhereCondition::C_AND);
            }

            if ($dateRange) {
                // date("m/d/Y", $start) . " - " . date("m/d/Y", $end)
                $now = new DateTime('now');
                $endDate = $now->modify('+1 day')->format('m/d/Y');

                switch ($dateRange) {
                    case 'today':
                        $startDate = $now->format('m/d/Y');
                        break;
                    case 'lastWeek':
                        $startDate = $now->modify('-7 day')->format('m/d/Y');
                        break;
                    case 'lastMonth':
                        $startDate = $now->modify('-1 month')->format('m/d/Y');
                        break;
                    default:
                        return;
                }

                $dateSpan = $startDate . '-' . $endDate;

                $filterField = new FilterField('UpdateDate', SearchPhrase::BETWEEN_DATES, $dateSpan, NlsFilter::DATE_TIME_RANGE);
                $filter->addWhereFilter($filterField, is_array($filterField) ? WhereCondition::C_OR : WhereCondition::C_AND);
            }

            if ($employmentForm) {
                $filterField = new FilterField('EmploymentForm', SearchPhrase::EXACT, $employmentForm, NlsFilter::NUMERIC_VALUES);
                $filter->addWhereFilter($filterField, is_array($filterField) ? WhereCondition::C_OR : WhereCondition::C_AND);
            }

            if ($keyword) {
                $keywords = preg_split("/[\s,]+/", $keyword);
                $fields = [];

                foreach ($keywords as $term) {
                    $this->addSearchTerm($fields, $term);
                }
                $filter->addWhereFilter($fields, WhereCondition::C_OR);
            }

            try {
                $res = $this->nlsSearch->JobHunterExecuteNewQuery2(
                    $hunterId,
                    $resultRowOffset,
                    $resultRowLimit,
                    $filter
                );

                $jobs['totalHits'] = $res && property_exists($res, 'TotalHits') ? $res->TotalHits : 0;

                if ($jobs['totalHits'] === 0) {
                    $jobs['list'] = [];
                } else {
                    $jobInfo = $res && property_exists($res, 'Results') && property_exists($res->Results, 'JobInfo') ? $res->Results->JobInfo : false;
                    $jobs['list'] = !$jobInfo ? [] : (is_array($jobInfo) ? $jobInfo : [$jobInfo]);
                }

                wp_cache_set($cache_key, $jobs);
            } catch (Exception $ex) {
                $this->notice('Model: getJobHunterExecuteNewQuery2', $ex->getMessage());
                return null;
            }
        }



        return $jobs;
    }

    public function getCardProfessinalField($cardId)
    {
        $this->initCardService();

        $professionalFields = $this->nlsCards->cardProfessinalField($cardId);

        return $professionalFields;
    }

    /**
     * Get job details by jon id
     * @jobId - the jon id
     */
    public function getJobDetails($jobId)
    {
        $this->initCardService();

        return $this->nlsCards->jobGet($jobId);
    }

    public function applicantGet($applicantGuid, $collections = 'None')
    {
        $this->initCardService();
        return $this->nlsCards->applicantGet($applicantGuid, $collections);
    }

    public function getApplicantByUserName($userName)
    {
        $this->initDirectoryService();
        return $this->nlsDirectory->getApplicantByUserName($userName);
    }

    public function applicantGetByFilter2($searchParams)
    {
        if (!is_array($searchParams)) return [];

        $entityLocalName = key_exists('entityLocalName', $searchParams) && strlen($searchParams['entityLocalName']) > 0 ? $searchParams['entityLocalName'] : false;
        $mobilePhone = key_exists('mobilePhone', $searchParams) && count($searchParams['mobilePhone']) > 0 ? $searchParams['mobilePhone'] : false;
        $officePhone = key_exists('officePhone', $searchParams) && count($searchParams['officePhone']) > 0 ? $searchParams['officePhone'] : false;
        $homePhone = key_exists('homePhone', $searchParams) && count($searchParams['homePhone']) > 0 ? $searchParams['homePhone'] : false;
        $email = key_exists('email', $searchParams) && count($searchParams['email']) > 0 ? $searchParams['email'] : false;
        $foreignEntityCode = key_exists('foreignEntityCode', $searchParams) && count($searchParams['foreignEntityCode']) > 0 ? $searchParams['foreignEntityCode'] : false;

        $cache_key = 'nls_hunter_applicants_';
        $cache_key .= $entityLocalName ? $entityLocalName : '';
        $cache_key .= $mobilePhone ? $this->joinVals($mobilePhone) : '';
        $cache_key .= $officePhone ? $this->joinVals($officePhone) : '';
        $cache_key .= $homePhone ? $this->joinVals($homePhone) : '';
        $cache_key .= $email ? $this->joinVals($email) : '';
        $cache_key .= $foreignEntityCode ? $this->joinVals($foreignEntityCode) : '';
        $hashedKey = hash('md5', $cache_key);

        if ($this->nlsFlashCache) wp_cache_delete($hashedKey);

        $applicants = wp_cache_get($hashedKey);


        if (false === $applicants) {
            if (!$this->initCardService()) return ['totalHits' => 0, 'list' => []];

            if (!is_array($searchParams)) $applicants = [];
            $filter = new NlsFilter('Applicants');

            if ($entityLocalName) {
                $filterField = new FilterField('EntityLocalName', SearchPhrase::LIKE, $entityLocalName, NlsFilter::TERMS_NON_ANALAYZED);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            if ($mobilePhone) {
                $filterField = new FilterField('MobilePhone', SearchPhrase::LIKE, $mobilePhone, NlsFilter::TERMS_NON_ANALAYZED);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            if ($officePhone) {
                $filterField = new FilterField('officePhone', SearchPhrase::LIKE, $officePhone, NlsFilter::TERMS_NON_ANALAYZED);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            if ($homePhone) {
                $filterField = new FilterField('homePhone', SearchPhrase::LIKE, $homePhone, NlsFilter::TERMS_NON_ANALAYZED);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            if ($email) {
                $filterField = new FilterField('email', SearchPhrase::LIKE, $email, NlsFilter::TERMS_NON_ANALAYZED);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            if ($foreignEntityCode) {
                $filterField = new FilterField('foreignEntityCode', SearchPhrase::EXACT, $foreignEntityCode, NlsFilter::NUMERIC_VALUES);
                $filter->addWhereFilter($filterField, WhereCondition::C_OR);
            }

            $filter->setSort('EntityLocalName');

            $filter->addSelectFilterFields([
                'CardId',
                'EntityLocalName',
                'MobilePhone',
                'Email'
            ]);

            try {
                $res = $this->nlsCards->applicantGetByFilter2($filter);

                return $res;

                wp_cache_set($cache_key, $applicants);
            } catch (Exception $ex) {
                $this->notice('Model: getJobHunterExecuteNewQuery2', $ex->getMessage());
                return null;
            }
        }
    }

    public function getApplicantCVList($applicantId)
    {
        $this->initCardService();
        $cacheKey = 'APPLICANT_CV_' . $applicantId;
        $applicantCvList = wp_cache_get($cacheKey);

        if (false === $applicantCvList) {
            $this->initCardService();
            $cvList = $this->nlsCards->getCVList($applicantId);


            $applicantCvList = new stdClass();
            $applicantCvList->list = is_array($cvList) ? $cvList : [$cvList];
            $applicantCvList->totalNumResults = count($applicantCvList->list);

            wp_cache_set($cacheKey, $applicantCvList, 'card', 20 * 60);
        }

        return $applicantCvList;
    }

    public function getFileInfo($fileId, $applicantId)
    {
        $this->initCardService();
        $cacheKey = 'FILE_INFO_' . $fileId . $applicantId;

        $fileInfo = wp_cache_get($cacheKey);

        if (false === $fileInfo) {
            $res = $this->nlsCards->getFileInfo($fileId, $applicantId);
            $fileInfo = $res->FileGetByFileIdResult;
            wp_cache_set($cacheKey, $fileInfo, 'card', 20 * 60);
        }

        return $fileInfo;
    }

    public function fileGetWithContent($fileId, $applicantId)
    {
        $this->initCardService();
        $cacheKey = 'FILE_INFO_CONTENT' . $fileId . $applicantId;

        $fileInfo = wp_cache_get($cacheKey);

        if (false === $fileInfo) {
            $fileInfo = $this->nlsCards->getFileInfo($fileId, $applicantId, true);
            wp_cache_set($cacheKey, $fileInfo, 'card', 20 * 60);
        }

        return $fileInfo;
    }

    public function getFileList($applicantId)
    {
        $this->initCardService();
        $cacheKey = 'FILE_LIST' . $applicantId;

        $fileList = wp_cache_get($cacheKey);

        if (false === $fileList) {
            $res = $this->nlsCards->getFileList($applicantId);
            $fileList = new stdClass();
            $fileList->list = count(get_object_vars($res->FilesListGetResult)) === 0 ? [] : (is_array($res->FilesListGetResult) ? $res->FilesListGetResult : [$res->FilesListGetResult]);
            $fileList->totalNumResults = count($fileList->list); //$res->totalNumResults ? $res->totalNumResults :

            wp_cache_set($cacheKey, $fileList, 'card', 20 * 60);
        }

        return $fileList;
    }

    public function getAgents()
    {
        return [
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 1',
                'date' => '15/12/2021'
            ],
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 2',
                'date' => '15/12/2021'
            ],
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 3',
                'date' => '15/12/2021'
            ],
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 4',
                'date' => '15/12/2021'
            ],
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 5',
                'date' => '15/12/2021'
            ],
            [
                'id' => '132434-354235235-25353',
                'name' => 'סוכן 6',
                'date' => '15/12/2021'
            ],
        ];
    }

    public function searchApplicantsByName($name)
    {
        $this->initSearchService();
        return $this->nlsCards->SearchApplicantsByName($name);
    }

    public function userGetById($userId, $utilizerId = 3856)
    {
        $this->initDirectoryService();
        return $this->nlsDirectory->userGetById($userId);
    }

    public function getUserIdByCardId($cardId)
    {
        $this->initDirectoryService();
        $cacheKey = 'USER_ID_BY_CARD' . $cardId;

        $userId = wp_cache_get($cacheKey);

        if (false === $userId) {
            $res = $this->nlsDirectory->getUserIdByCardId($cardId);
            wp_cache_set($cacheKey, $userId, 'card', 20 * 60);
            return $res;
        }

        return $userId;
    }

    public function getFilesInfo($files, $cardId)
    {
        $files = is_array($files) ? $files : (is_int($files) ? [$files] : []);

        $this->initCardService();
        $res = [];
        foreach ($files as $file) {
            $fileInfo = $this->nlsCards->getFileInfo($file->FileId, $cardId);
            if (!$fileInfo) continue;

            $fileObj = new stdClass();
            $fileObj->id = $fileInfo->FileId;
            $fileObj->name = trim($fileInfo->Name) . '.' . trim($fileInfo->Type);
            $fileObj->updateDate = strtotime($fileInfo->UpdateDate);
            $fileObj->mimeType = $this->fileMimeType($fileInfo);
            $res[] = $fileObj;
        }
        return $res;
    }

    private function fileMimeType($file)
    {
        if (!$file || !$file->Type) return '';

        $mimeType = '';
        switch (trim($file->Type)) {
            case 'txt':
                $mimeType = 'text/plain';
                break;
            case 'pdf':
                $mimeType = 'application/pdf';
                break;
            case 'doc':
                $mimeType = 'application/msword';
                break;
            case 'docx':
                $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;
            case 'rtf':
                $mimeType = 'application/rtf';
                break;
            default:
                break;
        }

        return $mimeType;
    }
}
