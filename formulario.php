<?php
require ("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Cadastro de Usuário </title>
  <link rel="stylesheet" href="src/menu.css">
  <link rel="stylesheet" href="src/login.css">
  <link rel="stylesheet" href="src/formulario.css">
</head>
<body>
  <header> 
      <div class="caixa">
         <h1><img src="Imagem/logo.png"></h1>
         
         <nav>
          <ul>
             <li><a href="index.html">Home</a></li>
             <li><a href="sobrenos.php">Sobre nós</a></li>
             <li><a href="projeto.php">Projeto</a></li>
             <li><a href="calculadora.php">Calculadora</a></li>
             <li><a href="login.php" >Login</a></li>
            </ul>
         </nav>
      </div>
  </header>

    <div class="fundo">
      <div class="tabela">
        <div class="quadro-login">
                  
                <h1>Cadastro de Usuário</h1>

                 <!--o metodo POST envia das informações para o banco de dados-->
                 <form method="POST" action="cadastro.php">

                <!--Campo de digitação do Nome do usuario-->
                <div class="campo-texto">
                    <label for="usuario">Nome</label>                      
                    <input type="text" name="nome" id="nome"> <!--Id Nome faz referencia a coluna do banco de dados Nome-->
                </div>

                <!--Campo de digitação do Email do usuario-->
                <div class="campo-texto">
                  <label for="usuario">Email</label>
                  <input type="text" name="email" id="email">
                </div>
                
                <!--Campo de digitação do Login do usuario-->
                <div class="campo-texto">
                  <label for="usuario">Login</label>
                  <input type="text" name="usuario" id="usuario">
                </div>
                
                <!--Campo de digitação do Senha do usuario-->
                <div class="campo-texto"> 
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha">
                </div>

                 <!--Checkbox de aceitação do termo-->
                <input type="checkbox" name="termos" required>
                    Eu concordo com os <a href="termos.html" target="_blank">Termos de Uso</a> e a <a href="politicaprivacidade.html" target="_blank">Política de Privacidade</a>.

                <!--Armazenar os dados inserido acima do usuario na tabela-->                  
                <input class="botao" href="login.php" type="submit" value="cadastrar" id="cadastrar" name="cadastrar">
                
                <!--Link para direcionar para outras telas-->  
                <a class="texto" href="login.html" >Deseja fazer o login?</a>               
                <a class="texto" href="esqueceu.html" >Esqueceu a senha?</a>  
              </div>

             <div>
              <h2><img style="width: 500px" src="Imagem/login.png"></h2>
             </div>
        </div>
      </form>

      <footer>
          <p>&copy; 2024 Techshizen. Todos os direitos reservados.</p>
          <p><a href="termos.html">Termos de Uso</a> & <a href="politicaprivacidade.html">Política de Privacidade</a></p>
        </footer>
    </div>
    
    
    <!--Verifica se o Checkbox de aceitação do termo foi aceito -->  
    <script>
        function validarTermos() {
            const termosCheckbox = document.getElementById('termos');
            if (!termosCheckbox.checked) {
                alert('Você deve aceitar os Termos de Uso para continuar.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

