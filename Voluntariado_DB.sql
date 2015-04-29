Create Database Voluntariado;
Use Voluntariado;

Create Table Tipo_Usuario (
	id_tipo_usuario INT NOT NULL AUTO_INCREMENT,
	nombre varchar(50) NOT NULL Unique,
	descripcion varchar(80) NOT NULL,
	PRIMARY KEY (id_tipo_usuario)
);

Create Table Provincia (
	id_provincia INT NOT NULL AUTO_INCREMENT,
	nombre_provincia varchar(50) NOT NULL UNIQUE,
	PRIMARY KEY (id_provincia)
);

Create Table Usuario (
	id_usuario INT NOT NULL AUTO_INCREMENT,
	email varchar(50) NOT NULL Unique,
	clave varchar(50) NOT NULL,
	id_tipo_usuario INT NOT NULL,
	fecha_usuario_creado datetime,
	fecha_modificado timestamp,
	PRIMARY KEY (id_usuario),
	FOREIGN KEY (id_tipo_usuario) REFERENCES Tipo_Usuario(id_tipo_usuario)
);

Create Table Administrador (
	id_administrador INT NOT NULL AUTO_INCREMENT,
	id_usuario INT NOT NULL UNIQUE,
	nombre_administrador varchar(50) NOT NULL,
	apellido_administrador varchar(50) NOT NULL,
	id_provincia INT,
	ciudad varchar(50),
	direccion varchar(90),
	PRIMARY KEY(id_administrador),
	FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
	FOREIGN KEY (id_provincia) REFERENCES Provincia(id_provincia)
);

Create Table Voluntario (
	id_voluntario INT NOT NULL AUTO_INCREMENT,
	id_usuario INT NOT NULL,
	primer_nombre varchar(30) NOT NULL,
	segundo_nombre varchar(30),
	primer_apellido varchar(30) NOT NULL,
	segundo_apellido varchar(30),
	sexo Char(1) Check (sexo in ('M', 'F')),
	tipo_identificacion varchar(20) Check(tipo_identificacion in ('Cedula', 'Pasaporte')),
	num_identificacion varchar(20),
	fecha_nacimiento date,
	ciudad_nacimiento varchar(50),
	nacionalidad varchar(50),
	estado_civil varchar(20) Check(estado_civil in ('Soltero', 'Casado', 'Divorciado', 'Viudo', 'Union Libre', 'Separado')),
	nivel_educacion varchar(20) Check(nivel_educacion in ('primaria', 'bachiller', 'universitario', 'maestria', 'doctorado')),
	ocupacion varchar(30),
	tipo_sangre Char(3) Check(tipo_sangre in ('O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-')),
	es_conductor varchar(2) Check(es_conductor in ('Si', 'No')),
	vehiculo_propio Char(2) Check(vehiculo_propio in ('Si', 'No')),
	esta_activo Char(2) Check(esta_activo in ('Si', 'No')),
	id_provincia INT,
	ciudad varchar(50),
	direccion varchar(90),
	PRIMARY KEY (id_voluntario),
	FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
	FOREIGN KEY (id_provincia) REFERENCES Provincia(id_provincia)
);

Create Table Organizacion (
	id_organizacion INT NOT NULL AUTO_INCREMENT,
	id_usuario INT NOT NULL UNIQUE,
	rnc int(9) NOT NULL UNIQUE,
	num_cuenta_banco INT,
	nombre_organizacion varchar(50) NOT NULL UNIQUE,
	tipo_organizacion varchar(50),
	id_provincia INT,
	ciudad varchar(50),
	direccion varchar(90),
	codigo_postal varchar(20),
	requiere_donacion Char(3),
	PRIMARY KEY(id_organizacion),
	FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
	FOREIGN KEY (id_provincia) REFERENCES Provincia(id_provincia)
);

CREATE TABLE Tipo_Evento (
	id_tipo_evento INT NOT NULL AUTO_INCREMENT,
	nombre_tipo_evento varchar(50) NOT NULL,
	PRIMARY KEY(id_tipo_evento)
);

