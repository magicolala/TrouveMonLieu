# Trouve Mon Lieu
Une brève description de votre projet et de son objectif.Trouve Mon Lieu est une application web interactive qui permet aux utilisateurs de découvrir de nouveaux endroits de manière aléatoire et amusante. L'application utilise une base de données de villes pour suggérer des destinations intéressantes aux utilisateurs, en leur fournissant des informations clés telles que le nom de la ville, sa latitude et sa longitude.

Fonctionnalités principales
Génération aléatoire de villes : Les utilisateurs peuvent cliquer sur un bouton pour obtenir une suggestion de ville aléatoire.
Informations détaillées sur les villes : Pour chaque ville suggérée, l'application affiche le nom, la latitude et la longitude.
Interface utilisateur conviviale : L'application utilise le framework CSS Tabler pour offrir une expérience utilisateur agréable et réactive.
Administration des villes : Les administrateurs peuvent ajouter, modifier et supprimer des villes dans la base de données via une interface d'administration dédiée.
Technologies utilisées
PHP 8.1
Symfony 6.2
Doctrine ORM
Twig
Tabler CSS Framework
MySQL
Public cible
Trouve Mon Lieu s'adresse à tous ceux qui cherchent à découvrir de nouveaux endroits, que ce soit pour planifier leurs prochaines vacances, trouver de l'inspiration pour un projet ou simplement satisfaire leur curiosité. L'application est particulièrement adaptée aux voyageurs, aux blogueurs, aux photographes et à tous ceux qui apprécient l'exploration et la découverte de nouvelles destinations.

Objectifs futurs
Intégration de données supplémentaires : Ajout d'informations complémentaires sur les villes, telles que des photos, des descriptions, des liens vers des ressources externes, etc.
Filtres de recherche avancés : Permettre aux utilisateurs de filtrer les suggestions de villes en fonction de critères spécifiques, tels que le pays, le continent, le climat, etc.
Partage sur les réseaux sociaux : Permettre aux utilisateurs de partager facilement leurs découvertes sur les réseaux sociaux.
Version mobile : Développer une application mobile pour iOS et Android afin d'offrir une expérience optimisée aux utilisateurs mobiles.
Trouve Mon Lieu est un projet open-source qui vise à inspirer et à encourager l'exploration du monde qui nous entoure. Nous sommes ouverts aux contributions de la communauté et nous nous réjouissons de voir l'application évoluer et s'améliorer au fil du temps.
## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- Base de données (par exemple, MySQL)

## Installation

1. Clonez le dépôt :



git clone https://github.com/votre-nom/votre-projet.git


2. Accédez au répertoire du projet :



cd votre-projet


3. Installez les dépendances avec Composer :



composer install


4. Configurez votre base de données dans le fichier `.env` :



DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name


5. Créez la base de données :



php bin/console doctrine:database:create


6. Exécutez les migrations pour créer les tables :



php bin/console doctrine:migrations:migrate


7. Lancez le serveur de développement :



symfony server:start


## Utilisation

Expliquez comment utiliser votre application, y compris les URL importantes et les fonctionnalités clés.

## Structure du projet

- `src/`: Contient le code source de l'application.
  - `Controller/`: Les contrôleurs de l'application.
  - `Entity/`: Les entités Doctrine.
  - `Repository/`: Les référentiels Doctrine.
- `templates/`: Contient les templates Twig.
- `public/`: Le répertoire public accessible par le serveur web.
- `config/`: Les fichiers de configuration de l'application.
- `migrations/`: Les fichiers de migration de la base de données.

## Licence

Indiquez sous quelle licence votre projet est distribué. Par exemple, MIT, Apache 2.0, GPL, etc.

## Contact

Ajoutez vos informations de contact ou un lien vers votre site web pour que les utilisateurs puissent vous joindre s'ils ont des questions ou des commentaires.
