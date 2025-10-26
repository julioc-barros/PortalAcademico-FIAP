-- -----------------------------------------------------
-- Database `portal_academico_fiap`
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS `portal_academico_fiap` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `portal_academico_fiap`;

-- -----------------------------------------------------
-- Tabela `administradores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `administradores` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`senha` VARCHAR(255) NOT NULL,
	-- Armazenada com hash
	`is_super_admin` TINYINT(1) NOT NULL DEFAULT 0,
	`d_e_l_e_t_` TINYINT(1) NOT NULL DEFAULT 0,
	-- Utilizando conceito Soft Delete
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `alunos` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL,
	`data_nascimento` DATE NOT NULL,
	`cpf` VARCHAR(11) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`senha` VARCHAR(255) NOT NULL,
	-- Armazenada com hash
	`d_e_l_e_t_` TINYINT(1) NOT NULL DEFAULT 0,
	-- Utilizando conceito Soft Delete
	PRIMARY KEY (`id`),
	UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
	-- CPF Único
	UNIQUE INDEX `email_UNIQUE` (`email` ASC) -- Email Único
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `turmas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `turmas` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL,
	`descricao` TEXT NULL,
	`d_e_l_e_t_` TINYINT(1) NOT NULL DEFAULT 0,
	-- Utilizando conceito Soft Delete
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `matriculas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matriculas` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`aluno_id` INT NOT NULL,
	`turma_id` INT NOT NULL,
	`data_matricula` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `fk_matriculas_alunos_idx` (`aluno_id` ASC),
	INDEX `fk_matriculas_turmas_idx` (`turma_id` ASC),
	-- Aluno não pode ser matriculado 2x na mesma turma
	UNIQUE INDEX `aluno_turma_UNIQUE` (`aluno_id` ASC, `turma_id` ASC),
	CONSTRAINT `fk_matriculas_alunos` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`) ON DELETE RESTRICT -- Impede excluir aluno com matrícula
	ON UPDATE CASCADE,
	CONSTRAINT `fk_matriculas_turmas` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE RESTRICT -- Impede excluir turma com matrícula
	ON UPDATE CASCADE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `logs_admin` (Melhoria: Auditoria)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logs_admin` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`admin_id` INT NOT NULL,
	`acao` TEXT NOT NULL,
	`ip_address` VARCHAR(45) NULL,
	`timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `fk_logs_admin_idx` (`admin_id` ASC),
	CONSTRAINT `fk_logs_admin` FOREIGN KEY (`admin_id`) REFERENCES `administradores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- REGISTROS INICIAIS (MOCK DATA)
-- -----------------------------------------------------
-- Admin (Senha: 'Admin@123')
INSERT INTO
	`administradores` (
		`nome`,
		`email`,
		`senha`,
		`is_super_admin`,
		`d_e_l_e_t_`
	)
VALUES
	(
		'Super Administrador',
		'admin@fiap.com.br',
		'$2y$10$VJx9k1u/32e2nijzkqIsSuoU8LMjJyn1l9TLuQ8IXeFxdJGpWIkkG',
		1,
		0
	);

-- 8 Turmas
INSERT INTO
	`turmas` (`nome`, `descricao`, `d_e_l_e_t_`)
VALUES
	(
		'Engenharia de Software (Noturno)',
		'Turma focada em padrões de projeto e arquitetura.',
		0
	),
	(
		'Banco de Dados (Matutino)',
		'Turma de modelagem e consulta de bancos SQL e NoSQL.',
		0
	),
	(
		'Desenvolvimento Web (Integral)',
		'Foco em HTML, CSS, JS e PHP.',
		0
	),
	(
		'Inteligência Artificial (Noturno)',
		'Algoritmos de Machine Learning e Deep Learning.',
		0
	),
	(
		'Ciência de Dados (Vespertino)',
		'Análise de dados, Big Data e visualização.',
		0
	),
	(
		'Redes de Computadores (Noturno)',
		'Infraestrutura, protocolos e segurança de redes.',
		0
	),
	(
		'Segurança da Informação (Integral)',
		'Foco em pentest, criptografia e gestão de riscos.',
		0
	),
	(
		'Arquitetura de Soluções (EAD)',
		'Desenho de sistemas escaláveis e cloud computing.',
		0
	);

-- 30 Alunos (Senha de todos: 'Aluno@123')
SET
	@senha_aluno = '$2y$10$0CIcS4pvhuBX6M6sEJ4w8e/U3waBqejxNMrT4pb8tQlvGlP6vfo.O';

INSERT INTO
	`alunos` (
		`nome`,
		`data_nascimento`,
		`cpf`,
		`email`,
		`senha`,
		`d_e_l_e_t_`
	)
