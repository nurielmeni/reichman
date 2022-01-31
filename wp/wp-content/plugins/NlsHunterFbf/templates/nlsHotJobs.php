<section class="nls-hunter-hot-jobs-wrapper alignfull">
  <div class="grid grid-rows-1 grid-cols-4 alignwide">
    <div class="flex justify-start items-end">
      
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

  <div class="flex justify-between flex-wrap w-full bg-sliderbg py-3">
    <div class="flex justify-end px-8"><button class="btn mb-3"><?= __('All Jobs', 'NlsHunterFbf') ?></button></div>
    <?= render('horizontalSlider', [
      'elements' => $hotJobs,
      'elementTemplate' => 'nlsHotJob'
    ]) ?>
  </div>
</section>