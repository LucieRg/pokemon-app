# Pokédex App

## Description

Le projet Pokédex est une application qui permet aux utilisateurs de rechercher, ajouter, modifier et supprimer des Pokémon. 
L'application présente une interface où les utilisateurs peuvent explorer les informations sur divers Pokémon, y compris leur nom, image, hauteur, poids, types et capacités.

## Fonctionnalités

- Rechercher des Pokémon par nom.
- Afficher les détails d'un Pokémon sélectionné.
- Ajouter, modifier et supprimer des Pokémon.
- Stockage des données via une base de données.

## Prérequis

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Installation

1. **Clonez le dépôt :**

   ```bash
   git clone https://github.com/LucieRg/pokemon-app.git
   ```

2. **Construisez l'image Docker et démarrez les conteneurs :**

   ```bash
   docker-compose up --build
   ```

   Cela démarrera le serveur web et la base de données.

 3. **Exécutez les migrations (si nécessaire):**
    
    ```bash
      docker-compose exec php bin/console doctrine:migrations:migrate
    ```

## Utilisation

### Accéder à l'application

Une fois les conteneurs en cours d'exécution, vous pouvez accéder à l'application en ouvrant votre navigateur à l'adresse suivante :

```
http://localhost:80/home
```

### Commande personnalisée

Récupérer les données de Pokémon
Pour récupérer les données des Pokémon depuis l'API et les stocker dans la base de données, exécutez la commande suivante :

```bash
docker-compose exec php bin/console app:fetch-api-data
```

## Technologies utilisées

- PHP
- Symfony
- Docker
- Twig pour le rendu des templates
- Css pour le style

## Contribuer

Les contributions sont les bienvenues ! N'hésitez pas à soumettre des demandes de tirage (pull requests) ou à ouvrir des problèmes (issues) pour toute suggestion ou bug.

