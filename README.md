Trouve Mon Lieu
===============

Trouve Mon Lieu est une application web interactive qui permet aux utilisateurs de découvrir de nouveaux endroits de manière aléatoire et amusante. L'application utilise une base de données de villes pour suggérer des destinations intéressantes aux utilisateurs, en leur fournissant des informations clés telles que le nom de la ville, sa latitude et sa longitude.

Fonctionnalités principales
---------------------------

-   Génération aléatoire de villes : Les utilisateurs peuvent cliquer sur un bouton pour obtenir une suggestion de ville aléatoire.
-   Informations détaillées sur les villes : Pour chaque ville suggérée, l'application affiche le nom, la latitude et la longitude.
-   Interface utilisateur conviviale : L'application utilise le framework CSS Tabler pour offrir une expérience utilisateur agréable et réactive.
-   Administration des villes : Les administrateurs peuvent ajouter, modifier et supprimer des villes dans la base de données via une interface d'administration dédiée.

Technologies utilisées
----------------------

-   PHP 8.1
-   Symfony 6.2
-   Doctrine ORM
-   Twig
-   Tabler CSS Framework
-   MySQL

Public cible
------------

Trouve Mon Lieu s'adresse à tous ceux qui cherchent à découvrir de nouveaux endroits, que ce soit pour planifier leurs prochaines vacances, trouver de l'inspiration pour un projet ou simplement satisfaire leur curiosité. L'application est particulièrement adaptée aux voyageurs, aux blogueurs, aux photographes et à tous ceux qui apprécient l'exploration et la découverte de nouvelles destinations.

Objectifs futurs
----------------

-   Intégration de données supplémentaires : Ajout d'informations complémentaires sur les villes, telles que des photos, des descriptions, des liens vers des ressources externes, etc.
-   Filtres de recherche avancés : Permettre aux utilisateurs de filtrer les suggestions de villes en fonction de critères spécifiques, tels que le pays, le continent, le climat, etc.
-   Partage sur les réseaux sociaux : Permettre aux utilisateurs de partager facilement leurs découvertes sur les réseaux sociaux.
-   Version mobile : Développer une application mobile pour iOS et Android afin d'offrir une expérience optimisée aux utilisateurs mobiles.

Trouve Mon Lieu est un projet open-source qui vise à inspirer et à encourager l'exploration du monde qui nous entoure. Nous sommes ouverts aux contributions de la communauté et nous nous réjouissons de voir l'application évoluer et s'améliorer au fil du temps.

Prérequis
---------

-   PHP 8.1 ou supérieur
-   Composer
-   Symfony CLI
-   Base de données (par exemple, MySQL)

Installation
------------

1.  Clonez le dépôt :

    ```
    git clone https://github.com/votre-nom/trouve-mon-lieu.git

    ```

2.  Accédez au répertoire du projet :

    ```
    cd trouve-mon-lieu

    ```

3.  Installez les dépendances avec Composer :

    ```
    composer install

    ```

4.  Configurez votre base de données dans le fichier `.env` :

    ```
    DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

    ```

5.  Créez la base de données :

    ```
    php bin/console doctrine:database:create

    ```

6.  Exécutez les migrations pour créer les tables :

    ```
    php bin/console doctrine:migrations:migrate

    ```

7.  Lancez le serveur de développement :

    ```
    symfony server:start

    ```

Utilisation
-----------

Une fois l'application installée et le serveur de développement lancé, accédez à l'URL `http://localhost:8000` dans votre navigateur web. Vous serez redirigé vers la page d'accueil de Trouve Mon Lieu, où vous pourrez cliquer sur le bouton "Générer une ville aléatoire" pour obtenir une suggestion de destination. Les informations sur la ville, y compris son nom, sa latitude et sa longitude, seront affichées à l'écran.

Pour accéder à l'interface d'administration, rendez-vous sur `http://localhost:8000/admin`. Vous pourrez alors vous connecter avec vos identifiants d'administrateur pour gérer les villes dans la base de données.

Structure du projet
-------------------

-   `src/`: Contient le code source de l'application.
    -   `Controller/`: Les contrôleurs de l'application.
    -   `Entity/`: Les entités Doctrine.
    -   `Repository/`: Les référentiels Doctrine.
-   `templates/`: Contient les templates Twig.
-   `public/`: Le répertoire public accessible par le serveur web.
-   `config/`: Les fichiers de configuration de l'application.
-   `migrations/`: Les fichiers de migration de la base de données.

Contribution
------------

Nous accueillons les contributions de la communauté pour améliorer Trouve Mon Lieu. Si vous souhaitez contribuer, veuillez suivre les étapes suivantes :

1.  Fork le dépôt
2.  Créez une nouvelle branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3.  Committez vos modifications (`git commit -m 'Ajouter une nouvelle fonctionnalité'`)
4.  Poussez vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5.  Ouvrez une Pull Request

Licence
-------

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.

Contact
-------

Si vous avez des questions, des suggestions ou des commentaires, n'hésitez pas à nous contacter à l'adresse suivante : contact@trouve-mon-lieu.com

Vous pouvez également visiter notre site web : [www.trouve-mon-lieu.com](command:_cody.vscode.open?%22https%3A%2F%2Fwww.trouve-mon-lieu.com%22)

Nous espérons que vous apprécierez l'utilisation de Trouve Mon Lieu et que cette application vous inspirera à explorer de nouveaux endroits !
