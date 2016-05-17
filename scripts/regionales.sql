create table regional
(
id serial primary key,
nombre character varying,
abreviatura character varying,
habilitada boolean DEFAULT TRUE
);

INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Avellaneda','FRA');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Bahía Blanca','FRBB');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Buenos Aires','FRBA');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Chubut','FRCH');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Concepción del Uruguay','FRCU');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Concordia','FRCON');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Córdoba','FRC');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Delta','FRD');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional General Pacheco','FRGP');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Haedo','FRH');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional La Plata','FRLP');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional La Rioja','FRLR');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Mendoza','FRM');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional del Neuquén','FRN');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Paraná','FRP');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Rafaela','FRRA');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Reconquista','FRRQ');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Resistencia','FRRE');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Río Grande','FRRG');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Rosario','FRRO');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional San Francisco','FRSFCO');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional San Nicolás','FRSN');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional San Rafael','FRSR');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Santa Cruz','FRSC');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Santa Fe','FRSF');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Trenque Lauquen','FRTL');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Tucumán','FRT');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Venado Tuerto','FRVT');
INSERT INTO regional(nombre,abreviatura) VALUES('Facultad Regional Villa María','FRVM');
INSERT INTO regional(nombre,abreviatura) VALUES('Instituto Nacional Superior del Profesorado Técnico','INSPT');
INSERT INTO regional(nombre,abreviatura) VALUES('Unidad Académica Mar del Plata','MDP');