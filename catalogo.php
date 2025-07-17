<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="catalogo.css">
    <link rel="shortcut icon" href="img/best in town.png" type="image/x-icon">
    <title>Catálogo de Serviços</title>
</head>
<body>
    <nav>
        <div class="nav-menu-container">
            <img class="logo" src="img/best in town.png" alt="Logo"> <!-- Logo alinhada à esquerda -->
            <ul id="navMenu">
                <li class="nav-item"><a href="index.html">Menu</a></li>
                <li class="nav-item"><a href="agendamento.php">Agendamento</a></li>
                <li class="nav-item"><a href="galeria_servicos.php">Galeria</a></li>
            </ul>
        </div>
    </nav>

<main>

<h1>Catálogo de Serviços</h1>

<div class="catalogo">
    <?php
    $res = $conn->query("SELECT * FROM servico ORDER BY id");
    while ($servico = $res->fetch_assoc()) {
        // Usar o caminho armazenado no banco diretamente
        $img = !empty($servico['imagem']) && file_exists($servico['imagem']) 
            ? $servico['imagem'] 
            : "img/default.jpg"; // imagem padrão caso não exista
        echo "<div class='card-servico'>";
        echo "<img src='".htmlspecialchars($img)."' alt='".htmlspecialchars($servico['nome'])."'>";
        echo "<h2>".htmlspecialchars($servico['nome'])."</h2>";
        echo "<div class='descricao'>".nl2br(htmlspecialchars($servico['descricao']))."</div>";
        echo "<div class='preco'>R$ " . number_format($servico['preco'], 2, ',', '.') . "</div>";
        echo "</div>";
    }
    ?>
</div>

</main>

<footer>
    &copy;BarberShop. Todos os direiros reservados
</footer>
</body>
</html>
