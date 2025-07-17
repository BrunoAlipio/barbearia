<?php
include 'conexao.php';

$data = $_POST['data'];
$hora = $_POST['hora'];
$barbeiro_id = $_POST['barbeiro_id'];
$cliente_nome = $_POST['cliente_nome'];
$telefone = $_POST['telefone'];
$servico_id = $_POST['servico_id'];

// Validação básica
if (!$data || !$hora || !$barbeiro_id || !$cliente_nome || !$telefone || !$servico_id) {
    echo "Todos os campos são obrigatórios.";
    exit;
}

// Verificar se o horário já está ocupado
$stmt = $conn->prepare("SELECT id FROM agendamentos WHERE data = ? AND hora = ? AND barbeiro_id = ?");
$stmt->bind_param("ssi", $data, $hora, $barbeiro_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Este horário já foi agendado. Por favor, escolha outro.";
    exit;
}

// Inserir agendamento
$stmt = $conn->prepare("INSERT INTO agendamentos (cliente_nome, telefone, servico_id, barbeiro_id, data, hora) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiss", $cliente_nome, $telefone, $servico_id, $barbeiro_id, $data, $hora);
$stmt->execute();

echo "Agendamento realizado com sucesso!";
?>
