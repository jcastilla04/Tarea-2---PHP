CREATE DATABASE SENATIDB;
USE SENATIDB;


CREATE TABLE marcas
(
	idmarca		INT AUTO_INCREMENT PRIMARY KEY,
    marca		VARCHAR(30)				NOT NULL,
    create_at	DATETIME				NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME				NULL,
    update_at	DATETIME				NULL,
    CONSTRAINT uk_marca_mar UNIQUE(marca)
)
ENGINE = INNODB;

INSERT INTO marcas (marca)
	VALUES
    ('Toyota'),
    ('Nissan'),
    ('Volvo'),
    ('Hyundai'),
    ('KIA');
    
CREATE TABLE vehiculos
(
	idvehiculo			INT AUTO_INCREMENT PRIMARY KEY,
    idmarca				INT			NOT NULL,
    modelo				VARCHAR(50)	NOT NULL,
    color				VARCHAR(30) NOT NULL,
    tipocombustible		CHAR(3)		NOT NULL,
    peso				SMALLINT	NOT NULL,
    afabricacion		CHAR(4)		NOT NULL,
    placa				CHAR(7)		NOT NULL,
    create_at	DATETIME				NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME				NULL,
    update_at	DATETIME				NULL,
    CONSTRAINT fk_idmarca_veh FOREIGN KEY(idmarca) REFERENCES marcas(idmarca),
    CONSTRAINT ck_tipocombustible_veh CHECK(tipocombustible IN ('GSL','DSL','GNV','GLP')),
    CONSTRAINT ck_peso_vech CHECK(peso > 0),
    CONSTRAINT uk_placa_veh UNIQUE(placa)
)
ENGINE = InnoDB;    

-- CREANDO LAS NUEVAS TABLAS

CREATE TABLE sedes
(
	idsede		INT AUTO_INCREMENT PRIMARY KEY,
    sede			VARCHAR(50) NOT NULL,
    create_at	DATETIME				NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME				NULL,
    update_at	DATETIME				NULL,
    CONSTRAINT uk_sede_sed UNIQUE(idsede)
)
ENGINE = InnoDB;


INSERT INTO sedes(sede)
	VALUES
    ('Independencia'),
    ('Ica'),
    ('Ayacucho'),
    ('Piura'),
	('San Vicente'),
    ('Chincha');

CREATE TABLE empleados(
	idempleado		INT		AUTO_INCREMENT PRIMARY KEY,
    idsede			INT NOT NULL,
    apellidos		VARCHAR(60) NOT NULL,
    nombres			VARCHAR(60) NOT NULL,
    nrodocumento	CHAR(8), -- U
    fechanac		DATE	NOT NULL,
    telefono		VARCHAR(9)	NOT NULL,
    create_at	DATETIME				NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME				NULL,
    update_at	DATETIME				NULL,
    CONSTRAINT fk_idsede FOREIGN KEY(idsede) REFERENCES sedes(idsede),
    CONSTRAINT uk_nrodocumneto UNIQUE(nrodocumento)
)
ENGINE = InnoDB;


INSERT INTO empleados(idsede,apellidos,nombres,nrodocumento,fechanac,telefono)
	VALUES(2,'Castilla Maravi','Juan Javier','75065875','2004-12-04','973323783');
    


-- CREANDO PROCEDIMIENTO DE LISTAR SEDES    
DELIMITER $$
CREATE PROCEDURE spu_sedes_listar()
BEGIN 
	SELECT 
		idsede,
        sede
        FROM sedes
		WHERE inactive_at IS NULL
        ORDER BY sede;
END $$

-- CREANDO PROCEDIMIENTOS PARA LA TABLA EMPLEADOS

-- CREANDO PROCEDIMIENTO LISTAR DE EMPLEADOS
DELIMITER $$
CREATE PROCEDURE spu_empleados_listar()
BEGIN 
	SELECT 
		idempleado,
        idsede,
        apellidos,
        nombres,
        nrodocumento,
        fechanac,
        telefono
        FROM empleados
		WHERE inactive_at IS NULL;
