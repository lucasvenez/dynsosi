# MySQL-Front Dump 1.22
#
# Host: polo3.assis.unesp.br Database: os
#--------------------------------------------------------
# Server version 4.0.27-log


#
# Table structure for table 'atendente'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ atendente (
  id int(10) unsigned NOT NULL auto_increment,
  apelido varchar(20) NOT NULL DEFAULT '' ,
  senha varchar(20) NOT NULL DEFAULT '' ,
  nome varchar(50) NOT NULL DEFAULT '' ,
  cpf varchar(14) NOT NULL DEFAULT '' ,
  data_nasc date NOT NULL DEFAULT '0000-00-00' ,
  endereco varchar(50) NOT NULL DEFAULT '' ,
  bairro varchar(30) NOT NULL DEFAULT '' ,
  cidade varchar(30) NOT NULL DEFAULT '' ,
  cep varchar(10) NOT NULL DEFAULT '' ,
  uf char(2) NOT NULL DEFAULT '' ,
  telefone varchar(14) ,
  celular varchar(14) ,
  email varchar(50) ,
  filiacao varchar(100) NOT NULL DEFAULT '' ,
  endereco_origem varchar(50) ,
  bairro_origem varchar(30) ,
  cidade_origem varchar(30) ,
  uf_origem char(2) ,
  cep_origem varchar(10) ,
  telefone_origem varchar(14) ,
  celular_origem varchar(14) ,
  tipo_vinculo enum('Bolsista','Voluntário','Funcionario') NOT NULL DEFAULT 'Bolsista' ,
  instituicao int(10) unsigned NOT NULL DEFAULT '0' ,
  inicio date NOT NULL DEFAULT '0000-00-00' ,
  termino date NOT NULL DEFAULT '0000-00-00' ,
  obs blob ,
  nivel int(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'atendente'
#
#INSERT apelido,senha,nome,cpf,nivel INTO atendente VALUES("admin","os102030","Administrador do Sistema","999.999.999-99","9");


#
# Table structure for table 'comp_defeito'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ comp_defeito (
  id int(10) unsigned NOT NULL auto_increment,
  descricao varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'comp_defeito'
#
INSERT INTO comp_defeito VALUES("1","Sistema Aleph");
INSERT INTO comp_defeito VALUES("2","Anti  Vírus ( Instalação/Atualização/Remoção )");
INSERT INTO comp_defeito VALUES("3","Caixas de Som");
INSERT INTO comp_defeito VALUES("4","Canhão Multimídia - Datashow");
INSERT INTO comp_defeito VALUES("5","CD-Rom");
INSERT INTO comp_defeito VALUES("6","CD-RW Gravador de CD");
INSERT INTO comp_defeito VALUES("7","Webmaster - Disponibilizar Páginas Web");
INSERT INTO comp_defeito VALUES("8","Drive Disquete - Floppy");
INSERT INTO comp_defeito VALUES("9","Estabilizador");
INSERT INTO comp_defeito VALUES("10","E-Mail ( Pegasus, WebMail )");
INSERT INTO comp_defeito VALUES("11","Fonte");
INSERT INTO comp_defeito VALUES("12","Hub");
INSERT INTO comp_defeito VALUES("13","Impressora Laser");
INSERT INTO comp_defeito VALUES("14","Drivers – Rede, Vídeo, Som, Impressora");
INSERT INTO comp_defeito VALUES("15","Instalação de Equipamentos");
INSERT INTO comp_defeito VALUES("16","Instalação de Softwares");
INSERT INTO comp_defeito VALUES("17","Navegadores ( Internet Explorer/Netscape )");
INSERT INTO comp_defeito VALUES("18","Micro Isis – Biblioteca");
INSERT INTO comp_defeito VALUES("19","Monitor");
INSERT INTO comp_defeito VALUES("20","Mouse");
INSERT INTO comp_defeito VALUES("21","No-Break");
INSERT INTO comp_defeito VALUES("22","Notebook");
INSERT INTO comp_defeito VALUES("23","Plotter");
INSERT INTO comp_defeito VALUES("24","Pontos de Rede");
INSERT INTO comp_defeito VALUES("25","Rede");
INSERT INTO comp_defeito VALUES("26","Softwares ( Windows, Office, etc...)");
INSERT INTO comp_defeito VALUES("27","Webmaster - Solicitação de Acesso Remoto");
INSERT INTO comp_defeito VALUES("28","Scanner");
INSERT INTO comp_defeito VALUES("29","Teclado");
INSERT INTO comp_defeito VALUES("30","ZipDrive");
INSERT INTO comp_defeito VALUES("31","Internet");
INSERT INTO comp_defeito VALUES("32","Formatar HD ( Atualiz. do Sistema Op.)");
INSERT INTO comp_defeito VALUES("33","Backup de Arquivos");
INSERT INTO comp_defeito VALUES("34","Limpeza");
INSERT INTO comp_defeito VALUES("35","Memória");
INSERT INTO comp_defeito VALUES("36","Realização de GHOST");
INSERT INTO comp_defeito VALUES("37","Remanejamento de Equipamentos");
INSERT INTO comp_defeito VALUES("38","Disponibilizar Eventos");
INSERT INTO comp_defeito VALUES("39","Customizações de Sistema");
INSERT INTO comp_defeito VALUES("40","Recuperação de Dados");
INSERT INTO comp_defeito VALUES("41","Treinamento de Software");
INSERT INTO comp_defeito VALUES("42","Atualizações de Sistemas");
INSERT INTO comp_defeito VALUES("43","Sistema de Informação - Manutenção Sistema");
INSERT INTO comp_defeito VALUES("44","Impressora Matricial");
INSERT INTO comp_defeito VALUES("45","Impressora Jato de Tinta");
INSERT INTO comp_defeito VALUES("46","Não liga");
INSERT INTO comp_defeito VALUES("47","Travando");
INSERT INTO comp_defeito VALUES("48","Webmaster - Atualização de Páginas Internet");
INSERT INTO comp_defeito VALUES("49","Treinamento");
INSERT INTO comp_defeito VALUES("51","Webmaster - Criação de Site");
INSERT INTO comp_defeito VALUES("52","Testar Equipamento");
INSERT INTO comp_defeito VALUES("53","Microcomputador");
INSERT INTO comp_defeito VALUES("54","Graduação - Sistemas On-line");
INSERT INTO comp_defeito VALUES("55","Administração - Sistema Administrativo");
INSERT INTO comp_defeito VALUES("56","Webmaster - E-mails (Criação, Alteração de Senha)");
INSERT INTO comp_defeito VALUES("57","Webmaster - Solicitação de Senha");
INSERT INTO comp_defeito VALUES("58","Sistema de Informação - Migração Sistema");
INSERT INTO comp_defeito VALUES("59","Sistema de Informação - Desenvolvimento");
INSERT INTO comp_defeito VALUES("60","Thin Client");
INSERT INTO comp_defeito VALUES("61","Multifuncional");
INSERT INTO comp_defeito VALUES("62","Videoconferência");


#
# Table structure for table 'componente'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ componente (
  id int(10) unsigned NOT NULL auto_increment,
  descricao varchar(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'componente'
#
INSERT INTO componente VALUES("1","Computador");
INSERT INTO componente VALUES("2","Impressora");
INSERT INTO componente VALUES("3","Monitor");
INSERT INTO componente VALUES("4","DataShow");
INSERT INTO componente VALUES("5","No-Break/Estabilizador");
INSERT INTO componente VALUES("6","Hub/Switch");
INSERT INTO componente VALUES("7","Webmaster");
INSERT INTO componente VALUES("8","Rede");


#
# Table structure for table 'empresa'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ empresa (
  id int(10) unsigned NOT NULL auto_increment,
  descricao varchar(60) NOT NULL DEFAULT '' ,
  cnpj varchar(18) NOT NULL DEFAULT '' ,
  contato varchar(20) NOT NULL DEFAULT '' ,
  tecnico varchar(20) ,
  telefone varchar(14) NOT NULL DEFAULT '' ,
  celular varchar(14) ,
  fax varchar(14) ,
  homepage varchar(50) ,
  email varchar(50) ,
  endereco varchar(50) NOT NULL DEFAULT '' ,
  bairro varchar(30) NOT NULL DEFAULT '' ,
  cidade varchar(30) NOT NULL DEFAULT '' ,
  uf char(2) NOT NULL DEFAULT '' ,
  cep varchar(10) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'empresa'
#
INSERT INTO empresa VALUES("1","Spancenter","","Rogério","Rogério","(14) 3326-2040","(14) 9706-6000","(14) 3326-2040","","spancenter@spancenter.com.br","","","","SP","");
INSERT INTO empresa VALUES("2","Única Informática","","Flávia","Arlei","(18) 3322-5199","","","","","","","","SP","");
INSERT INTO empresa VALUES("3","Prosun Informática","60.023.231/0001-42","Luci","Fernando","(14) 3402-1010",NULL,"(14) 3402-1015","www.prosun.com.br","prosun@prosun.com.br","Av. Sampaio Vidal, 299-A","Centro","Marília","SP","17.500-020");
INSERT INTO empresa VALUES("4","Tecnocoop Informática","","Marcos","Marcos","(14) 234-2395","(14) 9701-9466","","","","","","","SP","");
INSERT INTO empresa VALUES("5","Help Informática","","Talita","Talita","(18) 3322-2251","","(18) 3324-9776","","","","","","SP","");
INSERT INTO empresa VALUES("6","Alexis Informática","","César","César","(18) 3321-2970","(18) 9745-4750","","","","","","","SP","");
INSERT INTO empresa VALUES("8","Infotec - Solução de Informática","06.316.110/0001-43","Tailize","Luis Fernando","(18) 3322-2260","","","www.infotec.com.br","infotec@femanet.com.br","Av. Rui Barbosa, 891","Centro","Assis","SP","19.800-000");
INSERT INTO empresa VALUES("9","Multitarefas Informática","03.101.009/0001-87","Eduardo","Eduardo","(18) 3322-2981","","","","multitarefas@uol.com.br","Av. Dom Antonio, 704","V. Santa Cecilia","Assis","SP","19.806-171");
INSERT INTO empresa VALUES("10","EQUIPA Soluçoes Integradas para escritórios Inteligentes","00.000.000/0000-00","Cristina Ferreira","","(11) 3388-7556","","","","orcamento@equipa.com.br","Av. Liberdade, 809","Liberdade","São Paulo","SP","01.503-001");
INSERT INTO empresa VALUES("11","PRODADOS","00.000.000/0000-00","Celia","","(18) 3322-4909","","","","","R.","Centro","Assis","SP","19.800-000");
INSERT INTO empresa VALUES("12","Cremonezi","99.999.999/9999-99","Cremonezi","Cremonezi","(43) 3525-4517",NULL,"(43) 3537-1020",NULL,"globalvivo@terra.com.br;b.cremonezi@terra.com.br","Rua do Rosário, 247","Centro","Jacarézinho","PR","86.400-000");
INSERT INTO empresa VALUES("13","LPZiglio Informática","04.023.725/0001-56","Ziglio",NULL,"(14) 3326-7002",NULL,"(14) 3326-7002","www.lpziglio.com.br","lpziglio@lpziglio.com.br","Av. Luiz Saldanha Rodrigues, 3310","Centro","Ourinhos","SP","19.908-095");
INSERT INTO empresa VALUES("14","INFOASSIS - LIODETE TEIXEIRA CARVALHO L INF ME","05.801.988/0001-01","André","André","(18) 3321-1993",NULL,NULL,NULL,NULL,"Rua João Maldonado, 135 - Sala 1","Vila Clementina (Forum)","Assis","SP","19802-320");
INSERT INTO empresa VALUES("15","HARDWARE INFORMÁTICA - Angelino Rodrigues - ME","05.810.153/0001-18","189148857114","Ricardo","(18) 8125-7434","(18) 8125-7434",NULL,"skype rqleite","rqleite@gmail.com","Av. Rui Barbosa, 1550","Centro","Assis","SP","19.815-000");
INSERT INTO empresa VALUES("16","TECKPRINT - Vanderlei Ap. de Souza ME","61.346.094/0001-40","Vanderlei","Sueli","(18) 3323-4873",NULL,NULL,NULL,NULL,"Rua Sebastião Leite do Canto, 304","Centro","Assis","SP","19.800-120");
INSERT INTO empresa VALUES("17","Itautec","99.999.999/9999-99","Itautec","08007013404","(00) 0000-0000","(00) 0000-00","(00)0","00","00","00","00","00","SP","00.000-000");
INSERT INTO empresa VALUES("18","Compuhouse Informática Ltda","99.999.999/9999-99","Sandro","Junior","(16) 3627-6565",NULL,NULL,NULL,NULL,"Av. Meira Júnior , 1342","Jd Paulistano","Ribeirão Preto","SP","14.090-000");


#
# Table structure for table 'estado'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ estado (
  id char(2) NOT NULL DEFAULT '' ,
  descricao varchar(40) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id,descricao)
);



