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

    public function nlsHunterSearch_render()
    {
        ob_start();

        echo render('nlsJobSearch', ['model' => $this->model, 'params' => 'test']);

        return ob_get_clean();
    }
}
