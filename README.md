## Mise en place d'un planning avec Laravel et FullCalendar
![version](https://img.shields.io/badge/Version-a0.0.1-success)
![etat](https://img.shields.io/badge/Etat-En%20cours-orange)
![etat](https://img.shields.io/badge/Laravel-6.8.0-informational)
![etat](https://img.shields.io/badge/FullCalendar-4.3.0-informational)

Le but de ce projet est de mettre en place une solution permettant la gestion d'un planning pour les vendeuses dans un magasin. 
Le planning est fait par la responsable du magasin.

Un niveau au dessus se trouve les responsables qui peuvent accéder à n'importe quel planning.

Pour le moment le code est fait vite fait, il fallait une solution fonctionnelle en moins de 4 jours.

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
* [ ] Delete la route "Register" car c'est l'administrateur qui doit créer un nouveau "Magasin"
