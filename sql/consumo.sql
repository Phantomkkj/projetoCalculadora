CREATE TABLE historico_consumo (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único da tabela, com incremento automático.
    usuario VARCHAR(255) NOT NULL, -- Nome ou identificação do usuário relacionado ao consumo.
    eletrodomestico VARCHAR(255) NOT NULL, -- Nome do eletrodoméstico utilizado (ex: Geladeira, TV).
    quantidade INT NOT NULL, -- Quantidade de eletrodomésticos do mesmo tipo.
    tempo_uso_horas INT NOT NULL, -- Tempo de uso em horas (inteiro, para cálculos).
    tempo_uso_unidade VARCHAR(10) NOT NULL DEFAULT 'horas', -- Unidade de tempo usada (ex: 'horas', 'dias'), com valor padrão 'horas'.
    potencia INT NOT NULL, -- Potência do eletrodoméstico em Watts (W).
    consumo_kwh DECIMAL(10, 2) NOT NULL, -- Consumo total em kWh calculado (potência * tempo de uso).
    tarifa DECIMAL(10, 2) NOT NULL, -- Tarifa por kWh aplicada para cálculo do custo.
    mes_ano VARCHAR(7) NOT NULL, -- Mês e ano do registro, no formato 'MM/YYYY'.
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora de registro do histórico, preenchida automaticamente.
    custo_total DECIMAL(10, 2) -- Custo total calculado (consumo_kwh * tarifa).
);


CREATE TABLE historico_consumo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    eletrodomestico VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    tempo_uso_horas INT NOT NULL,
    tempo_uso_unidade VARCHAR(10) NOT NULL DEFAULT 'horas',
    potencia INT NOT NULL,
    consumo_kwh DECIMAL(10, 2) NOT NULL,
    tarifa DECIMAL(10, 2) NOT NULL,
    mes_ano VARCHAR(7) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    custo_total DECIMAL(10, 2)
);
