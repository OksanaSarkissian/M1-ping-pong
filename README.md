# Gestion d'Entreprise de Pièces de Ping-Pong

Ce projet est un système de gestion d'entreprise destiné à une société spécialisée dans la fabrication, l'assemblage et la vente de tables de ping-pong et de pièces et accessoires pour le ping-pong. L'objectif est de gérer automatiquement les commandes sur devis, les achats et les stocks, en remplaçant divers logiciels et tableaux disparates.

## Technologies Utilisées

- **Backend** : PHP avec Symfony
- **Base de Données** : PostgreSQL
- **Frontend** : Intégré avec Symfony
- **Serveur** : Linux Ubuntu

## Fonctionnalités Principales

- **Gestion des Pièces** :
  - Ajout, suppression, modification et hiérarchisation des pièces.
  - Suivi des pièces livrables, intermédiaires, matières premières et pièces achetées.
- **Devis et Commandes** :
  - Création de devis pour les clients.
  - Conversion des devis en commandes.
  - Suivi des délais de devis et maintien des montants fixes malgré les changements de prix.
- **Achats et Fournisseurs** :
  - Gestion des achats de pièces avec un seul fournisseur par pièce.
  - Suivi des prix d'achat, des dates de livraison prévues et réelles.
- **Fabrication** :
  - Gestion des gammes de fabrication, opérations, postes de travail et machines.
  - Suivi des réalisations, des postes de travail et des machines utilisées.
- **Comptabilité** :
  - Génération des factures au format PDF.
  - Exportation des factures et des achats à payer en format CSV.
- **Gestion des Utilisateurs** :
  - Gestion des droits des utilisateurs et de leurs accès aux différentes parties du logiciel.

## Installation

### Prérequis

- PHP 7.4 ou supérieur
- Composer
- Symfony CLI
- PostgreSQL
- Serveur Web (Apache, Nginx)
