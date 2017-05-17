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
primary key (ID_USUARIO, EMAIL)
);


create table CONCIERTO(
ID_CONCIERTO int(10) not null auto_increment,
ID_GRUPO int(10) not null,
ID_LOCAL int(10) not null,
FECHA datetime not null,
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

create table VOTAR_COMENTAR(
ID_VOTO int(10) primary key not null auto_increment,
ID_FAN int(10) not null,
ID_VOTADO int(10) not null,
PUNTOS int(2) not null,
VOTO_CONCIERTO boolean not null,
COMENTARIO char(140),
FECHA datetime not null,
TIPO_VOTACION char(10) not null
);

create table PROPONER(
ID_LOCAL int(10) not null,
ID_GRUPO int(10) not null,
FECHA datetime not null,
PRECIO_CONTRATO int(5),
-- ESTADO ACEPTADO/RECHAZADO
ESTADO boolean not null,
ID_CONCIERTO int(10) not null,
primary key(ID_GRUPO, FECHA)
);

create table VOTAR_CONCIERTO(
ID_FAN int(10) not null,
ID_CONCIERTO int(10) not null,
FECHA datetime not null,
PUNTOS int(2) not null,
primary key(ID_FAN, ID_CONCIERTO, FECHA)
);

create table APUNTAR(
ID_CONCIERTO int(10) not null,
ID_USUARIO int(10) not null,
FECHA datetime not null,
primary key(ID_CONCIERTO, ID_USUARIO, FECHA)
);

create table TRACE(
ID_TRACE int(10) not null auto_increment,
TIPO char(10) not null,
VALOR char(20),
FECHA date not null,
RESULTADO boolean,
COMENTARIO char(20),
PRIMARY KEY(ID_TRACE)
);


alter table USUARIO add constraint fk_USUARIO_GENERO foreign key(ID_GENERO) references GENERO(ID_GENERO) on update cascade;
alter table USUARIO add constraint fk_USUARIO_CIUDAD foreign key(ID_CIUDAD) references CIUDAD(ID_CIUDAD) on update cascade;

alter table CONCIERTO add constraint fk_CONCIERTO_GENERO foreign key(ID_GENERO) references GENERO(ID_GENERO) on update cascade;
alter table CONCIERTO add constraint fk_CONCIERTO_LOCAL foreign key (ID_LOCAL) references USUARIO(ID_USUARIO) on update cascade;
alter table CONCIERTO add constraint fk_CONCIERTO_GRUPO foreign key (ID_GRUPO) references USUARIO(ID_USUARIO) on update cascade;

alter table VOTAR_COMENTAR add constraint fk_VOTAR_COMENTAR_USUARIO_FAN foreign key(ID_FAN) references USUARIO(ID_USUARIO) on update cascade;
alter table VOTAR_COMENTAR add constraint fk_VOTAR_COMENTAR_USUARIO_VOTADO foreign key(ID_VOTADO) references USUARIO(ID_USUARIO) on update cascade;

alter table PROPONER add constraint fk_PROPONER_CONCIERTO foreign key(ID_CONCIERTO) references CONCIERTO(ID_CONCIERTO) on update cascade;
alter table PROPONER add constraint fk_PROPONER_LOCAL foreign key(ID_LOCAL) references CONCIERTO(ID_LOCAL) on update cascade;
alter table PROPONER add constraint fk_PORPONER_GRUPO foreign key(ID_GRUPO) references USUARIO(ID_USUARIO) on update cascade;

alter table VOTAR_CONCIERTO add constraint fk_VOTAR_CONCIERTO_FAN foreign key(ID_FAN) references USUARIO(ID_USUARIO) on update cascade;
alter table VOTAR_CONCIERTO add constraint fk_VOTAR_CONCIERTO_CONCIERTO foreign key(ID_CONCIERTO) references CONCIERTO(ID_CONCIERTO) on update cascade;

alter table APUNTAR add constraint fk_APUNTAR_USUARIO foreign key(ID_USUARIO) references USUARIO(ID_USUARIO) on update cascade;
alter table APUNTAR add constraint fk_APUNTAR_CONCIERTO foreign key(ID_CONCIERTO) references CONCIERTO(ID_CONCIERTO) on update cascade;

INSERT INTO GENERO VALUES (null,"ROCK");
INSERT INTO GENERO VALUES (null,"POP");
INSERT INTO GENERO VALUES (null,"GRUNGE");
INSERT INTO GENERO VALUES (null,"HEAVY METAL");

INSERT INTO CIUDAD VALUES (null,"Barcelona","España");
INSERT INTO CIUDAD VALUES (null,"Madrid","España");
INSERT INTO CIUDAD VALUES (null,"Nancy","Francia");
INSERT INTO CIUDAD VALUES (null,"Frankfurt","Alemania");

INSERT INTO VOTAR_COMENTAR VALUES (null,8,3,5,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,8,9,5,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,9,4,5,TRUE,"NORMAL","2017-1-1","A");
INSERT INTO VOTAR_COMENTAR VALUES (null,9,6,5,TRUE,"NORMAL","2017-1-1","A");


INSERT INTO CONCIERTO VALUES(null,9,4,"2017-1-1",10,TRUE,100,TRUE,1,3);
INSERT INTO CONCIERTO VALUES(null,4,4,"2017-1-1",10,TRUE,100,TRUE,1,2);
INSERT INTO CONCIERTO VALUES(null,3,5,"2017-1-1",10,TRUE,100,TRUE,1,1);

INSERT INTO VOTAR_CONCIERTO VALUES(7,3,"2017-1-1",5);
INSERT INTO VOTAR_CONCIERTO VALUES(8,1,"2017-1-1",5);
INSERT INTO VOTAR_CONCIERTO VALUES(3,1,"2017-1-1",5);
