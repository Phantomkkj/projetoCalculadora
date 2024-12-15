<?php
require("conexao.php"); // Conexão com o banco

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];

// Valida se os campos foram preenchidos
if (isset($_POST["entrar"])) {
    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $usuario, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Define o cookie de login com tempo de expiração
            setcookie("login", $usuario, time() + (86400 * 30), "/"); // 30 dias
            header("Location: calculadora.php");
            exit;
        } else {
            // Usuário ou senha inválidos
            echo "<script>
                    alert('Usuário ou senha incorretos');
                    window.location.href='login.php';
                  </script>";
        }
    } else {
        echo "Erro na consulta ao banco de dados: " . $conexao->error;
    }
}
?>