END $$

-- CREANDO PROCEDIMIENTO BUSCAR DE EMPLEADOS
DELIMITER $$
CREATE PROCEDURE spu_empleados_buscar(IN _nrodocumento CHAR(8))
BEGIN
	SELECT 
    EM.idempleado,
    SED.sede,
    EM.apellidos,
    EM.nombres,
    EM.nrodocumento,
    EM.fechanac,
    EM.telefono
		FROM empleados EM
        INNER JOIN sedes SED ON SED.idsede = EM.idsede
        WHERE (EM.inactive_at IS NULL) AND
			  (EM.nrodocumento = _nrodocumento);
END $$

CALL spu_empleados_buscar ('72203394');

-- CREANDO PROCEDIMIENTO REGISTRAR EMPLEADOS

DELIMITER $$
CREATE PROCEDURE spu_empleados_registrar(
IN _idsede				INT,
IN _apellidos			VARCHAR(60),
IN _nombres				VARCHAR(60),
IN _nrodocumento		CHAR(8),
IN _fechanac			DATETIME,
IN _telefono		    VARCHAR(9)
)
BEGIN
	INSERT INTO empleados(idsede,apellidos,nombres,nrodocumento,fechanac,telefono)
    values(_idsede,_apellidos,_nombres,_nrodocumento,_fechanac,_telefono);
    SELECT @@last_insert_id 'idsede';
END $$
-- INSERTANDO UN DATO
CALL spu_empleados_registrar(1,'Almeyda Sanchez','Alexander Jose','72203394','2002-10-05','923240303');


INSERT INTO vehiculos
	(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
    VALUES
    (1,'Hilux','blanco','DSL',1800,'2020','ABC-111'),
    (2,'Sentra','gris','GSL',1200,'2021','ABC-112'),
    (3,'EX30','negro','GNV',1350,'2023','ABC-113'),
    (4,'Tucson','rojo','GLP',1800,'2022','ABC-114'),
    (5,'Sportage','azul','DSL',1500,'2010','ABC-115');
    
DELIMITER $$
CREATE PROCEDURE spu_vehiculos_buscar(IN _placa CHAR(7))
BEGIN
	SELECT 
    VEH.idvehiculo,
    MAR.marca,
    VEH.modelo,
    VEH.color,
    VEH.tipocombustible,
    VEH.peso,
    VEH.afabricacion,
    VEH.placa
		FROM vehiculos VEH
        INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
        WHERE (VEH.inactive_at IS NULL) AND
			  (VEH.placa = _placa);
END $$

DELIMITER $$
CREATE PROCEDURE spu_vehiculos_registrar(
IN _idmarca				INT,
IN _modelo				VARCHAR(50),
IN _color				VARCHAR(30),
IN _tipocombustible		CHAR(3),
IN _peso				SMALLINT,
IN _afabricacion		CHAR(4),
IN _placa				CHAR(7)
)
BEGIN
	INSERT INTO vehiculos(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
    values(_idmarca,_modelo,_color,_tipocombustible,_peso,_afabricacion,_placa);
    SELECT @@last_insert_id 'idvehiculo';
END $$


CALL spu_vehiculos_registrar(4,'Berlina','verde','GSL',2000,'2010','ABC-333');
CALL spu_vehiculos_registrar(4,'Creta','Azul electrico','GNV',1200,'2023','ABC-001');

DELIMITER $$
CREATE PROCEDURE spu_marcas_listar()
BEGIN 
	SELECT 
		idmarca,
        marca
        FROM marcas
		WHERE inactive_at IS NULL
        ORDER BY marca;
END $$

CALL spu_vehiculos_buscar('ABC-111');

SELECT * FROM marcas;
SELECT * FROM vehiculos;