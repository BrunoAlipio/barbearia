<?php 
include 'conexao.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agenda.css">
    <link rel="shortcut icon" href="img/best in town.png" type="image/x-icon">
    <title>BarberShop</title>
</head>
<body>
    <nav>
        <div class="nav-menu-container">
            <img class="logo" src="img/best in town.png" alt="Logo">
            <ul id="navMenu">
                <li class="nav-item"><a href="index.html">Menu</a></li>
                <li class="nav-item"><a href="catalogo.php">Catálogo</a></li>
                <li class="nav-item"><a href="galeria_servicos.php">Galeria</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <h1>Agende seu Horário</h1>
        <form onsubmit="return validarData()" action="salvar_agendamento.php" method="POST">
            <label>Seu nome:</label>
            <input type="text" name="cliente_nome" required autocomplete="off"><br>

            <label>Telefone:</label>
            <input type="tel" name="telefone" required><br>

            <label>Serviço:</label>
            <select name="servico_id" required>
                <?php
                $res = $conn->query("SELECT * FROM servicos ORDER BY nome");
                while($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select><br>

            <label>Barbeiro:</label>
            <select name="barbeiro_id" required>
                <?php
                $res = $conn->query("SELECT * FROM barbeiros ORDER BY nome");
                while($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select><br>

            <label>Escolha a data:</label>
            <div id="dias" style="display: flex; gap: 10px; margin-bottom: 10px; overflow-x: scroll;"></div>
            <input type="hidden" name="data" id="data" required>

            <label>Hora:</label>
            <select name="hora" id="hora" required>
                <option value="">Selecione a data e o barbeiro</option>
            </select><br>

            <button type="submit">Agendar</button>
        </form>
    </main>

    <script src="agenda.js"></script>

    <footer>
        &copy;BarberShop. Todos os direiros reservados
    </footer>
</body>
</html>
