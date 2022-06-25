<article class="flex flex-wrap justify-start bg-bg-light gap-8 px-6 py-12 mt-4 md:px-20">
    <?php foreach ($agents as $agent) : ?>
        <?= render(
            'personal/agent',
            $agent
        ) ?>
    <?php endforeach; ?>

    <div class="smart-agent-card flex justify-center items-center bg-white min-h-[12rem] m-0">
        <button type="button" class="text-[10rem]">+</button>
    </div>
</article>