#
# Dumping data for table 'estado'
#
INSERT INTO estado VALUES("AC","ACRE");
INSERT INTO estado VALUES("AL","ALAGOAS");
INSERT INTO estado VALUES("AM","AMAZONAS");
INSERT INTO estado VALUES("AP","AMAPÁ");
INSERT INTO estado VALUES("ar","argentina");
INSERT INTO estado VALUES("BA","BAHIA");
INSERT INTO estado VALUES("CE","CEARÁ");
INSERT INTO estado VALUES("DF","DISTRITO FEDERAL");
INSERT INTO estado VALUES("ES","ESPÍRITO SANTO");
INSERT INTO estado VALUES("GO","GOIÁS");
INSERT INTO estado VALUES("MA","MARANHÃO");
INSERT INTO estado VALUES("MG","MINAS GERAIS");
INSERT INTO estado VALUES("MS","MATO GROSSO DO SUL");
INSERT INTO estado VALUES("MT","MATO GROSSO");
INSERT INTO estado VALUES("PA","PARÁ");
INSERT INTO estado VALUES("PB","PARAÍBA");
INSERT INTO estado VALUES("PE","PERNAMBUCO");
INSERT INTO estado VALUES("PI","PIAUÍ");
INSERT INTO estado VALUES("PR","PARANÁ");
INSERT INTO estado VALUES("RJ","RIO DE JANEIRO");
INSERT INTO estado VALUES("RN","RIO GRANDE DO NORTE");
INSERT INTO estado VALUES("RO","RONDÔNIA");
INSERT INTO estado VALUES("RR","RORAIMA");
INSERT INTO estado VALUES("RS","RIO GRANDE DO SUL");
INSERT INTO estado VALUES("SC","SANTA CATARINA");
INSERT INTO estado VALUES("SE","SERGIPE");
INSERT INTO estado VALUES("SP","SÃO PAULO");
INSERT INTO estado VALUES("TO","TOCANTINS");
INSERT INTO estado VALUES("us","Estados Unidos");


