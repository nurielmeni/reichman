<div class="flex justify-start items-center bg-white md:bg-inherit drop-shadow-lg md:drop-shadow-none rounded-lg md:rounded-none px-4 py-2 md:py-8">
    <div class="flex justify-center items-center rounded-full bg-border w-[56px] md:w-[90px] h-[56px] md:h-[90px]">
        <img class="w-[86%] h-[86%]" src="<?= $image ?>" alt="">
    </div>
    <div class="flex flex-row md:flex-col justify-center items-center md:items-start mx-2">
        <p class="text-2xl md:text-5xl px-2">
            <?= $value ?>
        </p>
        <p class="font-bold md:text-xl px-2">
            <?= $label ?>
        </p>
    </div>
</div>