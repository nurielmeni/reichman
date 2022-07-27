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
    private $nlsUser;

    public function __construct($model, $nlsUser)
    {
        $this->model = $model;
        $this->nlsUser = $nlsUser;
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
            'model' => $this->model,
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

    public function nlsHunterSearchResults_render()
    {
        $searchParams = $this->model->searchParams();
        $page = $this->model->queryParam('page', 0);
        $jobs = $this->model->getJobHunterExecuteNewQuery2($searchParams, null, $page);

        $jobDetailsPageUrl = $this->model->getJobDetailsPageUrl();

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

    private function getTemporaryAgents($agents)
    {
        $hunters = $agents && property_exists($agents, 'temporaryHunters') && property_exists($agents->temporaryHunters, 'HunterListItem') ? $agents->temporaryHunters->HunterListItem : [];
        return is_array($hunters) ? $hunters : [$hunters];
    }

    private function getTemporaryAgentsDetails($agents)
    {
        $temporaryAgents = $this->getTemporaryAgents($agents);
        $res = [];

        foreach ($temporaryAgents as $temporaryAgent) {
            $hunterId = $temporaryAgent->Value;
            $agent = $this->model->jobHunterGetInfo($hunterId);
            if ($agent && property_exists($agent, 'JobHunterGetInfoResult'))
                $res[] = $agent->JobHunterGetInfoResult;
        }
        return $res;
    }

    public function nlsHunterPersonalDashboard_render()
    {
        $data = [
            'cv' => '...',
            'hunted-jobs' => '...',
            'applied-jobs' => '...'
        ];

        ob_start();

        echo render('personal/dashboard', [
            'model' => $this->model,
            'data' => $data,
            'personalPageUrl' => $this->model->getPersonalPageUrl()
        ]);

        return ob_get_clean();
    }

    public function nlsHunterPersonalModule_render()
    {
        $agents = $this->model->jobHuntersGetForUser($this->nlsUser);
        //$agentsDetails = $this->getTemporaryAgentsDetails($agents);
        $agentsDetails = $this->getTemporaryAgents($agents);

        ob_start();

        echo render('personal/module', [
            'model' => $this->model,
            'searchParams' =>  $this->model->searchParams(),
            'agents' => $agentsDetails,
            'user' => $this->nlsUser,
            'personalPageUrl' => $this->model->getPersonalPageUrl(),
            'modalId' => 'fileManagerModal'
        ]);

        return ob_get_clean();
    }
}
