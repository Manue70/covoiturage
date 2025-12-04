-- schema.sql - Structure PostgreSQL

CREATE TABLE agences (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    role VARCHAR(20) DEFAULT 'user',
    CHECK (role IN ('user', 'admin'))
);

CREATE TABLE trajets (
    id SERIAL PRIMARY KEY,
    depart_id INT NOT NULL,
    arrivee_id INT NOT NULL,
    date_depart TIMESTAMP NOT NULL,
    date_arrivee TIMESTAMP NOT NULL,
    places_total INT NOT NULL,
    places_disponibles INT NOT NULL,
    user_id INT NOT NULL,

    CONSTRAINT fk_depart FOREIGN KEY (depart_id) REFERENCES agences(id),
    CONSTRAINT fk_arrivee FOREIGN KEY (arrivee_id) REFERENCES agences(id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);
