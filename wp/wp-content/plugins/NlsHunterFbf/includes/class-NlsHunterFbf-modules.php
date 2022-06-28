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

    public function nlsHotJobs_render()
    {
        $hotJobs = $this->model->getHotJobs(null, 6);

        ob_start();
        echo render('slider/horizontalSlider', [
            'elements' => $hotJobs['list'],
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
        $searchParams = $this->model->searchParams();

        ob_start();

        echo render('search/nlsJobSearch', [
            'model' => $this->model,
            'searchParams' => $searchParams,
            'searcResultsPageUrl' => $this->model->getSearchResultsPageUrl()
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
            'personalPageUrl' => $this->model->getPersonalPageUrl()
        ]);

        return ob_get_clean();
    }

    private function statItems()
    {
        return [
            [
                'action' => 'applied-jobs',
                'label' => __('Jobs I applied to', 'NlsHunterFbf'),
                'image' => NLS__PLUGIN_URL . '/public/images/personal/applied.svg',
                'value' => '20'
            ],
            [
                'action' => 'cv-files',
                'modalToggle' => 'fileManagerModal',
                'label' => __('My CV Files', 'NlsHunterFbf'),
                'image' => NLS__PLUGIN_URL . '/public/images/personal/cv.svg',
                'value' => '1'
            ],
            [
                'action' => 'additional-files',
                'modalToggle' => 'fileManagerModal',
                'label' => __('Additional Files', 'NlsHunterFbf'),
                'image' => NLS__PLUGIN_URL . '/public/images/personal/folder.svg',
                'value' => '1'
            ],
            [
                'action' => 'agent-jobs',
                'label' => __('Jobs by Smart Agent', 'NlsHunterFbf'),
                'image' => NLS__PLUGIN_URL . '/public/images/personal/agent.svg',
                'value' => '1'
            ],
            [
                'action' => 'my-area-jobs',
                'label' => __('Jobs by My Area', 'NlsHunterFbf'),
                'image' => NLS__PLUGIN_URL . '/public/images/personal/matched.svg',
                'value' => '1'
            ]
        ];
    }

    public function nlsHunterPersonalModule_render()
    {
        $agents = $this->model->getAgents();

        ob_start();

        echo render('personal/module', [
            'model' => $this->model,
            'statItems' => $this->statItems(),
            'searchParams' =>  $this->model->searchParams(),
            'agents' => $agents,
            'personalPageUrl' => $this->model->getPersonalPageUrl(),
            'modalId' => 'fileManagerModal'
        ]);

        return ob_get_clean();
    }

    public function nlsHunterSearchResults_render()
    {
        $searchParams = $this->model->searchParams();
        $page = $this->model->queryParam('page', 0);
        $jobs = $this->model->getJobHunterExecuteNewQuery2($searchParams, null, $page);

        $jobDetailsPageUrl = $this->model->getJobDetailsPageUrl();
        $applicantCVs = $this->model->getApplicantCVList($this->applicantId);

        ob_start();

        echo render('search/nlsJobSearch', [
            'model' => $this->model,
            'searchParams' => $searchParams,
            'searcResultsPageUrl' => $this->model->getSearchResultsPageUrl()
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

        echo render('job/applyForJobs', [
            'supplierId' => $this->model->nlsGetSupplierId(),
        ]);

        return ob_get_clean();
    }
}
