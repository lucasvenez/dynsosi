# MySQL-Front Dump 1.22
#
# Host: polo3.assis.unesp.br Database: levto
#--------------------------------------------------------
# Server version 4.0.27-log


#
# Table structure for table 'adaptador'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ adaptador (
  id int(11) NOT NULL auto_increment,
  equipamento int(11) ,
  host varchar(40) ,
  ip varchar(15) ,
  mac varchar(17) ,
  placa varchar(60) ,
  obs varchar(100) ,
  PRIMARY KEY (id),
  INDEX id (id)
);



#
# Table structure for table 'levto'
#

CREATE TABLE /*!32300 IF NOT EXISTS*/ levto (
  descricao varchar(60) ,
  num_serie varchar(20) ,
  ai int(5) ,
  modelo varchar(50) ,
  tipo varchar(50) ,
  Data_Aquisicao date ,
  empr_aquisicao int(10) ,
  garantia date ,
  sigla varchar(6) ,
  nome_ua varchar(100) ,
  complemento varchar(50) ,
  patrimonio int(5) ,
  comodato int(4) ,
  situacao varchar(7) ,
  data_baixa date ,
  observacao varchar(50) ,
  host varchar(20) ,
  ip varchar(15) ,
  placa_mae varchar(50) ,
  chipset varchar(50) ,
  ram int(3) ,
  hd char(3) ,
  aida char(3) ,
  tipo_ua char(1) ,
  codigo_depto char(3) ,
  codigo_componente int(11) ,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY (id)
);

