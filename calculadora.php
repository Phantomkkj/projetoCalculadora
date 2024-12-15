<?php

require("conexao.php"); // Conexão com o banco

// Verifica se o usuário está logado
$login_cookie = isset($_COOKIE["login"]) ? $_COOKIE["login"] : null;

if (!$login_cookie) {
    header("Location: avisoLogin.php");
    exit;
}

// Função para gerar os últimos 12 meses
function gerarUltimos12Meses() {
    $meses = array();
    for ($i = 0; $i < 12; $i++) {
        $data = date('m-Y', strtotime("-$i months"));
        $meses[] = $data;
    }
    return $meses;
}

// Busca os dados do histórico no banco
$historico = [];
if (isset($_POST['mes-select'])) {
    $mesSelecionado = $_POST['mes-select'];
    $mesAno = explode("-", $mesSelecionado);
    $mes = $mesAno[0];
    $ano = $mesAno[1];

    $query = "SELECT * FROM historico_consumo WHERE MONTH(data_cadastro) = ? AND YEAR(data_cadastro) = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ii", $mes, $ano);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $historico[] = $row;
    }
    $stmt->close();
}

// Adiciona o custo total ao histórico
foreach ($historico as &$item) {
    $item['custo_total'] = $item['consumo_kwh'] * $item['tarifa'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simulação de Consumo de Energia</title>
  <link rel="stylesheet" href="src/menu.css">
  <link rel="stylesheet" href="src/style.css">
  <link rel="stylesheet" href="src/somos.css">
  <link rel="stylesheet" href="src/simulacaoConsumo.css">
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
             <li><a id="btn-Sair">Sair</a></li>
          </ul>
         </nav>
      </div>
  </header>

  <div class="header-container">
    <h1>Simulação de Consumo de Energia</h1>
    <p>Bem-vindo, <strong><?php echo htmlspecialchars($login_cookie); ?></strong></p>
  </div>
  
  <main>
      <!-- Botão para adicionar aparelho pré-cadastrado -->
      <div class="container">
          <div class="appliance" data-name="Video Game">
              <img src="Imagem/eletro/1.JPEG" alt="Video Game">
              <p>Video Game</p>
          </div>
          <div class="appliance" data-name="Lampada">
              <img src="Imagem/eletro/2.JPEG" alt="Lampada">
              <p>Lampâda</p>
          </div>
          <div class="appliance" data-name="Geladeira">
              <img src="Imagem/eletro/3.JPEG" alt="Geladeira">
              <p>Geladeira</p>
          </div>
          <div class="appliance" data-name="Maquina de Lavar">
              <img src="Imagem/eletro/4.JPEG" alt="Maquina de Lavar">
              <p>Maquina de Lavar</p>
          </div>
          <div class="appliance" data-name="Sala">
              <img src="Imagem/eletro/sala.JPEG" alt="Sala">
              <p>Sala</p>
          </div>
          <div class="appliance" data-name="Quarto">
              <img src="Imagem/eletro/quarto.JPEG" alt="Quarto">
              <p>Quarto</p>
          </div>
          <div class="appliance" data-name="Banheiro">
              <img src="Imagem/eletro/banheiro.JPEG" alt="Banheiro">
              <p>Banheiro</p>
          </div>
      </div>

      <!-- Botão para adicionar aparelho inexistente -->
      <button id="btn-adicionar">Adicionar aparelho inexistente</button>

      <!-- Modal para adicionar aparelho pré-cadastrado -->
      <div id="modal-pre-cadastrado" class="modal">
          <div class="modal-content">
              <span class="close">&times;</span>
              <h2 id="modal-title"></h2>
              
              <form id="form-pre-cadastrado" method="POST" action="processar.php">
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <div class="input-tooltip">
                            <input type="number" id="quantidade" name="quantidade" required min="1">
                            <span class="tooltip-text">Informe a quantidade de aparelhos</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tempo_uso_horas">Tempo de uso:</label>
                        <div class="input-tooltip">
                            <select id="tempo_uso_unidade" name="tempo_uso_unidade" required>
                                <option value="horas">Horas por dia</option>
                                <option value="minutos">Minutos por dia</option>
                            </select>
                            <input type="number" id="tempo_uso_horas" name="tempo_uso_horas" required min="0" max="1440">
                            <span class="tooltip-text">Informe quantas horas ou minutos por dia o aparelho fica ligado</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="potencia">Potência (W):</label>
                        <input type="number" id="potencia" name="potencia" step="0.01" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="tarifa-kwh">Tarifa (R$/kWh):</label>
                        <div class="input-tooltip">
                            <input type="number" id="tarifa-kwh" name="tarifa-kwh" step="0.01" required min="0">
                            <span class="tooltip-text">Informe o valor da tarifa por kWh</span>
                        </div>
                    </div>

                    <input type="hidden" id="eletrodomestico" name="eletrodomestico">

                    <button type="submit">Adicionar Aparelho</button>
              </form>
          
            </div>
      </div>

      <!-- Modal para adicionar aparelho inexistente -->
      <div id="modal-inexistente" class="modal">
          <div class="modal-content">
              <span class="close">&times;</span>
              <h2>Adicionar novo aparelho</h2>
              
                <form id="form-inexistente" method="POST" action="processar.php">
                    <div class="form-group">
                        <label for="nome-aparelho">Nome do aparelho:</label>
                        <div class="input-tooltip">
                            <input type="text" id="nome-aparelho" name="nome-aparelho" required min="1">
                            <span class="tooltip-text">Informe o nome do aparelhos</span>
                        </div>
                    </div>

                  <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <div class="input-tooltip">
                            <input type="number" id="quantidade" name="quantidade" required min="1">
                            <span class="tooltip-text">Informe a quantidade de aparelhos</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tempo_uso_horas">Tempo de uso:</label>
                        <div class="input-tooltip">
                            <select id="tempo_uso_unidade" name="tempo_uso_unidade" required>
                                <option value="horas">Horas por dia</option>
                                <option value="minutos">Minutos por dia</option>
                            </select>
                            <input type="number" id="tempo_uso_horas" name="tempo_uso_horas" required min="0" max="1440">
                            <span class="tooltip-text">Informe quantas horas ou minutos por dia o aparelho fica ligado</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="potencia">Potência (W):</label>
                        <div class="input-tooltip">
                            <input type="number" id="potencia" name="potencia" required min="1">
                            <span class="tooltip-text">Informe a potência de aparelhos</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tarifa-kwh">Tarifa (R$/kWh):</label>
                        <div class="input-tooltip">
                            <input type="number" id="tarifa-kwh" name="tarifa-kwh" step="0.01" required min="0">
                            <span class="tooltip-text">Informe o valor da tarifa por kWh</span>
                        </div>
                    </div>

                  <button type="submit">Adicionar</button>
              </form>
          </div>
      </div>

      <!-- Tabela de Histórico de Consumo -->
      <div class="container">
        <h1>Histórico de Consumo</h1>
        <form method="POST">
            <label for="mes-select">Selecione o mês:</label>
            <select id="mes-select" name="mes-select">
                <?php
                foreach (gerarUltimos12Meses() as $mes) {
                    $selected = (isset($_POST['mes-select']) && $_POST['mes-select'] === $mes) ? 'selected' : '';
                    echo "<option value='$mes' $selected>$mes</option>";
                }
                ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nome do Aparelho</th>
                    <th>Consumo (kWh)</th>
                    <th>Tarifa (R$)</th>
                    <th>Custo Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historico)) : ?>
                    <?php foreach ($historico as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['data_cadastro']); ?></td>
                            <td><?php echo htmlspecialchars($item['eletrodomestico']); ?></td>
                            <td><?php echo htmlspecialchars($item['consumo_kwh']); ?></td>
                            <td><?php echo htmlspecialchars($item['tarifa']); ?></td>
                            <td><?php echo htmlspecialchars($item['custo_total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Nenhum registro encontrado para o mês selecionado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <footer>
          <p>&copy; 2024 Techshizen. Todos os direitos reservados.</p>
          <p><a href="termos.html">Termos de Uso</a> & <a href="politicaprivacidade.html">Política de Privacidade</a></p>
        </footer>
  </main>

  <script>
      const appliances = document.querySelectorAll('.appliance');
      const modalPreCadastrado = document.getElementById('modal-pre-cadastrado');
      const modalInexistente = document.getElementById('modal-inexistente');
      const modalTitle = document.getElementById('modal-title');
      const potenciaInput = document.getElementById('potencia');
      const closeButtons = document.querySelectorAll('.close');
      const btnAdicionar = document.getElementById('btn-adicionar');

      appliances.forEach(appliance => {
          appliance.addEventListener('click', () => {
              const name = appliance.dataset.name;
              const potencia = appliance.dataset.power;

              modalTitle.textContent = name;
              document.getElementById('eletrodomestico').value = name;
              potenciaInput.value = potencia;
              modalPreCadastrado.style.display = 'block';
          });
      });

      btnAdicionar.addEventListener('click', () => {
          modalInexistente.style.display = 'block';
      });

      closeButtons.forEach(button => {
          button.addEventListener('click', () => {
              modalPreCadastrado.style.display = 'none';
              modalInexistente.style.display = 'none';
          });
      });

      window.addEventListener('click', (event) => {
          if (event.target === modalPreCadastrado) {
              modalPreCadastrado.style.display = 'none';
          }
          if (event.target === modalInexistente) {
              modalInexistente.style.display = 'none';
          }
      });


        // Historico de consumo
        function buscarHistorico() {
            const mes = document.getElementById('mes-select').value;
            const tbody = document.getElementById('historico-tbody');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('error-message');

            // Mostrar loading e esconder mensagem de erro
            loading.style.display = 'block';
            errorMessage.style.display = 'none';
            tbody.innerHTML = '';

            fetch(`buscar_historico.php?mes=${mes}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar dados');
                    }
                    return response.json();
                })
                .then(data => {
                    loading.style.display = 'none';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="6" class="no-records">
                                    Nenhum registro encontrado para o mês selecionado
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    const html = data.map(item => `
                        <tr>
                            <td>${item.eletrodomestico}</td>
                            <td>${item.quantidade}</td>
                            <td>${item.tempo_uso_horas} ${item.tempo_uso_unidade}</td>
                            <td>${item.potencia}</td>
                            <td>${parseFloat(item.consumo_kwh).toFixed(2)}</td>
                            <td>${item.data_cadastro}</td>
                        </tr>
                    `).join('');

                    tbody.innerHTML = html;
                })
                .catch(error => {
                    loading.style.display = 'none';
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Erro ao carregar o histórico. Por favor, tente novamente.';
                    console.error('Erro:', error);
                });
        }

        // Carregar o histórico assim que a página for carregada
        document.addEventListener('DOMContentLoaded', buscarHistorico);

        
        // Sair do login
        document.getElementById('btn-Sair').addEventListener('click', () => {
        // Remover o cookie de login
         document.cookie = "login=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
        // Redirecionar para a página inicial
        window.location.href = 'index.html';
});
</script>
</body>
</html>

