# Application de covoiturage

## 📌 Description

Cette application web de covoiturage permet :

* aux **utilisateurs** de consulter les trajets disponibles, de créer, modifier et supprimer leurs propres trajets ;
* aux **administrateurs** de gérer les utilisateurs, les agences et l’ensemble des trajets.

Le projet a été réalisé dans le cadre d’un **devoir pédagogique**, avec une architecture MVC simple en PHP et une base de données PostgreSQL hébergée sur Supabase.

---

## 🛠️ Technologies utilisées

* **PHP 8**
* **PostgreSQL** (Supabase)
* **PDO** (accès base de données)
* **PHPUnit** (tests unitaires)
* **HTML / CSS**

---

## 📂 Structure du projet

```
backend/
├── config/
│   └── db.php
├── Controllers/
├── Database/
│   ├── schema.sql
│   └── seed.sql
├── public/
│   ├── index.php
│   └── views/
├── tests/
└── router.php
```

---

## 🗄️ Base de données

Les scripts SQL se trouvent dans :

📁 `backend/Database/`

### 1️⃣ Création de la base — `schema.sql`

```sql
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
    role VARCHAR(10) DEFAULT 'user'
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
    FOREIGN KEY (depart_id) REFERENCES agences(id),
    FOREIGN KEY (arrivee_id) REFERENCES agences(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

### 2️⃣ Jeu d’essais — `seed.sql`

```sql
INSERT INTO agences (nom) VALUES
('Paris'), ('Lyon'), ('Marseille'), ('Toulouse'), ('Nice'),
('Nantes'), ('Strasbourg'), ('Montpellier'), ('Bordeaux'),
('Lille'), ('Rennes'), ('Reims');

INSERT INTO users (nom, prenom, telephone, email, role) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'user'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', 'user'),
(...),
('Admin', 'Principal', '0100000000', 'admin@intra.fr', 'admin');

INSERT INTO trajets (depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles, user_id) VALUES
(1, 2, '2025-12-28 08:00:00', '2025-12-28 12:00:00', 4, 3, 1);
```

> ℹ️ Le jeu d’essais contient **21 utilisateurs** au total. Seuls quelques exemples sont affichés ici pour la lisibilité.

---

## 📊 Modélisation des données

### MCD (Modèle Conceptuel de Données)

➡️ Voir le fichier fourni dans le dossier `/docs` (format PDF / PNG).

### MLD (Modèle Logique de Données)

```
UTILISATEUR (id, nom, prenom, email, password, telephone, role)
AGENCE (id, nom)
TRAJET (id, date_depart, date_arrivee, places_total, places_disponibles,
        user_id, depart_id, arrivee_id)

Clés étrangères :
- TRAJET.user_id → UTILISATEUR.id
- TRAJET.depart_id → AGENCE.id
- TRAJET.arrivee_id → AGENCE.id
```

---

## 🚀 Installation et lancement

### 1️⃣ Cloner le projet

```bash
git clone https://github.com/Manue70/mon-projet.git
```

### 2️⃣ Importer la base de données

* Exécuter `schema.sql`
* Exécuter `seed.sql`

### 3️⃣ Configuration

Configurer l’accès à la base dans :

```
backend/config/db.php
```

### 4️⃣ Lancer le serveur PHP

```bash
php -S localhost:8000 -t backend/public
```

Puis ouvrir :

```
http://localhost:8000
```

---

## 🔐 Comptes de test

⚠️ **Pour des raisons de sécurité et de clarté, seuls trois comptes sont fournis, 1. admin ; 2. un utilisateurs sans trajets ; 3. un utilisateur avec trajets lui appartenant.**

### Compte administrateur

* Email : `admin@intra.fr`
* Mot de passe : `@f#bF2Q65aci`

### Comptes utilisateur

* Email : `julien.bernard@email.fr`
* Mot de passe : `R5nW@NkAr^xe`


* Email : `alexandre.martin@email.fr`
* Mot de passe : `BsxutnEZiqQk`

> Les autres comptes utilisateurs sont destinés uniquement au jeu d’essais.

---

## 🧪 Tests

Les tests unitaires sont disponibles dans le dossier :

📁 `backend/tests/`

Ils couvrent notamment :

* la connexion utilisateur (LoginController)
* la gestion des trajets (TripController)
* le modèle utilisateur

---

## ✅ Statut du projet

Projet finalisé et fonctionnel.

---

✋ *Et maintenant… adieu PHP.* 😄
