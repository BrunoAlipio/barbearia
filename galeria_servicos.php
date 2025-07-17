<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="galeria.css">
    <link rel="shortcut icon" href="img/best in town.png" type="image/x-icon">
    <title>Serviços Realizados</title>
</head>
<body>
    <nav>
        <div class="nav-menu-container">
            <img class="logo" src="img/best in town.png" alt="Logo"> <!-- Logo alinhada à esquerda -->
            <ul id="navMenu">
                <li class="nav-item"><a href="index.html">Menu</a></li>
                <li class="nav-item"><a href="agendamento.php">Agendamento</a></li>
                <li class="nav-item"><a href="catalogo.php">Catálogo</a></li>
            </ul>
        </div>
    </nav>

<main>

<h1>Serviços Realizados</h1>

<div class="galeria">
    <?php
    $res = $conn->query("SELECT * FROM servicos_realizados ORDER BY data_servico DESC");
    while ($s = $res->fetch_assoc()) {
        $img = $s['imagem']; // caminho salvo no banco (ex: uploads/nome.jpg)
        echo "<div class='item'>";
        if (!empty($img) && file_exists($img)) {
            echo "<img src='" . htmlspecialchars($img) . "' alt='" . htmlspecialchars($s['titulo']) . "'>";
        } else {
            echo "<img src='img/imagem-padrao.jpg' alt='Imagem padrão'>";
        }
        echo "<div class='info'>";
        echo "<h2>" . htmlspecialchars($s['titulo']) . "</h2>";
        if (!empty($s['descricao'])) {
            echo "<p>" . nl2br(htmlspecialchars($s['descricao'])) . "</p>";
        }
        echo "<div class='data'>" . date('d/m/Y', strtotime($s['data_servico'])) . "</div>";
        echo "</div></div>";
    }
    ?>
</div>

</main>

<footer>
    &copy;BarberShop. Todos os direiros reservados
</footer>

</body>
</html>
