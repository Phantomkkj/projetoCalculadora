Create table usuarios (
ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
nome Varchar(30), --Armazenará o nome digitado no campo "Nome" do formulário
email Varchar(30), --Armazenará o nome digitado no campo "Email" do formulário
usuario Varchar(30), --Armazenará o nome digitado no campo "Login" do formulário
senha Varchar(40), --Armazenará o valor da variável senha
Primary Key (ID)) ENGINE = MyISAM; --Armazena um código único de usuário, gerado cada vez que alguém se cadastra



Create table usuarios (
ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
nome Varchar(30), 
email Varchar(30), 
usuario Varchar(30), 
senha Varchar(40), 
Primary Key (ID)) ENGINE = MyISAM;