/*retirei a tabela de usuario e login, será gerenciado pelo framework por questões de segurança e tempo*/
/*mysql -u mabrit05_site -p -h ns818.hostgator.com.br*/
CREATE TABLE clientes (
    id_cliente int NOT NULL AUTO_INCREMENT,
    registro varchar(20),
    nome varchar(100),
    dtnascto datetime,
    rg varchar(10),
    cpf varchar(12),
    dtaltera datetime,
    situacao char(1),
    PRIMARY KEY (id_cliente)
);

CREATE TABLE produtos (
    id_produto int NOT NULL AUTO_INCREMENT,
    nome varchar(100),
    image_path varchar(255),
    descricao varchar(200),
	  preco_custo float(5,2),
    preco_venda float(5,2),
    situacao char(1),
    PRIMARY KEY (id_produto)
);

/*criei a relação de 1 para muitos, entre cliente e alunos, como Flávio havia sugerido
 *Um cliente pode acessar varios alunos (caso deixemos varios clientes para varios alunos ficará bem mais complexo)*/
CREATE TABLE alunos (
    id_aluno int NOT NULL AUTO_INCREMENT,
    id_cliente int,
    nome varchar(100),
    saldo numeric(8,2),
    PRIMARY KEY (id_aluno),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

/* aqui só adequei a tabela as alterações anteriores*/
CREATE TABLE credito_clientes (
    id_credito_cliente int NOT NULL AUTO_INCREMENT,
    dtpagamento datetime,
    valor float(8,2),
    situacao char(1),
    id_cliente int,
    id_aluno int,
    PRIMARY KEY (id_credito_cliente),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);

/*só coloquei a coluna id_aluno para relacionar com os créditos do aluno como foi feito na tabela credito_clientes */
CREATE TABLE vendas (
    id_venda int NOT NULL AUTO_INCREMENT,
    dtvenda datetime,
    total float(8,2),
    situacao char(1),
    id_cliente int,
    id_aluno int,
    PRIMARY KEY (id_venda),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);

CREATE TABLE item_vendas (
    id_item_venda int NOT NULL AUTO_INCREMENT,
    dtpagamento datetime,
    quantidade float(8,2),
    preco_unit float(8,2),
    id_venda int,
    id_produto int,
    PRIMARY KEY (id_item_venda),
    FOREIGN KEY (id_venda) REFERENCES vendas(id_venda),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

CREATE TABLE restricoes_produtos(
  id_restricao INT PRIMARY KEY AUTO_INCREMENT,
  id_produto int,
  id_cliente int,
  id_aluno int,
  ativo int,
  descricao varchar(100),
  FOREIGN KEY (id_produto) REFERENCES produtos(id_produto),
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
  FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);

CREATE TABLE promocao_diaria (
  id_promocao INT NOT NULL AUTO_INCREMENT,
  semana ENUM('segunda',  'terca', 'quarta', 'quinta', 'sexta'),
  id_produto INT not null,
  nome varchar(200) not null,
  valor float(8,2) not null,
  PRIMARY KEY (id_promocao),
  FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

CREATE TABLE notificacoes(
  id_notif INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo_notif ENUM('restricao',  'compras', 'estorno'),
  descricao varchar(200) not null,
  visualizado tinyint not null default 0,
  id_venda int,
  id_cliente int,
  id_aluno int,
  FOREIGN KEY (id_venda) REFERENCES vendas(id_venda),
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
  FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);
