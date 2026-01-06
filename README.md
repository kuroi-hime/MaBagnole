# 🚗 MaBagnole - Plateforme de Location de Véhicules & Blog Interactif

**MaBagnole** est une solution web complète développée pour une agence de location de voitures. Elle permet aux clients de réserver des véhicules et de laisser des avis, tout en offrant aux administrateurs un tableau de bord puissant pour piloter l'activité.

---

## 📋 Sommaire
1. [Présentation](#présentation)
2. [Fonctionnalités](#fonctionnalités)
3. [Architecture Technique](#architecture-technique)
4. [Installation](#installation)
5. [User Stories](#user-stories)

---

## 🌟 Présentation
Ce projet vise à développer une plateforme intuitive permettant aux clients de parcourir, filtrer et réserver des véhicules selon leurs besoins, tout en offrant aux administrateurs des outils de pilotage efficaces via un Dashboard complet.

**Contexte :** Mission de développement en PHP POO et SQL avec une approche orientée conception UML.

---

## 🚀 Fonctionnalités

### 👤 Espace Client
- **Réservation Intelligente** : Prise en charge des dates et lieux.
- **Filtrage AJAX** : Exploration des véhicules par catégorie sans rechargement de page.
- **Système d'Avis** : Ajout, modification et suppression (Soft Delete) d'évaluations sur les véhicules loués.
- **Recherche & Pagination** : Moteur de recherche performant et navigation par lots (PHP ou DataTable).

### 🛠️ Dashboard Administrateur
- **Statistiques** : Analyse de l'engagement utilisateur et suivi des réservations.
- **Gestion de Contenu** : CRUD complet sur les véhicules, catégories, thèmes de blog.
- **Modération** : Approbation des réservations et des articles avant publication ainsi qu'une option pour bloquer/débloquer un client.
- **Optimisation SQL** : Insertion en masse de données (véhicules, catégories).

---

## 🏗️ Architecture Technique

### Backend (Cœur du projet)
- **Langage** : PHP 8.x (Programmation Orientée Objet).
- **Base de données** : MySQL.
- **Conception** : Modélisation UML (Classes, Cas d'utilisation).

### SQL Avancé
- **Vue SQL `ListeVehicules`** : Centralise les détails techniques, les catégories et la moyenne des avis pour optimiser les temps de réponse.
- **Procédure Stockée `AjouterReservation`** : Sécurise l'insertion des données de location.

---

## 🛠️ Installation

1. **Clonage du projet** :
```bash
   git clone https://github.com/kuroi-hime/MaBagnole.git
```
