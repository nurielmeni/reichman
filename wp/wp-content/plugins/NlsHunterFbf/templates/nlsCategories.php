<section class="nls-hunter-categories-wrapper alignwide">
  <div class="grid grid-rows-1 grid-cols-4">
    <div class="flex justify-start  items-center">
      <img src="<?= plugins_url('NlsHunterFbf/public/images') ?>/categories.png" srcset="<?= plugins_url('NlsHunterFbf/public/images') ?>/categories@2x.png 2x,
     <?= plugins_url('NlsHunterFbf/public/images') ?>/categories@3x.png 3x" class="">
    </div>
    <div class="flex flex-col justify-center items-center col-span-2 text-center font-bold">
      <span class=" text-4xl pb-2"><?= __('Categories', 'NlsHunterFbf') ?></span>
      <div class="underline-decor"></div>
    </div>
    <div class="flex justify-end items-end">
      <button class="btn mb-3"><?= __('All Jobs', 'NlsHunterFbf') ?></button>
    </div>
  </div>


  <div class="bg-white p-4 flex justify-between flex-wrap">
    <?php foreach ($categories as $category) : ?>
      <button type="button" class="card flex flex-grow justify-center flex-col align-center px-10 m-2" category-id="<?= $category['categoryId'] ?>">
        <div class="mb-4">
          <?= $category['imageTag'] ?>
        </div>
        <span class="text-2xl text-bold"><?= $category['title'] ?></span>
    </button>
    <?php endforeach; ?>
  </div>
</section>