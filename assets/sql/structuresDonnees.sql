create database if not exists mabagnole;

use mabagnole;

create table if not exists utilisateurs(
    id_user int auto_increment,
    nom_user varchar(50),
    cin varchar(6) unique,
    role varchar(20) default 'client',
    email varchar(100) unique not null,
    mot_passe_hash varchar(100) not null,
    telephone varchar(13),
    adresse varchar(250),
    ville varchar(100),
    statut boolean default 1,
    PRIMARY KEY(id_user)
);

create table if not exists categories(
    id_categorie int auto_increment,
    nom_categorie varchar(100),
    description varchar(600),
    PRIMARY KEY(id_categorie)
);

create table if not exists vehicules(
    id_vehicule int auto_increment,
    marque varchar(100),
    modele varchar(100),
    image varchar(250),
    prix float,
    disponibilite boolean default 1,
    nbr_portes int,
    nbr_places int,
    moteur varchar(100),
    boite_vitesse varchar(100),
    climatisation boolean,
    airbag boolean,
    description varchar(600),
    categorie_id int,
    PRIMARY KEY(id_vehicule),
    FOREIGN KEY(categorie_id) REFERENCES categories(id_categorie)
);

create table if not exists reservations(
    id_reservation int auto_increment,
    date_debut DateTime,
    duree int,
    lieu_depart varchar(100),
    lieu_reteur varchar(100),
    statut varchar(100),
    vehicule_id int,
    client_id int,
    PRIMARY KEY(id_reservation),
    FOREIGN KEY(vehicule_id) REFERENCES vehicules(id_vehicule),
    FOREIGN KEY(client_id) REFERENCES utilisateurs(id_user)
);

create table if not exists commentaires(
    id_commentaire int auto_increment,
    contenu varchar(300),
    note int,
    date_commentaire DateTime default current_date,
    statut varchar(100),
    client_id int,
    vehicule_id int,
    PRIMARY KEY(id_commentaire),
    FOREIGN KEY(client_id) REFERENCES utilisateurs(id_user),
    FOREIGN KEY(vehicule_id) REFERENCES vehicules(id_vehicule)
);

create table if not exists likes(
    client_id int,
    commentaire_id int,
    statut boolean,
    FOREIGN KEY(client_id) REFERENCES utilisateurs(id_user),
    FOREIGN KEY(commentaire_id) REFERENCES commentaires(id_commentaire),
    PRIMARY KEY(client_id, commentaire_id)
);

create table if not exists favoris(
    client_id int,
    vehicule_id int,
    statut boolean,
    FOREIGN KEY(client_id) REFERENCES utilisateurs(id_user),
    FOREIGN KEY(vehicule_id) REFERENCES vehicules(id_vehicule),
    PRIMARY KEY(client_id, vehicule_id)
);