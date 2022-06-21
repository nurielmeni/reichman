<?php
require_once 'Hunter/NlsHelper.php';
require_once NLS__PLUGIN_PATH . '/renderFunction.php';

/**
 * Description of class-NlsHunterFbf-modules
 *
 * @author nurielmeni
 */
class NlsHunterFbf_modules
{
    private $model;
    private $attributes;
    private $applicantId;

    public function __construct($model)
    {
        $this->model = $model;
        $this->attributes = [
            'phone' => ['054-7641456'],
            'fullName' => ['כלכלה כלכלה'],
            'applicantID' => ['55555']
        ];

        $this->applicantId = '826084ab-89b4-4909-b831-bb790a2ede7b';
    }

    private function getSearchResultsPageUrl()
    {
        $language = get_bloginfo('language');
        $searcResultsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_EN);
        $searcResultsPageUrl = get_page_link($searcResultsPageId);
        return $searcResultsPageUrl;
    }

    private function getJobDetailsPageUrl()
    {
        $language = get_bloginfo('language');
        $jobDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_EN);
        $jobDetailsPageUrl = get_page_link($jobDetailsPageId);
        return $jobDetailsPageUrl;
    }

    private function getPersonalPageUrl()
    {
        $language = get_bloginfo('language');
        $jobDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_PERSONAL_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_PERSONAL_PAGE_EN);
        $jobDetailsPageUrl = get_page_link($jobDetailsPageId);
        return $jobDetailsPageUrl;
    }

    private function searchParams()
    {
        $params['keyword'] = $this->model->queryParam('keywords');
        $params['category'] = $this->model->queryParam('job-category', []);
        $params['scope'] = $this->model->queryParam('job-scope', []);
        $params['rank'] = $this->model->queryParam('job-rank', []);
        $params['lastUpdate'] = $this->model->queryParam('last-update');
        $params['employmentType'] = $this->model->queryParam('employments-type', []);
        $params['location'] = $this->model->queryParam('job-location', []);

        return $params;
    }

    public function nlsHotJobs_render()
    {
        $professionalFields = $this->model->getCardProfessinalField($this->applicantId);
        $hotJobs = $this->model->getHotJobs($professionalFields, 6);

        ob_start();
        echo render('slider/horizontalSlider', [
            'elements' => $hotJobs,
            'elementTemplate' => 'slider/nlsHotJob'
        ]);
        return ob_get_clean();
    }

    public function nlsHunterCategories_render()
    {
        //$nlsCategories = $this->model->getCategories();

        $categoryPosts = get_posts([
            'category' => 'Jobs-by-category',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order'   => 'ASC',
            'posts_per_page' => -1,
            'numberposts' => -1,
        ]);

        $categories = array_map(function ($n) {
            $tn = get_the_post_thumbnail($n->ID);
            $order = strtotime($n->post_date);
            return [
                'order' => $order,
                'imageTag' => $tn,
                'title' => $n->post_title,
                'categoryId' => $n->post_excerpt
            ];
        }, $categoryPosts);

        ob_start();
        echo render('nlsCategories', [
            'categories' => $categories,
        ]);
        return ob_get_clean();
    }

    public function nlsHunterSearch_render()
    {
        $searchParams = $this->searchParams();

        ob_start();

        echo render('search/nlsJobSearch', [
            'model' => $this->model,
            'searchParams' => $searchParams,
            'searcResultsPageUrl' => $this->getSearchResultsPageUrl()
        ]);

        return ob_get_clean();
    }

    public function nlsHunterPersonalDashboard_render()
    {
        $data = [
            'cv' => 2,
            'hunted-jobs' => 30,
            'applied-jobs' => 12
        ];

        ob_start();

        echo render('personal/dashboard', [
            'model' => $this->model,
            'data' => $data,
            'personalPageUrl' => $this->getPersonalPageUrl()
        ]);

        return ob_get_clean();
    }

    public function nlsHunterSearchResults_render()
    {
        $searchParams = $this->searchParams();
        $from =  get_query_var('last_page', 0);
        $jobs = $this->model->getJobHunterExecuteNewQuery2($searchParams, null, $from);



        $jobDetailsPageUrl = $this->getJobDetailsPageUrl();
        $applicantCVs = $this->model->getApplicantCVList($this->applicantId);

        ob_start();

        echo render('search/nlsJobSearch', [
            'model' => $this->model,
            'searchParams' => $searchParams,
            'searcResultsPageUrl' => $this->getSearchResultsPageUrl()
        ]);

        if (!$jobs) {
            echo "An error occured on the search attempt";
            return ob_get_clean();
        }

        echo render('search/nlsSearcResults', [
            'model' => $this->model,
            'jobs' => $jobs,
            'jobDetailsPageUrl' => $jobDetailsPageUrl
        ]);

        return ob_get_clean();
    }
}
