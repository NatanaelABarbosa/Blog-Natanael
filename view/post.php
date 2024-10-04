<?php $this->layout('layout'); ?>

    <main>
        <!-- Lista de postagens -->
        <section class="post-list">
            <?php foreach($postList as $post): ?>
            <article class="post">
                <h2><?= $post->getTitle() ?></h2>
                <?php if($post->getImage() !== ''): ?>
                <img src="<?= $post->getFormatedImage() ?>" alt="Imagem do blog">
                <?php endif ?>
                <p><?= $post->getSummary() ?></p>
                <a href="/content?id=<?= $post->id ?>">Leia mais</a>
                <div class="actions">
                    <a href="/editar?id=<?= $post->id ?>">Editar</a>
                    <a href="/excluir?id=<?= $post->id ?>">Excluir</a>
                </div>
            </article>
            <?php endforeach ?>
        </section>

        <section class="add-post">

            <h2 class="add-post__title">Adicionar Nova Postagem</h2>

            <form class="form" method="post" enctype="multipart/form-data">
                
                <label class="form__title" for="title">Título:</label>
                <input type="text" id="title" name="title" >
                
                <label class="form__title" for="summary">Resumo:</label>
                <textarea id="summary" name="summary" rows="3" ></textarea>
                
                <label class="form__title" for="content">Conteúdo:</label>
                <textarea id="content" name="content" rows="5" ></textarea>
            
                <label class="form__title" for="image">Imagem:</label>
                <input type="file" accept="image/*" id="image" name="image">
                
                <button class="form__submit" type="submit">Publicar</button>
            </form>
        </section>
    </main>

    