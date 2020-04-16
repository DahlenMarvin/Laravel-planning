## Mise en place d'un planning avec Laravel et FullCalendar
![version](https://img.shields.io/badge/Version-v1.0.3-success)
![etat](https://img.shields.io/badge/Etat-En%20cours-orange)
![etat](https://img.shields.io/badge/Laravel-6.8.0-informational)
![etat](https://img.shields.io/badge/FullCalendar-4.3.0-informational)

Le but de ce projet est de mettre en place une solution permettant la gestion d'un planning pour les vendeuses dans un magasin. 
Le planning est fait par la responsable du magasin ou par les vendeuses elles-mêmes si le magasin ne possède pas de responsable.

Un niveau au dessus se trouve les responsables qui peuvent accéder à n'importe quel planning.

Pour le moment le code est fait vite fait, il fallait une solution fonctionnelle très rapidement, il faut donc faire un REFACTORING.

## Installation

A venir

## A faire

* [X] Mettre en place des templates de planning draggable
    * Par exemple 8H30 - 12H30 qui correspond à une matinée pour un magasin, ainsi pouvoir drag sur le calendrier ce template et choisir un employé --> Création d'un event en BDD
* [ ] Mettre en place des repositories "propres"
* [ ] Mettre en place un vrai système pour la gestion des droits (Responsable -> Responsable magasin -> Employés)
    * Pour le moment :
        * Employees : Table qui gère les employés (En lien avec user_id)
        * Users : table qui gère les deux types de responsables avec un champ type (Admin | Magasin)
        * C'est très dégueulasse comme méthode, il faut faire un truc mieux (REFACTORING)
* [ ] Créer un espace administrateur du site qui permet de gérer entièrement le système CRUD magasins etc
* [X] Ajouter un champs commentaire pour la coordinatrice
* [ ] Si planning pour une semaine précedente on refuse
* [ ] Gestion d'un employé approfondie
    * [X] Modifier nom / prénom / couleur
    * [X] Récapitulatif des heures
    * [ ] Type de contrat
    * [ ] Calcul des heures en + / - 
* [ ] Si la vendeuse signe sa semaine ==> On ne peut plus modifier les heures
* [X] Une option congé payés avec choix de la journée et l'employé
* [X] Une option Récup qui permet à une vendeuse de faire la récup de ses heures supplémentaires
* [X] Une couleur par employé sur le planning

# Changelog

Evolution de l'application par date 

## [1.0.3] - 23-03-2020

### Ajouter 

- Ajout de l'option CP sur un planning
- Ajout de l'option Récup sur un planning


## [1.0.2] - 24-02-2020

### Ajouter 

- Dans la vue sortie des signatures RH / Comptable :
    - Ajout des heures par jour 
    - Ajout des heures par semaine
    - Ajout du commentaire coordinatrice
- Ajout du magasin de l'employé dans la vue signature Coordinatrice

### Modifier

- Affichage du dimanche dans la vue pour la signature électronique
- Les champs comment dans la table signature passent en text (Anciennement String mais pas assez long)


## [1.0.1] - 21-02-2020

### Ajouter 

- Profil pour la gestion complète des informations d'un employé
- Mise en place d'une couleur personnalisée par employé sur le planning + gestion dans le profil
- Affichage des heures par jour et par semaine pour la partie magasin
- Ajout de la signature de l'employé + des heures de la semaine + de la date de saisie + d'un champs commentaire  lors de la validation de la coordinatrice

### Modifier

- Au clique sur l'ajout d'un planning, le mois proposé de base était Janvier. Maintenant on propose la bonne date avec le bon mois
