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


    public function nlsHunterFbf_render()
    {
        ob_start();
?>

        <section class="nls-hunter-fbf-wrapper nls-main-row alignfull">
            <?= render('applyForJobs', [
                'jobs' => $this->model->getJobsBySupplierId(),
                'supplierId' => get_option(NlsHunterFbf_Admin::NSOFT_SUPPLIER_ID)
            ]) ?>
        </section>

<?php
        return ob_get_clean();
    }
}
