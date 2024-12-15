<?php
header('Content-Type: application/json');

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'seu_banco';
$username = 'seu_usuario';
$password = 'sua_senha';

try {
    // Conexão com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Pegar o mês selecionado da URL e o usuário do cookie
    $mes_selecionado = isset($_GET['mes']) ? $_GET['mes'] : date('m-Y');
    $usuario = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
    
    if (!$usuario) {
        throw new Exception('Usuário não está logado');
    }
    
    // Consulta SQL
    $query = "SELECT 
                eletrodomestico,
                quantidade,
                tempo_uso_horas,
                tempo_uso_unidade,
                potencia,
                consumo_kwh,
                DATE_FORMAT(data_cadastro, '%d/%m/%Y') as data_cadastro
              FROM historico_consumo 
              WHERE usuario = ? AND mes_ano = ?
              ORDER BY data_cadastro DESC";
              
    $stmt = $pdo->prepare($query);
    $stmt->execute([$usuario, $mes_selecionado]);
    
    // Buscar todos os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Retornar os dados como JSON
    echo json_encode($resultados);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
?>