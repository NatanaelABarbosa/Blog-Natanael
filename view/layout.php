<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Blog</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Blog de Natanael Barbosa</h1>
        <a href="/logout">Sair</a>
    </header>

    <?php if (isset($_SESSION['flash_message'])): ?>
    <h2 class="error_message">
        <?= $_SESSION['flash_message'] ?>
        <?php unset($_SESSION['flash_message']); ?>
    </h2>
    <?php endif ?>

    <?= $this->section('content'); ?>

    <footer>
        <p>&copy; 2024 Blog de Natanael Barbosa</p>
    </footer>
</body>
</html>