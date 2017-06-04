CREATE database musicandseek;
use musicandseek;
create table USUARIO( 
ID_USUARIO int(10) not null auto_increment,
TIPO_USUARIO char(10) not null,
NOMBRE char(20) not null,
APELLIDOS char(20),
UBICACION char(50),
EMAIL char(50) not null,
NUMERO_CONTACTO int(11),
-- PROPIEDAD CALCULADA VOTOS int(50) not null,
IMAGEN char(50),
NOMBRE_LOCAL char(20),
NOMBRE_ARTISTICO char(20),
NUMERO_COMPONENTES int(5),
PASSWORD char(255) not null,
AFORO int(5),
WEB char(20),
ID_GENERO int(10),
ID_CIUDAD int(10),
PREGUNTA_SEGURIDAD char (255),
RESPUESTA_SEGURIDAD char (255),
DESCRIPCION char(255),
FECHA_ALTA DATETIME,
FECHA_BAJA DATETIME DEFAULT NULL,
primary key (ID_USUARIO, EMAIL)
);

create table CONCIERTO(
ID_CONCIERTO int(10) not null auto_increment,
ID_GRUPO int(10) not null,
ID_LOCAL int(10) not null,
FECHA datetime not null,
VISIBLE boolean not null,
PRECIO_ENTRADA int(5) not null,
INSCRIPCION boolean not null,
ENTRADAS_TOTALES int(5),
-- ESTADO REALIZADO/PENDIENTE
ESTADO boolean not null,
ID_GENERO int(10) not null,
ID_CIUDAD int(10) not null,
primary key (ID_CONCIERTO, ID_GRUPO, ID_LOCAL)
);

create table CIUDAD(
ID_CIUDAD int(10) not null auto_increment,
NOMBRE char(20) not null,
PAIS char(10) not null,
primary key(ID_CIUDAD)
);

create table GENERO(
ID_GENERO int(10) not null auto_increment,
NOMBRE char(20) not null,
primary key(ID_GENERO)
);


create table TRACE(
ID_TRACE int(10) not null auto_increment,
TIPO char(10) not null,
VALOR char(20),
FECHA datetime not null,
RESULTADO boolean,
COMENTARIO char(20),
ID_CONCIERTO int(10),
PRIMARY KEY(ID_TRACE)
);
create table VOTAR_COMENTAR(
ID_VOTO int(10) not null auto_increment primary key,
ID_FAN int(10) not null,
ID_VOTADO int(10) not null,
PUNTOS int(2) not null,
VOTO_CONCIERTO boolean not null,
COMENTARIO char(140),
FECHA datetime not null,
TIPO_VOTACION char(10) not null
);

create table PROPONER(
ID_PROPUESTA int(10) not null auto_increment primary key,
ID_LOCAL int(10) not null,
ID_GRUPO int(10) not null,
ID_CONCIERTO int(10) not null,
FECHA date not null,
ACEPTADO boolean not null
);

alter table USUARIO add constraint fk_USUARIO_GENERO foreign key(ID_GENERO) references GENERO(ID_GENERO) on update cascade;
alter table USUARIO add constraint fk_USUARIO_CIUDAD foreign key(ID_CIUDAD) references CIUDAD(ID_CIUDAD) on update cascade;

alter table CONCIERTO add constraint fk_CONCIERTO_GENERO foreign key(ID_GENERO) references GENERO(ID_GENERO) on update cascade;
alter table CONCIERTO add constraint fk_CONCIERTO_LOCAL foreign key (ID_LOCAL) references USUARIO(ID_USUARIO) on update cascade;
alter table CONCIERTO add constraint fk_CONCIERTO_GRUPO foreign key (ID_GRUPO) references USUARIO(ID_USUARIO) on update cascade;

alter table VOTAR_COMENTAR add constraint fk_VOTAR_COMENTAR_USUARIO_FAN foreign key(ID_FAN) references USUARIO(ID_USUARIO) on update cascade;
alter table VOTAR_COMENTAR add constraint fk_VOTAR_COMENTAR_USUARIO_VOTADO foreign key(ID_VOTADO) references USUARIO(ID_USUARIO) on update cascade;

alter table PROPONER add constraint fk_PROPONER_CONCIERTO foreign key (ID_CONCIERTO) references CONCIERTO (ID_CONCIERTO) on update cascade;
alter table PROPONER add constraint fk_PROPONER_USUARIO foreign key (ID_LOCAL) references USUARIO (ID_USUARIO) on update cascade;
alter table PROPONER add constraint fk_PROPONER_GRUPO foreign key (ID_GRUPO) references USUARIO (ID_USUARIO) on update cascade;

INSERT INTO GENERO VALUES (null,"ROCK");
INSERT INTO GENERO VALUES (null,"POP");
INSERT INTO GENERO VALUES (null,"GRUNGE");
INSERT INTO GENERO VALUES (null,"HEAVY METAL");

INSERT INTO CIUDAD VALUES (null,"Barcelona","España");
INSERT INTO CIUDAD VALUES (null,"Madrid","España");
INSERT INTO CIUDAD VALUES (null,"Nancy","Francia");
INSERT INTO CIUDAD VALUES (null,"Frankfurt","Alemania");


