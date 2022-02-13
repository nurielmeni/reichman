<?php
require_once 'Hunter/NlsHelper.php';
require_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';

/**
 * Description of class-NlsHunterFbf-modules
 *
 * @author nurielmeni
 */
class NlsHunterFbf_modules
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }


    public function nlsHotJobs_render()
    {
        $hotJobs =  [
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ],
            [
                'date' => '01.02.2022',
                'jobTitle' => 'Super Man',
                'jobCode' => 'JB-20543',
                'employer' => 'Special Tooling'
            ]
        ];

        ob_start();
        echo render('nlsHotJobs', [
            'hotJobs' => $hotJobs,
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

    private function getSearchResultsPageUrl()
    {
        $language = get_bloginfo('language');
        $searcResultsPageId = $language === 'he-IL' ?
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_HE) :
            get_option(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_EN);
        $searcResultsPageUrl = get_page_link($searcResultsPageId);
        return $searcResultsPageUrl;
    }

    public function nlsHunterSearch_render()
    {
        ob_start();

        echo render('nlsJobSearch', [
            'model' => $this->model,
            'searcResultsPageUrl' => $this->getSearchResultsPageUrl()
        ]);

        return ob_get_clean();
    }

    public function nlsHunterSearchResults_render()
    {
        $searchParams = $this->searchParams();
        $jobs = $this->model->getNlsHunterSearchResults($searchParams);

        ob_start();

        echo render('nlsJobSearch', [
            'model' => $this->model,
            'searcResultsPageUrl' => $this->getSearchResultsPageUrl()
        ]);

        echo render('nlsSearcResults', [
            'jobs' => $jobs
        ]);

        return ob_get_clean();
    }

    private function searchParams()
    {
        $params['keywords'] = $this->model->queryParam('keywords');
        $params['categoryId'] = $this->model->queryParam('job-category', false, []);
        $params['regionValue'] = $this->model->queryParam('job-region', false, []);
        $params['employmentType'] = $this->model->queryParam('employments-type', false, []);
        $params['jobScope'] = $this->model->queryParam('job-scope', false, []);
        $params['jobLocation'] = $this->model->queryParam('job-location', false, []);
        $params['employerId'] = $this->model->queryParam('employerId');
        $params['updateDate'] = $this->model->queryParam('last-update');

        return $params;
    }
}
