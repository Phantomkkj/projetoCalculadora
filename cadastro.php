<?php 

require("conexao.php");

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos necessários estão presentes e não vazios
    $nome = isset($_POST['nome']) ? htmlspecialchars(trim($_POST['nome'])) : null;
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
    $usuario = isset($_POST['usuario']) ? htmlspecialchars(trim($_POST['usuario'])) : null;
    $senha = isset($_POST['senha']) ? htmlspecialchars(trim($_POST['senha'])) : null;

    // Verifica se todos os campos foram preenchidos
    if ($nome && $email && $usuario && $senha) {
        // Verifica se o login (usuário) já existe no banco de dados
        $sqlCheck = "SELECT id FROM usuarios WHERE usuario = ?";
        $stmtCheck = $conexao->prepare($sqlCheck);

        if ($stmtCheck) {
            $stmtCheck->bind_param("s", $usuario);
            $stmtCheck->execute();
            $stmtCheck->store_result();

            if ($stmtCheck->num_rows > 0) {
                // Usuário já existe
                echo "<script>
                        alert('Já existe um usuário cadastrado com esse login.');
                      </script>
                      <meta http-equiv='refresh' content='0, url=formulario.php'>";
            } else {
                // Prepara a consulta SQL para inserção
                $sql = "INSERT INTO usuarios (nome, email, usuario, senha) VALUES (?, ?, ?, ?)";
                $stmt = $conexao->prepare($sql);

                // Verifica se a preparação foi bem-sucedida
                if ($stmt) {
                    // Associa os parâmetros
                    $stmt->bind_param("ssss", $nome, $email, $usuario, $senha);

                    // Executa a consulta
                    if ($stmt->execute()) {
                        echo "<script>
                                alert('Usuário cadastrado com sucesso.');
                              </script>
                              <meta http-equiv='refresh' content='0, url=login.php'>";
                    } else {
                        echo "Erro ao cadastrar: " . $stmt->error;
                    }

                    // Fecha a declaração
                    $stmt->close();
                } else {
                    echo "Erro na preparação da consulta: " . $conexao->error;
                }
            }

            // Fecha a declaração de verificação
            $stmtCheck->close();
        } else {
            echo "Erro na preparação da verificação: " . $conexao->error;
        }
    } else {
        echo "<script>
                alert('Por favor, preencha todos os campos.');
              </script>
              <meta http-equiv='refresh' content='0, url=formulario.php'>";
    }
} else {
    echo "<script>
            alert('Requisição inválida. Acesse pelo formulário.');
          </script>
          <meta http-equiv='refresh' content='0, url=formulario.php'>";
}

?>
