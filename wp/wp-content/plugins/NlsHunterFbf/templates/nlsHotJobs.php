<section class="nls-hunter-hot-jobs-wrapper alignwide">
  <div class="grid grid-rows-1 grid-cols-4">
    <div class="flex justify-start items-end">
      <button class="btn mb-3"><?= __('All Jobs', 'NlsHunterFbf') ?></button>
    </div>
    <div class="flex flex-col justify-center items-center col-span-2 text-center font-bold">
      <span class=" text-4xl pb-2"><?= __('Jobs we thought would interest you', 'NlsHunterFbf') ?></span>
      <div class="underline-decor"></div>
    </div>
    <div class="flex justify-end  items-center">
      <img src="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs.png" srcset="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@2x.png 2x,
      <?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@3x.png 3x" class="">
    </div>
  </div>

  <div class="p-4 flex justify-between flex-wrap">
    <?= render('horizontalSlider', [
      'elements' => $hotJobs,
      'elementTemplate' => 'hotjob'
    ]) ?>
  </div>
</section>