INSERT INTO USUARIO VALUES (null,"MUSICO","Los Suaves",null,null,"Los@Suaves.com","625478542",null,null,"Los Suaves",3,"1234",null,"lossuaves.com",1,1,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"MUSICO","Pink Floyd",null,null,"pink@floyd.com","625478542",null,null,"Pink Floyd",120,"1234",null,"pinkfloyd.com",2,2,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"MUSICO","Ivan Ferreiro",null,null,"ivan@ferreiro.com","625478542",null,null,"Ivan Ferreiro",1,"1234",null,"ivanferreiro.com",3,3,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"MUSICO","Girls",null,null,"da@girls.com","625478542",null,null,"Girls",3,"1234",null,"girls.com",1,3,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"MUSICO","Queen",null,null,"the@queen.com","625478542",null,null,"Queen",3,"1234",null,"queen.com",2,1,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"MUSICO","Mando Diao",null,null,"mando@diao.com","625478542",null,null,"Mando Diao",3,"1234",null,"mandodiao.com",2,1,"Mejor amigo de pequeño","perro","HOLA",now(),null);

INSERT INTO USUARIO VALUES (null,"LOCAL","Freedonia",null,"C/ cera","free@donia.com","625478542",null,"Freedonia",null,null,"1234",100,"freedonia.com",1,3,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"LOCAL","Razzmatazz",null,"C/ marina","razz@matazz.com","625478542",null,"Razzmatazz",null,null,"1234",100,"razzmatazz.com",1,2,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"LOCAL","Sala Apolo",null,"C/ nou rambla","sala@apolo.com","625478542",null,"Sala Apolo",null,null,"1234",100,"salapolo.com",4,3,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"LOCAL","Freedom",null,"C/ casa","free@dom.com","625478542",null,"Freedom",null,null,"1234",100,"freedom.com",1,1,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"LOCAL","Bikini",null,"C/ nose","bi@kini.com","625478542",null,"Bikini",null,null,"1234",100,"bikini.com",3,1,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"LOCAL","Tecla",null,"C/ nose","te@cla.com","625478542",null,"Tecla",null,null,"1234",100,"Tecla.com",2,2,"Mejor amigo de pequeño","perro","HOLA",now(),null);

INSERT INTO USUARIO VALUES (null,"FAN","Irene","Cabezas","C/ nose","irene@cabezas.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"FAN","Ferran","Meseguer","C/ nose","ferran@meseguer.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"FAN","Cristian","C","C/ nose","cristian@ca.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"FAN","Albert","Ba","C/ nose","albert@ba.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"FAN","Robertu","Carlos","C/ nose","robertu@carlos.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);
INSERT INTO USUARIO VALUES (null,"FAN","Emma","Ge","C/ nose","emma@ge.com","625478542",null,null,null,null,"1234",null,null,null,null,"Mejor amigo de pequeño","perro","HOLA",now(),null);


INSERT INTO VOTAR_COMENTAR VALUES (null,13,1,1,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,2,2,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,3,3,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,4,4,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,5,5,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,6,4,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,1,3,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,3,0,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,2,5,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,6,2,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,5,4,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,4,5,TRUE,"NORMAL","2017-1-1","A");

INSERT INTO VOTAR_COMENTAR VALUES (null,13,1,1,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,2,2,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,3,3,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,4,4,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,5,5,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,6,3,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,1,0,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,3,0,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,2,5,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,6,4,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,5,4,FALSE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,4,3,FALSE,"NORMAL","2017-1-1","A");

INSERT INTO VOTAR_COMENTAR VALUES (null,13,7,1,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,8,2,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,9,3,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,10,4,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,11,5,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,13,12,2,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,7,2,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,8,5,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,9,1,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,10,2,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,11,1,FALSE, "NORMAL", now(), "A");
INSERT INTO VOTAR_COMENTAR VALUES (null,14,12,4,FALSE, "NORMAL", now(), "A");

INSERT INTO CONCIERTO VALUES(null,1,7,"2018-3-4",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,2,8,"2018-3-4",1,10,TRUE,100,TRUE,1,2);
INSERT INTO CONCIERTO VALUES(null,3,9,"2018-3-4",1,10,TRUE,100,TRUE,1,1);
INSERT INTO CONCIERTO VALUES(null,4,10,"2018-5-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,5,11,"2018-5-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,6,12,"2018-5-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,1,12,"2017-1-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,2,11,"2017-1-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,3,10,"2017-1-1",1,10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,4,9,"2017-1-2",1,10,TRUE,100,TRUE,1,2);
INSERT INTO CONCIERTO VALUES(null,5,8,"2017-1-2",1,10,TRUE,100,TRUE,1,2);
INSERT INTO CONCIERTO VALUES(null,6,7,"2017-1-2",1,10,TRUE,100,TRUE,1,2);
INSERT INTO CONCIERTO VALUES(null,1,12,"2017-1-3",1,10,TRUE,100,TRUE,4,3);
INSERT INTO CONCIERTO VALUES(null,6,9,"2017-1-3",1,10,TRUE,100,TRUE,4,3);
INSERT INTO CONCIERTO VALUES(null,5,8,"2017-1-3",1,10,TRUE,100,TRUE,4,3);

INSERT INTO TRACE VALUES(null, 'REGISTRO', 'Girls', now(), null, 'NUEVO MUSICO',null); 
INSERT INTO TRACE VALUES(null, 'REGISTRO', 'Fan 1', now(), true, 'NUEVO FAN',null); 
INSERT INTO TRACE VALUES(null, 'REGISTRO', 'Sala Apolo', now(), true, 'NUEVO LOCAL',null); 

INSERT INTO TRACE VALUES(null, 'CONCIERTO', 'Los Suaves-Freedonia', now(), 1, 'NUEVO CONCIERTO',1);
