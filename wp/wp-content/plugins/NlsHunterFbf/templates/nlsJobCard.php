<?php
/**
 * @job
 */
?>
<div class="job-card flex flex-col justify-between items-center w-full">
  <h2 class="job-title text-2xl text-primary font-bold truncate w-full" title="<?= $job['jobTitle'] ?>">
    <?= $job['jobTitle'] ?>
</h2>
<div class="flex justify-between w-full">
  <span class="w-20">left</span>
  <span class="w-full border-x-4">center</span>
  <span class="w-20">rigth</span>
</div>
</div>