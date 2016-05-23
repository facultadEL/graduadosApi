create table puntaje
(
    id serial primary key,
    descuento_fk integer references decuento(id),
    alumno_fk integer references alumno(id_alumno), 
    puntuacion integer,
    comentario character varying
)