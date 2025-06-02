-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02/06/2025 às 00:33
-- Versão do servidor: 8.0.41
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE site_de_vendas;
USE site_de_vendas;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `site_de_vendas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--


DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `ID_carrinho` int NOT NULL AUTO_INCREMENT,
  `ID_cliente` int DEFAULT NULL,
  `produtos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_carrinho`),
  KEY `ID_cliente` (`ID_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho_produto`
--

DROP TABLE IF EXISTS `carrinho_produto`;
CREATE TABLE IF NOT EXISTS `carrinho_produto` (
  `ID_carrinho` int NOT NULL,
  `ID_produto` int NOT NULL,
  `quantidade` int DEFAULT NULL,
  PRIMARY KEY (`ID_carrinho`,`ID_produto`),
  KEY `ID_produto` (`ID_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `ID_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`ID_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`ID_categoria`, `nome`, `imagem`, `descricao`) VALUES
(1, 'Acessórios', 'cat_683ccb183c42b8.50635483.jpg', NULL),
(2, 'Beleza', 'cat_683ccb24941a74.77343863.avif', NULL),
(3, 'Brinquedos', 'cat_683ccb35afc437.49520434.jpg', NULL),
(4, 'Decoração', 'cat_683ccb42a69327.90523774.jpeg', NULL),
(5, 'Eletrônicos', 'cat_683ccb4ed676f2.90709167.avif', NULL),
(6, 'Lazer', 'cat_683ccb5ca2a036.19826741.webp', NULL),
(7, 'Informática', 'cat_683ccb68611047.51673764.webp', NULL),
(8, 'Livros', 'cat_683ccb73b8fb00.35807317.jpg', NULL),
(9, 'Roupas Femininas', 'cat_683ccba04cab13.49212815.jpg', NULL),
(10, 'Roupas Masculinas', 'cat_683ccbd9edddd1.22778236.webp', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `ID_cliente` int NOT NULL,
  `preferencias` varchar(100) DEFAULT NULL,
  `historicoCompras` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

DROP TABLE IF EXISTS `contato`;
CREATE TABLE IF NOT EXISTS `contato` (
  `ID_contato` int NOT NULL AUTO_INCREMENT,
  `ID_pessoa` int NOT NULL,
  `assunto` varchar(50) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_contato`),
  KEY `ID_pessoa` (`ID_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `contato`
--

INSERT INTO `contato` (`ID_contato`, `ID_pessoa`, `assunto`, `mensagem`, `data_envio`) VALUES
(1, 2, 'elogio', 'A EID Store é um verdadeiro exemplo de excelência no comércio digital. Seu site é moderno, intuitivo e transmite confiança desde o primeiro clique. A navegação é fluida, com categorias bem organizadas e descrições claras que facilitam a experiência do usuário.', '2025-06-01 21:26:16'),
(2, 2, 'duvida', 'Gostaria de saber se a EID Store pretende expandir ainda mais seu catálogo de produtos nos próximos meses. Existe algum planejamento para incluir novas categorias ou marcas exclusivas?', '2025-06-01 21:27:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `ID_funcionario` int NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `salario` float DEFAULT NULL,
  `dataAdmissao` date DEFAULT NULL,
  `registro` varchar(50) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`ID_funcionario`, `cargo`, `salario`, `dataAdmissao`, `registro`, `senha`) VALUES
(1, 'Funcionário', 0, '2025-06-01', '594000', '$2y$10$4FLH4I3rwqDU8lvx7oP2eOheZjQAZmJTjW6I0vuaVh/RHDLLQYpFa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_pedido`
--

DROP TABLE IF EXISTS `item_pedido`;
CREATE TABLE IF NOT EXISTS `item_pedido` (
  `ID_item` int NOT NULL AUTO_INCREMENT,
  `ID_pedido` int NOT NULL,
  `ID_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_item`),
  KEY `ID_pedido` (`ID_pedido`),
  KEY `ID_produto` (`ID_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodopagamento`
--

DROP TABLE IF EXISTS `metodopagamento`;
CREATE TABLE IF NOT EXISTS `metodopagamento` (
  `ID_metodo` int NOT NULL AUTO_INCREMENT,
  `cartaoDebito` varchar(30) DEFAULT NULL,
  `cartaoCredito` varchar(30) DEFAULT NULL,
  `chavePix` varchar(50) DEFAULT NULL,
  `boleto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_metodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `ID_pedido` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `metodoPagamento` varchar(30) DEFAULT NULL,
  `parcelas` int DEFAULT NULL,
  `qtdDeProduto` int DEFAULT NULL,
  `precoUnitario` float DEFAULT NULL,
  `precoTotal` float DEFAULT NULL,
  `ID_cliente` int DEFAULT NULL,
  PRIMARY KEY (`ID_pedido`),
  KEY `ID_cliente` (`ID_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `ID_pessoa` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`ID_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`ID_pessoa`, `nome`, `sobrenome`, `email`, `senha`, `dataNascimento`, `logradouro`, `numero`, `bairro`, `complemento`, `cidade`, `uf`, `cep`, `telefone`, `rg`, `cpf`, `cnpj`) VALUES
(1, 'Rodrigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '(12) 91000-0000', NULL, NULL, NULL),
(2, 'Jefferson', NULL, 'jefferson@gmail.com', '$2y$10$QJOh4qlfn7mKyKrcUrWYbuwTe7bbu8ztTW2XDpLH1v8/ayK4iaf8i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '(12) 93001-0000', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `ID_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `qtdEstoque` int DEFAULT NULL,
  `ID_categoria` int DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `imagem_2` varchar(255) DEFAULT NULL,
  `imagem_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_produto`),
  KEY `ID_categoria` (`ID_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`ID_produto`, `nome`, `preco`, `qtdEstoque`, `ID_categoria`, `descricao`, `imagem`, `imagem_2`, `imagem_3`) VALUES
(1, 'Mochila Adidas Clássica', 129, 14, 1, 'Leve estilo e praticidade com a Mochila Adidas Clássica Logo Linear 22.75L! ', 'img_683ccda665cb30.39856503.webp', 'img_683ccda665eb06.68555366.webp', 'img_683ccda6660f23.34736194.webp'),
(2, 'Óculos de Sol Chilli Beans', 189, 17, 1, 'Estes Óculos de Sol Masculino Eco Chilli Beans Quadrado Preto Polarizado, foi produzido em acrílico reciclado, as lentes possuem proteção 100% contra raios UVA e UVB.', 'img_683ccdeedbbe78.64562402.webp', 'img_683ccdeedbe175.62387374.webp', 'img_683ccdeedc0304.22706099.webp'),
(3, 'Relógio Masculino Couro Saint Germain', 170, 14, 1, 'Relógio Minimalista Saint Germain Preto Pulseira De Couro Murray Full Black 40mm de diâmetro. A caixa é de metal preto e o mostrador preto, vidro com mineral endurecido com alta resistência.', 'img_683cce1db562c5.82413959.jpg', 'img_683cce1db57e58.22316146.jpg', 'img_683cce1db59681.60341837.jpg'),
(4, 'Hidratante NativaSPA Ameixa Negra', 68, 19, 2, 'Com foco na sustentabilidade, o hidratante de 400mL é feito com PET reciclado. Por usar esse material, por ano, incorporamos o equivalente mais de 40 mil garrafas de refrigerante de 2 litros. ', 'img_683cd37c11b431.89900665.webp', 'img_683cd37c11cbc1.86646740.webp', 'img_683cd37c11de17.58382148.webp'),
(5, 'Perfum Déclaration EAU', 1245, 14, 2, 'Esta nova variação nos mostra uma segunda natureza que é tão vegetal quanto vivaz. Ela enriquece a paleta com este rastro picante e amadeirado, emblemático e elegante, conhecido pela sua intensidade olfativa.', 'img_683ce93065d6d4.43984903.webp', 'img_683ce93065f4d9.85918499.webp', 'img_683ce930660909.58876319.webp'),
(6, 'Deep Moistrure Shampoo', 184, 7, 2, 'O Deep Moisture Shampoo é formulado para proporcionar uma hidratação intensa e duradoura nos cabelos secos e desidratados. ', 'img_683ce99fbaa110.22016142.webp', 'img_683ce99fbabea9.62678532.webp', 'img_683ce99fbad824.05370768.webp'),
(7, 'Pelúcia Stitch Big Feet', 179, 18, 3, 'Linha de Pelúcias Disney Feitos em 100% poliéster, são antialérgico, não tóxico e o produto é lavavél (recomendado lavar à mão)', 'img_683ce9c646e305.73491159.jpg', 'img_683ce9c646fc01.46844224.jpg', 'img_683ce9c6471131.64559390.jpg'),
(8, 'Carrinho Rock Crawler', 169, 10, 3, 'Você está preparado para uma aventura? Agora as crianças vão poder se divertir pra valer com este incrível Carro de Controle Remoto Crawler.', 'img_683cea1daba640.17274055.webp', 'img_683cea1dabbf09.30311366.webp', 'img_683cea1dabd9c9.05631355.webp'),
(9, 'Quebra-cabeça Recanto dos Cisnes', 74, 27, 3, 'A vida nas grandes cidades faz com que a nossa percepção de tempo seja diferente da de outras regiões. Nossa mente se aquieta e podemos ter novas ideias. Monta puzzles com imagens bucólicas aumenta ainda mais essa sensação de calma prazerosa.', 'img_683ceaa2a4af16.25821864.webp', 'img_683ceaa2a4da44.18310895.webp', 'img_683ceaa2a4f976.82923894.webp'),
(10, 'Luminaria 3D Lua Cheia', 68, 13, 4, 'Transforme qualquer ambiente em um oásis de beleza celestial com a nossa luminária Lua USB RGB. Esta peça única combina elegância lunar com a praticidade da tecnologia moderna, proporcionando uma experiência de iluminação única.', 'img_683ceacce96c71.41562298.jpg', 'img_683ceacce98ad5.85240029.jpg', 'img_683ceacce9a569.11895895.jpg'),
(11, 'Quadro Tucano ', 29, 14, 4, 'Quadro Tucano colors', 'img_683ceaeac211d5.44473403.png', 'img_683ceaeac22ae0.14747108.png', 'img_683ceaeac23f20.16018055.png'),
(12, 'Tinideya Tapete de flores', 178, 18, 4, 'Resistente e macio: nosso tapete de banho de flores é feito de imitação de caxemira, resistente e confiável, não desbota facilmente, rasga ou quebra, mesmo após repetidas lavagens.', 'img_683ceb069ce0d3.27706716.jpg', 'img_683ceb069cfba7.93040022.jpg', 'img_683ceb069d1500.01438339.jpg'),
(13, 'Headphone JBL 720', 289, 13, 5, 'Os fones de ouvido JBL Tune 720BT transmitem o potente som JBL Pure Bass graças à última tecnologia bluetooth 5.3. Proporcionam até 76 horas de puro prazer e até 3 horas extras de bateria com apenas 5 minutos de carga. ', 'img_683ceb3a4fded7.21874037.jpg', 'img_683ceb3a4ff9f8.14700414.jpg', 'img_683ceb3a537239.85845014.jpg'),
(14, 'Samsung Galaxy Book4', 3509, 30, 5, 'Fino e poderoso, o Galaxy Book4 possui uma ampla variedade de portas integradas para atender às suas necessidades de conectividade.', 'img_683ceb7f144a34.65277394.jpg', 'img_683ceb7f146155.08884654.jpg', 'img_683ceb7f147789.18374790.jpg'),
(15, 'Smartphone RedMagic 10 Pro ', 6799, 27, 5, 'Telefone para jogos com uma taxa de atualização de 120 Hz e uma resolução de 2480 x 1116 pixels, esta tela FHD+ Full AMOLED de 6,8\" oferece belos visuais HD+ em até 120 quadros por segundo.', 'img_683cebb4e27bd6.68361570.jpg', 'img_683cebb4e29185.06174195.jpg', 'img_683cebb4e2a708.78901822.jpg'),
(16, 'Bicicleta Aro 12 Spider Man', 215, 21, 6, 'Quadro, garfo e guidão em aço carbono; Limitador de giro do guidão; Freio a tambor; Regulagem de ângulo do guidão e da altura do selim; Pneus em E.V.A.; Selim em PU; Garrafinha e cestinha ou plaquinha; A partir de 3 anos.', 'img_683cebebf27d93.63613880.jpg', 'img_683cebebf29669.97094265.jpg', 'img_683cebebf2ae37.20492587.jpg'),
(17, 'Penalty Bola De Futsal', 78, 9, 6, 'Penalty Bola De Futsal RX 500 XXIII', 'img_683cec176cf873.81621863.jpg', 'img_683cec176d1026.21752730.jpg', 'img_683cec176d24c3.15736652.jpg'),
(18, 'Skate Semi Profissional Sortido', 343, 22, 6, 'O Skate Semi Profissional Zippy Toys é perfeito para crianças e adolescentes que buscam qualidade e durabilidade. Produzido em madeira resistente, PU e PVC de excelente qualidade, garante a diversão com segurança.', 'img_683cec39b8e856.53016702.webp', 'img_683cec39b90464.68269426.webp', 'img_683cec39b91fc0.85544070.webp'),
(19, 'Monitor 19.5\" LED Widescreen', 318, 15, 7, 'Com o ajuste de inclinação você pode deixar o monitor no melhor ângulo possível para que você veja as imagens com clareza. Dupla conexão: Este monitor está preparado para dois tipos de conexão de vídeo, HDMI ou VGA.', 'img_683cec7158af87.70540137.jpg', 'img_683cec7158c949.56978561.jpg', 'img_683cec7158de10.42172700.jpg'),
(20, 'Mouse Gamer Anúbis ', 43, 40, 7, 'Resolução ajustável até 32000 DPI: Quatro opções de sensibilidade (800, 1200, 1600 e 2400 DPI) para atender a diferentes necessidades de precisão. Iluminação RGB com 7 cores.', 'img_683cec90e10b01.83762141.jpg', 'img_683cec90e12933.56447187.jpg', 'img_683cec90e14188.09209048.jpg'),
(21, 'Teclado Mecânico Barak Switch Blue', 224, 17, 7, 'Com top de alumínio reforçado e corpo em ABS fortificado, o projeto foi totalmente desenvolvido com foco na qualidade; PCB e solda foram rigorosamente inspecionados e passaram por todos os testes para evitar qualquer tipo de mal contato ou click duplo.', 'img_683cece6d84638.15870063.jpg', 'img_683cece6d867a3.78176217.jpg', 'img_683cece6d87fa8.43817826.jpg'),
(22, 'Como Fazer Amigos e Influenciar Pessoas', 44, 12, 8, 'Um dos maiores clássicos de todos os tempos, Como fazer amigos e influenciar pessoas é considerado a Bíblia dos relacionamentos interpessoais.', 'img_683ced06369399.28225808.webp', 'img_683ced0636a992.25702617.webp', ''),
(23, 'Livro Blade Runner', 55, 29, 8, 'Inspiração para um dos maiores clássicos do cinema, dirigido por Ridley Scott, este romance é de autoria do prolífico e revolucionário Philip K. Dick, um dos maiores expoentes da contracultura na ficção científica durante as décadas de 60 e 70. ', 'img_683ced252ea016.30519289.jpg', 'img_683ced252eb894.97342341.jpg', 'img_683ced252ecee9.93361826.jpg'),
(24, 'É Assim que Acaba', 40, 27, 8, 'Considerado o livro do ano, que virou febre no TikTok e sozinho já acumulou mais de um milhão de exemplares vendidos no Brasil. ', 'img_683ced4cd842e5.98667307.jpg', 'img_683ced4cd85c11.25618873.jpg', 'img_683ced4cd870a2.06994491.jpg'),
(25, 'Blusa Social Feminina', 45, 21, 9, 'Blusa feminina social manga curta bufante princesa, gola redonda com detalhe trançado e abertura V no decote, moda elegante e sofisticada em tecido crepe; leve e confortável.', 'img_683ced6ea7f673.16636468.jpg', 'img_683ced6ea80d96.82046019.jpg', 'img_683ced6ea82683.82999243.jpg'),
(26, 'Saia Curta de Cintura Alta Xadrez', 100, 6, 9, 'Material: Feito de poliéster de qualidade, estilo plissado, skater design, petite uniforme da escola saia xadrez sólida, clássico e moda.', 'img_683ced899f0db6.99608677.jpg', 'img_683ced899f34a3.03050063.jpg', 'img_683ced899f4cf5.90982111.jpg'),
(27, 'Vestido feminino plus size', 150, 18, 9, 'Vestido feminino plus size com decote em V, retrô, plissado, saia rodada, vestido de sol para mulheres, festa casual', 'img_683ceda6254b62.63074251.jpg', 'img_683ceda62567d8.10197239.jpg', 'img_683ceda6258085.39812682.jpg'),
(28, 'Calça Jeans Masculina', 58, 9, 10, 'Calça Jeans Masculina Tradicional Corte Reto Resistente Linha Premium', 'img_683cedcbe196a8.60038931.jpg', 'img_683cedcbe1b951.11254032.jpg', 'img_683cedcbe1cd96.08536697.jpg'),
(29, 'Camiseta Spider-man', 52, 12, 10, 'Camiseta Spider-man Homem-aranha Avengers', 'img_683cedea7f3106.61000236.jpg', 'img_683cedea7f4877.50881957.jpg', 'img_683cedea7f5e55.90823664.jpg'),
(30, 'Jaqueta De Couro Masculina', 218, 17, 10, 'Jaqueta De Couro Masculina Slim Resistente Forrada Peluciada', 'img_683cee5ae05881.99370373.jpg', 'img_683cee5ae077d5.13441558.jpg', 'img_683cee5ae09678.18772167.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

DROP TABLE IF EXISTS `proprietario`;
CREATE TABLE IF NOT EXISTS `proprietario` (
  `ID_proprietario` int NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `dataRegistro` date DEFAULT NULL,
  PRIMARY KEY (`ID_proprietario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sistema`
--

DROP TABLE IF EXISTS `sistema`;
CREATE TABLE IF NOT EXISTS `sistema` (
  `versao` float DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `anoDeCriacao` date DEFAULT NULL,
  `criador` varchar(100) DEFAULT NULL,
  `usuarioAtual` int DEFAULT NULL,
  KEY `usuarioAtual` (`usuarioAtual`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`ID_cliente`) REFERENCES `cliente` (`ID_cliente`);

--
-- Restrições para tabelas `carrinho_produto`
--
ALTER TABLE `carrinho_produto`
  ADD CONSTRAINT `carrinho_produto_ibfk_1` FOREIGN KEY (`ID_carrinho`) REFERENCES `carrinho` (`ID_carrinho`),
  ADD CONSTRAINT `carrinho_produto_ibfk_2` FOREIGN KEY (`ID_produto`) REFERENCES `produto` (`ID_produto`);

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`ID_cliente`) REFERENCES `pessoa` (`ID_pessoa`);

--
-- Restrições para tabelas `contato`
--
ALTER TABLE `contato`
  ADD CONSTRAINT `contato_ibfk_1` FOREIGN KEY (`ID_pessoa`) REFERENCES `pessoa` (`ID_pessoa`);

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`ID_funcionario`) REFERENCES `pessoa` (`ID_pessoa`);

--
-- Restrições para tabelas `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `item_pedido_ibfk_1` FOREIGN KEY (`ID_pedido`) REFERENCES `pedido` (`ID_pedido`),
  ADD CONSTRAINT `item_pedido_ibfk_2` FOREIGN KEY (`ID_produto`) REFERENCES `produto` (`ID_produto`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_cliente`) REFERENCES `cliente` (`ID_cliente`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`ID_categoria`) REFERENCES `categoria` (`ID_categoria`);

--
-- Restrições para tabelas `proprietario`
--
ALTER TABLE `proprietario`
  ADD CONSTRAINT `proprietario_ibfk_1` FOREIGN KEY (`ID_proprietario`) REFERENCES `pessoa` (`ID_pessoa`);

--
-- Restrições para tabelas `sistema`
--
ALTER TABLE `sistema`
  ADD CONSTRAINT `sistema_ibfk_1` FOREIGN KEY (`usuarioAtual`) REFERENCES `pessoa` (`ID_pessoa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
