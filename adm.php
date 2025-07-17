<?php
include 'conexao.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ================== Agendamentos ==================
$agendamentos = $conn->query("
    SELECT a.id, a.cliente_nome, a.telefone, a.data, a.hora,
           b.nome AS barbeiro, s.nome AS servico
    FROM agendamentos a
    JOIN barbeiros b ON a.barbeiro_id = b.id
    JOIN servicos s ON a.servico_id = s.id
    ORDER BY a.data, a.hora
");

// ================== Postar SERVIÇO ==================
if (isset($_POST['postar_servico'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = '';

    if ($_FILES['imagem']['name']) {
        $caminho = 'uploads/' . basename($_FILES['imagem']['name']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
        $imagem = $caminho;
    }

    $stmt = $conn->prepare("INSERT INTO servico (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagem);
    $stmt->execute();
}

// ================== Postar SERVIÇO REALIZADO ==================
if (isset($_POST['postar_realizado'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_servico = $_POST['data_servico'] ?: date('Y-m-d');
    $imagem = '';

    if ($_FILES['imagem_realizado']['name']) {
        $caminho = 'uploads/' . basename($_FILES['imagem_realizado']['name']);
        move_uploaded_file($_FILES['imagem_realizado']['tmp_name'], $caminho);
        $imagem = $caminho;
    }

    $stmt = $conn->prepare("INSERT INTO servicos_realizados (titulo, descricao, imagem, data_servico) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $descricao, $imagem, $data_servico);
    $stmt->execute();
}

// ================== Listagens ==================
$servicos = $conn->query("SELECT * FROM servico ORDER BY id DESC");
$realizados = $conn->query("SELECT * FROM servicos_realizados ORDER BY data_servico DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel da Barbearia</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background: #111;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 28px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }

        section {
            margin-bottom: 50px;
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }

        h2 {
            margin-top: 0;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #222;
            color: white;
        }

        form input, form textarea, form select, form button {
            padding: 10px;
            width: 100%;
            margin: 8px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        form button {
            background-color: #111;
            color: white;
            cursor: pointer;
        }

        img {
            max-width: 300px;
            border-radius: 8px;
        }

        .postagem {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>Painel da Barbearia</header>

<div class="container">

    <!-- ========== AGENDAMENTOS ========== -->
    <section>
        <h2>Agendamentos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Telefone</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Barbeiro</th>
                <th>Serviço</th>
            </tr>
            <?php while ($row = $agendamentos->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td><?= date('H:i', strtotime($row['hora'])) ?></td>
                    <td><?= htmlspecialchars($row['barbeiro']) ?></td>
                    <td><?= htmlspecialchars($row['servico']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- ========== POSTAR NO CATÁLOGO ========== -->
<section>
    <h2>Postar No catálogo</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="postar_servico" value="1">
        
        <label>Nome do Serviço:</label>
        <input type="text" name="nome" required>
        
        <label>Descrição:</label>
        <textarea name="descricao"></textarea>
        
        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" required>
        
        <label>Imagem:</label>
        <input type="file" name="imagem">
        
        <button type="submit">Salvar Serviço</button>
    </form>

    <h3 style="margin-top: 40px;">Serviços Cadastrados</h3>
    <?php while ($s = $servicos->fetch_assoc()): ?>
        <div class="postagem">
            <h4><?= htmlspecialchars($s['nome']) ?> — R$<?= number_format($s['preco'], 2, ',', '.') ?></h4>
            <p><?= nl2br(htmlspecialchars($s['descricao'])) ?></p>
            <?php if (!empty($s['imagem']) && file_exists($s['imagem'])): ?>
                <img src="<?= htmlspecialchars($s['imagem']) ?>" alt="<?= htmlspecialchars($s['nome']) ?>" style="max-width: 300px;">
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</section>


    <!-- ========== POSTAR SERVIÇO REALIZADO ========== -->
    <section>
        <h2>Postar Serviço Realizado</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="postar_realizado" value="1">
            Título:
            <input type="text" name="titulo" required>
            Descrição:
            <textarea name="descricao"></textarea>
            Data do Serviço:
            <input type="date" name="data_servico">
            Imagem:
            <input type="file" name="imagem_realizado" required>
            <button type="submit">Salvar Serviço Realizado</button>
        </form>

        <h3 style="margin-top: 40px;">Serviços Realizados</h3>
        <?php while ($r = $realizados->fetch_assoc()): ?>
            <div class="postagem">
                <h4><?= htmlspecialchars($r['titulo']) ?> (<?= date("d/m/Y", strtotime($r['data_servico'])) ?>)</h4>
                <p><?= nl2br(htmlspecialchars($r['descricao'])) ?></p>
                <img src="<?= $r['imagem'] ?>">
            </div>
        <?php endwhile; ?>
    </section>

</div>
</body>
</html>
