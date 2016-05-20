create table empresa
(
    id serial primary key,
    nombre character varying,
    regional_fk integer references regional(id),
    imagen character varying
)