#
# Table structure for table 'instituicao'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ instituicao (
  id int(10) unsigned NOT NULL auto_increment,
  descricao varchar(100) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id,descricao)
);



#
# Dumping data for table 'instituicao'
#
INSERT INTO instituicao VALUES("1","UNESP");


#
# Table structure for table 'item_orcamento'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ item_orcamento (
  id int(10) unsigned NOT NULL auto_increment,
  diagnostico varchar(255) NOT NULL DEFAULT '' ,
  orcamento int(10) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id,orcamento)
);



#
# Dumping data for table 'item_orcamento'
#


#
# Table structure for table 'orcamento'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ orcamento (
  id int(10) unsigned NOT NULL auto_increment,
  fi varchar(20) NOT NULL DEFAULT '' ,
  os int(10) unsigned NOT NULL DEFAULT '0' ,
  empresa int(10) unsigned NOT NULL DEFAULT '0' ,
  valor decimal(10,2) NOT NULL DEFAULT '0.00' ,
  data_enc date ,
  defeito varchar(50) ,
  local varchar(50) ,
  aprovado int(10) unsigned ,
  data_s date ,
  data_r date ,
  data_a date ,
  os_negados int(10) unsigned ,
  laudo varchar(255) ,
  os_data_s date ,
  os_data_r date ,
  descricao varchar(50) ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'orcamento'
#


#
# Table structure for table 'ordem_servico'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ ordem_servico (
  id int(10) unsigned NOT NULL auto_increment,
  data date NOT NULL DEFAULT '0000-00-00' ,
  hora time NOT NULL DEFAULT '00:00:00' ,
  usuario varchar(14) NOT NULL DEFAULT '' ,
  localizacao varchar(20) ,
  requisitante varchar(50) ,
  ramal varchar(4) ,
  componente int(10) unsigned NOT NULL DEFAULT '0' ,
  ai varchar(10) ,
  patrimonio varchar(10) ,
  comodato varchar(10) ,
  defeito blob NOT NULL DEFAULT '' ,
  data_baixa date ,
  hora_baixa time ,
  solucao blob ,
  ip varchar(15) NOT NULL DEFAULT '' ,
  data_e date ,
  data_s date ,
  at enum('S','N') NOT NULL DEFAULT 'N' ,
  fi varchar(15) ,
  atendente int(10) unsigned NOT NULL DEFAULT '0' ,
  sala varchar(30) ,
  empresa int(10) unsigned DEFAULT '0' ,
  garantia int(3) ,
  PRIMARY KEY (id)
);