Create Table Evento (
	id_evento INT NOT NULL AUTO_INCREMENT,
	nombre_evento varchar(50) NOT NULL,
	id_organizacion int NOT NULL,
	nombre_lugar varchar(90) NOT NULL,
	ciudad varchar(50),
	direccion varchar(90),
	id_provincia int NOT NULL,
	fecha_hora_inicio datetime,
	fecha_hora_fin datetime,
	id_tipo_evento int NOT NULL,
	cant_voluntarios_solicitado varchar(10),
	descripcion varchar(500),
	fecha_evento_creado datetime,
	PRIMARY KEY (id_evento),
	FOREIGN KEY (id_organizacion) REFERENCES Organizacion(id_organizacion),
	FOREIGN KEY (id_tipo_evento) REFERENCES Tipo_Evento(id_tipo_evento),
	FOREIGN KEY (id_provincia) REFERENCES Provincia(id_provincia)
);

CREATE TABLE Donacion (
	id_donacion INT NOT NULL AUTO_INCREMENT,
	id_organizacion INT NOT NULL,
	email VARCHAR(50) NOT NULL,
	nombre_completo VARCHAR(45) NOT NULL,
	tipo_tarjeta VARCHAR(45) NOT NULL,
	num_tarjeta INT NOT NULL,
	fecha_expiracion DATETIME NOT NULL,
	monto decimal(12,4) NOT NULL,
	PRIMARY KEY (id_donacion),
	FOREIGN KEY (id_organizacion) REFERENCES Organizacion(id_organizacion)
);

Create Table Temp_Organizacion (
	id_temp_organizacion INT NOT NULL AUTO_INCREMENT,
	email varchar(50) NOT NULL Unique,
	clave varchar(50) NOT NULL,
	rnc int(9) NOT NULL UNIQUE,
	num_cuenta_banco INT,
	nombre_organizacion varchar(50) NOT NULL UNIQUE,
	tipo_organizacion varchar(50),
	id_provincia INT,
	ciudad varchar(50),
	direccion varchar(90),
	codigo_postal varchar(20),
	PRIMARY KEY(id_temp_organizacion),
	FOREIGN KEY (id_provincia) REFERENCES Provincia(id_provincia)
);

Create Table Temp_Voluntario_Evento (
	id_voluntario INT NOT NULL,
	id_evento INT NOT NULL,
	PRIMARY KEY(id_voluntario, id_evento),
	FOREIGN KEY (id_voluntario) REFERENCES Voluntario(id_voluntario),
	FOREIGN KEY (id_evento) REFERENCES Evento(id_evento)
);

Create Table Voluntario_Evento (
	id_voluntario INT NOT NULL,
	id_evento INT NOT NULL,
	PRIMARY KEY(id_voluntario, id_evento),
	FOREIGN KEY (id_voluntario) REFERENCES Voluntario(id_voluntario),
	FOREIGN KEY (id_evento) REFERENCES Evento(id_evento)
);

insert into Tipo_Usuario (nombre, descripcion) Values ('administrador', 'Este es el tipo de usuario de administrador.'),
('organizacion', 'Este es el tipo de usuario de una organización.'), ('voluntario', 'Este es el tipo de usuario de voluntario.');

insert into Usuario (email, clave, id_tipo_usuario, fecha_usuario_creado) Values ('admin@admin.com', 'admin', 1, NOW());
insert into Administrador (id_usuario, nombre_administrador) Values (1, 'Administrador');
update Usuario set clave = sha('admin') where id_usuario = 1;
insert into Provincia (nombre_provincia)
Values ('Azua'), ('Bahoruco'), ('Barahona'), ('Dajabón'), ('Distrito Nacional'), ('Duarte'), ('Elías Piña'), ('El Seibo'), ('Espallat'),
('Hato Mayor'), ('Hermanas Mirabal'), ('Independencia'), ('La Altagracia'), ('La Romana'), ('La Vega'), ('María Trinidad Sanchez'),
('Monseñor Nouel'), ('Monte Cristi'), ('Monte Plata'), ('Pedernales'), ('Peravia'), ('Puerto Plata'), ('Samana'), 
('Sánchez Ramírez'), ('San Cristóbal'), ('San José de Ocoa'), ('San Juan'), ('San Pedro de Macorís'), ('Santiago'),
('Santiago Rodríguez'), ('Santo Domingo'), ('Valverde');