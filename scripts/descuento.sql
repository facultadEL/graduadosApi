create table descuento
(
    id serial primary key,
    nombre character varying,
    url character varying,
    detalle character varying,
    empresa_fk integer references empresa(id)
)