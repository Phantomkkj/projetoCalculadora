<?php
require("conexao.php"); // Conexão com o banco

// Verifica se o usuário está logado
$login_cookie = isset($_COOKIE["login"]) ? $_COOKIE["login"] : null;

if (!$login_cookie) {
    header("Location: avisoLogin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $login_cookie; // Use o login do cookie
    $eletrodomestico = $_POST['nome-aparelho'] ?? $_POST['eletrodomestico']; 
    $quantidade = (int)$_POST['quantidade'];
    $tempo_uso_horas = (int)$_POST['tempo_uso_horas'];
    $tempo_uso_unidade = $_POST['tempo_uso_unidade'] ?? 'horas'; // Nova linha
    $potencia = (int)$_POST['potencia'];

    // Converter minutos para horas se necessário
    if ($tempo_uso_unidade == 'minutos') {
        $tempo_uso_horas = $tempo_uso_horas / 60;
    }

    $tarifa = !empty($_POST['tarifa-kwh']) ? floatval(str_replace(',', '.', $_POST['tarifa-kwh'])) : 0;

    $consumo_kwh = ($quantidade * $tempo_uso_horas * $potencia) / 1000;
    $custo_total = $consumo_kwh * $tarifa;
    $mes_ano = date('m-Y');

    $sql = "INSERT INTO historico_consumo (usuario, eletrodomestico, quantidade, tempo_uso_horas, tempo_uso_unidade, potencia, consumo_kwh, tarifa, mes_ano) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        'ssiisidds',
        $usuario,
        $eletrodomestico,
        $quantidade,
        $tempo_uso_horas,
        $tempo_uso_unidade,
        $potencia,
        $consumo_kwh,
        $tarifa,
        $mes_ano
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Aparelho adicionado com sucesso!');
              </script>
              <meta http-equiv='refresh' content='0, url=calculadora.php'>";
    } else {
        echo "Erro ao adicionar: " . $stmt->error;
    }

    $stmt->close();
}
?>