VALUES
	(
		'Ana Silva',
		'2000-01-10',
		'11111111101',
		'ana.silva@email.com',
		@senha_aluno,
		0
	),
	(
		'Bruno Lima',
		'1999-03-15',
		'11111111102',
		'bruno.lima@email.com',
		@senha_aluno,
		0
	),
	(
		'Carla Souza',
		'2001-05-20',
		'11111111103',
		'carla.souza@email.com',
		@senha_aluno,
		0
	),
	(
		'Daniel Moreira',
		'2000-07-25',
		'11111111104',
		'daniel.moreira@email.com',
		@senha_aluno,
		0
	),
	(
		'Eduarda Costa',
		'2002-09-30',
		'11111111105',
		'eduarda.costa@email.com',
		@senha_aluno,
		0
	),
	(
		'Fábio Pereira',
		'1998-11-05',
		'11111111106',
		'fabio.pereira@email.com',
		@senha_aluno,
		0
	),
	(
		'Gabriela Dias',
		'2001-02-12',
		'11111111107',
		'gabriela.dias@email.com',
		@senha_aluno,
		0
	),
	(
		'Heitor Santos',
		'2000-04-18',
		'11111111108',
		'heitor.santos@email.com',
		@senha_aluno,
		0
	),
	(
		'Isabela Martins',
		'1999-06-22',
		'11111111109',
		'isabela.martins@email.com',
		@senha_aluno,
		0
	),
	(
		'João Oliveira',
		'2002-08-14',
		'11111111110',
		'joao.oliveira@email.com',
		@senha_aluno,
		0
	),
	(
		'Karina Almeida',
		'2000-10-01',
		'11111111111',
		'karina.almeida@email.com',
		@senha_aluno,
		0
	),
	(
		'Lucas Mendes',
		'1998-12-07',
		'11111111112',
		'lucas.mendes@email.com',
		@senha_aluno,
		0
	),
	(
		'Mariana Ferreira',
		'2001-01-19',
		'11111111113',
		'mariana.ferreira@email.com',
		@senha_aluno,
		0
	),
	(
		'Nelson Antunes',
		'2000-03-28',
		'11111111114',
		'nelson.antunes@email.com',
		@senha_aluno,
		0
	),
	(
		'Olívia Ribeiro',
		'1999-05-16',
		'11111111115',
		'olivia.ribeiro@email.com',
		@senha_aluno,
		0
	),
	(
		'Pedro Gonçalves',
		'2002-07-09',
		'11111111116',
		'pedro.goncalves@email.com',
		@senha_aluno,
		0
	),
	(
		'Quintino Barros',
		'2000-09-03',
		'11111111117',
		'quintino.barros@email.com',
		@senha_aluno,
		0
	),
	(
		'Rafaela Nunes',
		'1998-11-11',
		'11111111118',
		'rafaela.nunes@email.com',
		@senha_aluno,
		0
	),
	(
		'Sérgio Carvalho',
		'2001-12-24',
		'11111111119',
		'sergio.carvalho@email.com',
		@senha_aluno,
		0
	),
	(
		'Tatiane Xavier',
		'2000-02-28',
		'11111111120',
		'tatiane.xavier@email.com',
		@senha_aluno,
		0
	),
	(
		'Ulisses Viana',
		'1999-04-06',
		'11111111121',
		'ulisses.viana@email.com',
		@senha_aluno,
		0
	),
	(
		'Vanessa Lins',
		'2002-06-13',
		'11111111122',
		'vanessa.lins@email.com',
		@senha_aluno,
		0
	),
	(
		'William Neves',
		'2000-08-21',
		'11111111123',
		'william.neves@email.com',
		@senha_aluno,
		0
	),
	(
		'Yasmin Gomes',
		'1998-10-17',
		'11111111124',
		'yasmin.gomes@email.com',
		@senha_aluno,
		0
	),
	(
		'Zeca Pires',
		'2001-11-29',
		'11111111125',
		'zeca.pires@email.com',
		@senha_aluno,
		0
	),
	(
		'Amanda Borges',
		'2000-01-05',
		'11111111126',
		'amanda.borges@email.com',
		@senha_aluno,
		0
	),
	(
		'Breno Cardoso',
		'1999-03-08',
		'11111111127',
		'breno.cardoso@email.com',
		@senha_aluno,
		0
	),
	(
		'Camila Esteves',
		'2002-05-12',
		'11111111128',
		'camila.esteves@email.com',
		@senha_aluno,
		0
	),
	(
		'Diogo Matos',
		'2000-07-19',
		'11111111129',
		'diogo.matos@email.com',
		@senha_aluno,
		0
	),
	(
		'Elisa Furtado',
		'1998-09-23',
		'11111111130',
		'elisa.furtado@email.com',
		@senha_aluno,
		0
	);

-- Matrículas (24 alunos matriculados = 80%)
INSERT INTO
	`matriculas` (`aluno_id`, `turma_id`)
VALUES
	(1, 1),
	-- Ana em Engenharia
	(1, 2),
	-- Ana em Banco de Dados
	(2, 1),
	-- Bruno em Engenharia
	(2, 3),
	-- Bruno em Dev Web
	(3, 1),
	-- Carla em Engenharia
	(4, 1),
	-- Daniel em Engenharia
	(5, 2),
	-- Eduarda em Banco de Dados
	(6, 2),
	-- Fábio em Banco de Dados
	(7, 3),
	-- Gabriela em Dev Web
	(8, 3),
	-- Heitor em Dev Web
	(9, 4),
	-- Isabela em IA
	(10, 4),
	-- João em IA
	(11, 4),
	-- Karina em IA
	(12, 5),
	-- Lucas em Ciência de Dados
	(13, 5),
	-- Mariana em Ciência de Dados
	(14, 5),
	-- Nelson em Ciência de Dados
	(15, 6),
	-- Olívia em Redes
	(16, 6),
	-- Pedro em Redes
	(17, 7),
	-- Quintino em Segurança
	(18, 7),
	-- Rafaela em Segurança
	(19, 7),
	-- Sérgio em Segurança
	(20, 8),
	-- Tatiane em Arquitetura
	(21, 8),
	-- Ulisses em Arquitetura
	(22, 8),
	-- Vanessa em Arquitetura
	(23, 1),
	-- William em Engenharia
	(24, 2);
-- Yasmin em Banco de Dados