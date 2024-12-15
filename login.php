<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Techshizen</title>
  <link rel="stylesheet" href="src/menu.css">
  <link rel="stylesheet" href="src/login.css">
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

    <div class="fundo" >
      <div class="tabela">

            <div class="quadro-login">
                <h1>LOGIN</h1>
                
                <form method="POST" action="verificarLogin.php">
                <div class="campo-texto">
                    <label for="usuario">Login</label>
                    <input type="text" name="usuario" id="usuario">
                </div>


                <div class="campo-texto"> 
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha">
                </div>
                
               
                <input class="botao" href="teste2.php" type="submit" value="entrar" id="entrar" name="entrar">
                                
                <a class="texto" href="esqueceu.html" >Esqueceu a senha?</a>               
                <a class="texto" href="formulario.php">Não possui uma conta? Cadastre-se</a>
                
            </form>
            </div>    
            
            <div>
                <h2><img style="width: 500px" src="Imagem/login.png"></h2>
            </div>

        </div>
        
        <footer>
            <p>&copy; 2024 Techshizen. Todos os direitos reservados.</p>
            <p><a href="termos.html">Termos de Uso</a> & <a href="politicaprivacidade.html">Política de Privacidade</a></p>
        </footer>

    </div>
    
</body>
</html>