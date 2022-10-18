# Projet Todo

## Installation & démarrage

- Copier .env-example à .env puis le remplir
- Copier .phinx-example.yml à phinx.yml puis le remplir
- Executer la commande: docker-compose up

### Base de données

La base de données fonctionne avec des migrations.

La commande pour gérer les migrations est : `vendor/bin/phinx help`

## Feuilles de style 

### Base SCSS
Le fichier princpal est `global.css` et doit être compilé au format CSS. Il s'occupe d'importer bootstrap et de combiner les autres fichiers au format SCSS. Il doit uniquement être modifié si un fichier SCSS doit être ajouté.

### Couleurs SCSS

Plusieurs fichiers de thèmes existent, avec un nom selon le format suivant : `theme-nom.scss`. Ils sont importés et combinés par `public/assets/scss/global.scss`. Ces fichiers modifient uniquement les propriétés bootstrap des éléments au niveau des couleurs. Lorsqu'une propriété est ajoutée, elle doit l'être dans chaque fichier `theme-nom.scss`.
Attention : le thème par défaut est une "copie" de `theme-dark.scss` au format CSS (voir [ici](#couleurs-css)).

### Layout SCSS

C'est le fichier `layout.scss`. Il est importé et combiné par `public/assets/scss/global.scss`. Il modifie les propriétés bootstrap des éléments au niveau de leur comportement.
Attention : ce fichier est différent du ficher de même nom situé dans `public/assets/css/layout.css` (voir [ici](#layout-css)).

### Base CSS

On y retrouve la version compilée du fichier SCSS `public/assets/scss/global.scss` (voir [ici](#base-scss)). Ce fichier ne doit pas être modifié et doit être importé comme stylesheet dans le HTML.

### Couleurs CSS 
Les thèmes sont gérés par des fichiers au format SCSS (voir #lien). Cependant, le thème par défaut doit être au format CSS et importé comme stylesheet dans le HTML. On retrouve donc le fichier `theme-default.css` qui reprend les propriétés du fichier `public/assets/scss/theme-dark.scss` (voir [ici](#couleurs-scss)). Ainsi, si `theme-dak.scss` est modifié, il faut procéder manuellement à la modification dans `theme-default.css` (en CSS !).

### Layout CSS
C’est le fichier `layout.css`. Il doit être importé comme stylesheet dans le HTML. Contrairement au fichier `layout.scss` (voir [ici](#layout-scss)), il modifie les propriétés des nouveaux éléments non pris en charge par bootstrap (comportement et parfois couleurs).
