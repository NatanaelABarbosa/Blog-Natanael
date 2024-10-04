<?php $this->layout('layout') ?>

<main>
    <article class="post">
        
        <h2> <?= $post->getTitle() ?></h2>
        <?php if($post->getImage() !== ''): ?>
            <img src="<?= $post->getFormatedImage() ?>" alt="Imagem do blog">
        <?php endif ?>

        <p> <?= $post->getContent() ?></p>

    </article>
</main>