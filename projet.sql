CREATE DATABASE immobilier;

USE immobilier;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'proprietaire', 'client'),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20) UNIQUE
);

-- Admin user
INSERT INTO users (username, password, role, email, phone) VALUES
('admin', 'admin', 'admin', 'admin@gmail.com', '033333333');

-- Biens table
CREATE TABLE Bien (
    idBien SERIAL PRIMARY KEY,
    reference VARCHAR(20) NOT NULL,
    idTypeBien INT REFERENCES typeBien(idTypeBien),
    nom VARCHAR(50) NOT NULL,
    region VARCHAR(50) NOT NULL,
    loyerparmois DOUBLE PRECISION NOT NULL,
    idProprietaire INT REFERENCES users(id)
);

-- Commissions table
CREATE TABLE typeBien (
    idTypeBien SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    commission DOUBLE PRECISION NOT NULL
);

CREATE TABLE locations_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bien_id INT,
    location_id INT,
    loyer DOUBLE PRECISION NOT NULL,
    commission DOUBLE PRECISION NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    rang INT NOT NULL,
    duree INT NOT NULL,
    FOREIGN KEY (bien_id) REFERENCES Bien(idBien),
    FOREIGN KEY (location_id) REFERENCES locations(id)
);


-- Locations table
CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bien_id INT,
    client_id INT,
    duree_mois INT,
    date_debut DATE,
    FOREIGN KEY (bien_id) REFERENCES Bien(idBien),
    FOREIGN KEY (client_id) REFERENCES users(id)
);

CREATE TABLE photoBien (
    idPhotoBien INT AUTO_INCREMENT PRIMARY KEY,
    idBien INT,
    chemin VARCHAR(100) NOT NULL,
    FOREIGN KEY (idBien) REFERENCES Bien(idBien)
);
INSERT INTO photoBien(idBien, chemin) VALUES
(1,'maison.jpg'),
(1,'maison1.jpg'),
(2,'appart.jpg'),
(2,'appart1.jpg'),
(3,'villa.jpg'),
(3,'villa1.jpg'),
(4,'immeuble.jpg'),
(4,'immeuble1.jpg');


