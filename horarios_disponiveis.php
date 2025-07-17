<?php
include 'conexao.php';

$data = $_GET['data'];
$barbeiro_id = $_GET['barbeiro_id'];

$horarios = [
    '09:00', '10:00', '11:00', '12:00',
    '13:00', '14:00', '15:00', '16:00',
    '17:00', '18:00'
];

$stmt = $conn->prepare("SELECT hora FROM agendamentos WHERE data = ? AND barbeiro_id = ?");
$stmt->bind_param("si", $data, $barbeiro_id);
$stmt->execute();
$result = $stmt->get_result();

$horarios_ocupados = [];
while ($row = $result->fetch_assoc()) {
    $horarios_ocupados[] = $row['hora'];
}

$disponiveis = array_diff($horarios, $horarios_ocupados);

header('Content-Type: application/json');
echo json_encode(array_values($disponiveis));
