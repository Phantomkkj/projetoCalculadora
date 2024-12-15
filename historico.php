<?php
// Conexão ao banco de dados
require("teste.php");

// Verificar se o mês foi selecionado
$mesSelecionado = isset($_GET['mes']) ? $_GET['mes'] : date('m-Y');

// Consulta para buscar o histórico
$usuario = 'exemplo_usuario'; // Aqui você deve passar o ID ou nome do usuário autenticado
$sql = "SELECT eletrodomestico, quantidade, tempo_uso_horas, tempo_uso_unidade, potencia, consumo_kwh, data_cadastro FROM historico_consumo WHERE usuario = ? AND mes_ano = ?";


// Preparar e executar a consulta
$stmt = $conexao->prepare($sql);
$stmt->bind_param('ss', $usuario, $mesSelecionado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['eletrodomestico']}</td>
            <td>{$row['quantidade']}</td>
            <td>{$row['tempo_uso_horas']} {$row['tempo_uso_unidade']}</td>
            <td>{$row['potencia']}</td>
            <td>{$row['consumo_kwh']}</td>
            <td>{$row['data_cadastro']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nenhum registro encontrado para o mês selecionado.</td></tr>";
}
?>