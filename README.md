# E-Commerce-Analytics
#  Data Analysis & Web Dashboard Project

Ce projet consiste à construire un site web complet visualisation de données de ventes.

L’objectif est de reproduire un workflow réel utilisé en entreprise :

* Collecte de données
* Stockage en base de données
* Analyse avec Python
* Visualisation des résultats via une interface web

---

##  Données

Les données utilisées proviennent d’un dataset (CSV) contenant des informations de ventes, telles que :

*  Date
*  Produit
*  Prix
*  Quantité
*  Ville

Ces données sont réellesKaggle .

---

##  SQL – Organisation et stockage

Une base de données (MySQL / SQLite) est mise en place pour structurer les données.

### Objectifs :

* Créer des tables adaptées au dataset
* Importer les données brutes
* Effectuer des requêtes SQL :

  * Filtrage
  * Agrégation (SUM, COUNT…)
  * Analyse par produit, ville, date

 Cette étape permet de se rapprocher des pratiques professionnelles en data.

---

##  Python – Analyse et visualisation

Python est utilisé pour exploiter les données stockées en base.

### Fonctionnalités :

* Connexion à la base SQL
* Nettoyage des données
* Calculs :

  * Chiffre d’affaires
  * Ventes par produit
  * Ventes par ville
  * Évolution temporelle

### Visualisation :

* Graphiques générés avec Matplotlib / Seaborn :

  *  Courbes (évolution des ventes)
  *  Bar charts (top produits / villes)
  *  Nuages de points

---

##  Web – Interface utilisateur

Une interface web simple est développée avec :

* PHP
* HTML / CSS
* JavaScript

### Fonctionnalités :

* Affichage des graphiques générés par Python
* Affichage des données sous forme de tableau
* Interface claire et accessible

### 🔧 Optionnel (interactivité) :

* Filtres par :

  * Date
  * Produit
  * Ville

---

##  Architecture du projet

```id="archfinal"
Projet_perso/
│── database/        # Base SQL
│── data/            # Données CSV
│── visuals/         # Graphiques générés
│── backend/         # Scripts Python
│── web/             # Interface PHP
│── README.md
```

---

##  Lancer le projet

### 1. Base de données

* Importer le fichier SQL dans MySQL / SQLite

### 2. Scripts Python

Exécuter :

* Nettoyage.py
* Traitement.py
* Visualisation.py

### 3. Application Web

* Lancer un serveur local (XAMPP / WAMP)
* Placer le dossier `web` dans `htdocs`
* Accéder via :

```id="urlfinal"
http://localhost/web
```

---

##  Compétences développées

* Manipulation de données (CSV, SQL)
* Analyse de données avec Python
* Data visualisation
* Développement web (PHP, HTML, CSS, JS)
* Structuration d’un projet complet

---

##  Objectif

Ce projet vise à démontrer la capacité à :

* Manipuler des données de bout en bout
* Construire un pipeline complet (data → web)
* Créer un dashboard simple mais fonctionnel

---

##  Auteur

Massinissa Lomani
