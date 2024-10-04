<?php $this->layout('layout') ?>

    <main>

        <section class="add-post">

            <h2 class="add-post__title">Adicionar Nova Postagem</h2>
            
            <form class="form" method="post" enctype="multipart/form-data">
                <label class="form__title" for="title">Título:</label>
                <input type="text" id="title" name="title" value="<?= $post?->getTitle() ?>" >

                <label class="form__title" for="summary">Resumo:</label>
                <textarea id="summary" name="summary" rows="3" ><?= $post?->getSummary() ?></textarea>

                <label class="form__title" for="content">Conteúdo:</label>
                <textarea id="content" name="content" rows="5" ><?= $post?->getContent() ?></textarea>

                <label class="form__title" for="image">Imagem:</label>
                <input type="file" accept="image/*" id="image" name="image">

                <input type="hidden" name="old-image" value="<?= $post->getImage() ?>">

                <button class="form__submit" type="submit">Publicar</button>
            </form>
        
        </section>

    </main>
    