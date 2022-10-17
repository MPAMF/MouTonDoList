# Projet Todo

## Installation & démarrage

- Copier .env-example à .env puis le remplir
- Copier .phinx-example.yml à phinx.yml puis le remplir
- Executer la commande: `docker-compose up`

### Base de données

La base de données fonctionne avec des migrations.

La commande pour gérer les migrations est : `vendor/bin/phinx migrate`

#### Seeder la base de données (seulement en dev)

**Important:** Il faut que la base de données soit vide avant de lancer la génération de données de test. Sinon il y'aura des erreurs conséquentes.

`vendor/bin/phinx seed:run`