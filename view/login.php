<?php $this->layout('layout') ?>

    <main>

        <section class="add-post">

            <h2 class="add-post__title">Login</h2>
            
            <form class="form" method="post">

                <label class="form__title" for="email">E-mail:</label>
                <input type="text" id="email" name="email" value="<?= $post?->getTitle() ?>" required>

                <label class="form__title" for="password">Senha:</label>
                <input id="password" name="password" rows="5" type="password" required><?= $post?->getContent() ?>
                
                <button class="form__submit" type="submit">Logar</button>
                
            </form>
        
        </section>

    </main>