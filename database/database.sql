-- ============================================
-- 1. Création de la base de données
-- ============================================
DROP DATABASE IF EXISTS recettes_db;
CREATE DATABASE recettes_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE recettes_db;

-- ============================================
-- 2. Table : chef
-- ============================================
CREATE TABLE chef (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. Table : type_cuisine
-- ============================================
CREATE TABLE type_cuisine (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. Table : recette
-- ============================================
CREATE TABLE recette (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_chef INT NOT NULL,
    id_type_cuisine INT NOT NULL,
    CONSTRAINT fk_recette_chef
        FOREIGN KEY (id_chef) REFERENCES chef(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_recette_type_cuisine
        FOREIGN KEY (id_type_cuisine) REFERENCES type_cuisine(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
