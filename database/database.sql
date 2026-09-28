

-- Création de la base de données
DROP DATABASE IF EXISTS salle_sport;
CREATE DATABASE salle_sport CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE salle_sport;

-- TABLE : COACH
CREATE TABLE coach (
    id_coach   INT          NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(50)  NOT NULL,
    prenom     VARCHAR(50)  NOT NULL,
    telephone  VARCHAR(15)  NOT NULL UNIQUE,
    email      VARCHAR(100) NOT NULL UNIQUE,
    photo      VARCHAR(255),
    PRIMARY KEY (id_coach)
);

-- TABLE : DISCIPLINE
CREATE TABLE discipline (
    id_discipline INT         NOT NULL AUTO_INCREMENT,
    libelle       VARCHAR(50) NOT NULL UNIQUE,
    description   TEXT,
    PRIMARY KEY (id_discipline)
);

-- TABLE : SEANCE
CREATE TABLE seance (
    id_seance     INT           NOT NULL AUTO_INCREMENT,
    titre         VARCHAR(100)  NOT NULL,
    date_seance   DATE          NOT NULL,
    heure_debut   TIME          NOT NULL,
    duree_minutes INT           NOT NULL,
    niveau        VARCHAR(20)   NOT NULL,
    nb_places     INT           NOT NULL,
    prix          DECIMAL(10,2) NOT NULL,
    actif         BOOLEAN       NOT NULL DEFAULT TRUE,
    id_coach      INT           NOT NULL,
    id_discipline INT           NOT NULL,
    PRIMARY KEY (id_seance),
    FOREIGN KEY (id_coach)      REFERENCES coach(id_coach),
    FOREIGN KEY (id_discipline) REFERENCES discipline(id_discipline)
);

-- INSERTION DES DONNÉES

-- Coachs
INSERT INTO coach (nom, prenom, telephone, email, photo) VALUES
('Dupont',  'Jean',   '0612345678', 'jean.dupont@sport.fr',   '/photos/jean.jpg'),
('Martin',  'Sophie', '0623456789', 'sophie.martin@sport.fr', '/photos/sophie.jpg'),
('Bernard', 'Lucas',  '0634567890', 'lucas.bernard@sport.fr', '/photos/lucas.jpg'),
('Petit',   'Emma',   '0645678901', 'emma.petit@sport.fr',    '/photos/emma.jpg');

-- Disciplines
INSERT INTO discipline (libelle, description) VALUES
('Yoga',        'Discipline relaxante axée sur la respiration'),
('Musculation', 'Renforcement musculaire avec charges'),
('Cardio',      'Exercices cardiovasculaires'),
('Pilates',     'Renforcement des muscles profonds'),
('Zumba',       'Danse fitness sur rythmes latino');

-- Séances
INSERT INTO seance (titre, date_seance, heure_debut, duree_minutes, niveau, nb_places, prix, actif, id_coach, id_discipline) VALUES
('Yoga du matin',  '2025-01-15', '08:00:00', 60, 'Débutant',      15, 20.00, TRUE, 2, 1),
('Muscu avancée',  '2025-01-15', '18:00:00', 90, 'Avancé',        10, 30.00, TRUE, 1, 2),
('Cardio express', '2025-01-16', '12:00:00', 45, 'Intermédiaire', 20, 15.00, TRUE, 1, 3),
('Pilates doux',   '2025-01-16', '10:00:00', 50, 'Débutant',      12, 18.00, TRUE, 4, 4),
('Zumba party',    '2025-01-17', '19:00:00', 60, 'Intermédiaire', 25, 12.00, TRUE, 3, 5),
('Yoga avancé',    '2025-01-17', '07:00:00', 75, 'Avancé',         8, 25.00, TRUE, 2, 1),
('Muscu débutant', '2025-01-18', '17:00:00', 60, 'Débutant',      15, 20.00, TRUE, 1, 2),
('Cardio HIIT',    '2025-01-18', '18:30:00', 45, 'Avancé',        12, 22.00, TRUE, 3, 3);