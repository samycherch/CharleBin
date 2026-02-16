\# Rapport Qualité de développement



\*\*Nom :\*\* Samy Cherchari







\## 1. Compte-rendu des manipulations (TD 1 à 6)







\### TD 1 : Maîtrise de Git (Fondamentaux)



Nous avons posé les bases de l'utilisation de Git



&nbsp;- Concepts clés : Utilisation du Working Directory (fichiers locaux), de la Staging Area (préparation) et du Repository (historique).



&nbsp;- Configuration : Paramétrage du user.name et user.email pour signer les commits.



&nbsp;- Flux de travail : Initialisation d'un dépôt (git init) ou clonage (git clone), ajout de fichiers (git add) et création de commits documentés (git commit -m).



&nbsp;- Navigation : Utilisation de git status pour vérifier l'état des fichiers et git log pour l'historique.







\### TD 2 : Travail Collaboratif avec GitHub



L'objectif est d'apprendre à synchroniser son travail et à gérer des contributions externes.



&nbsp;- Remotes : Liaison d'un dépôt local à un serveur distant (git remote add origin) et utilisation des clés SSH.



&nbsp;- Synchronisation : Publication de code (git push) et récupération des mises à jour (git pull).



&nbsp;- Pull Requests (PR) : Processus complet pour proposer des modifications : création d'une branche isolée, push, ouverture de la PR sur GitHub, et revue de code.



&nbsp;- Documentation de projet : Mise en place des fichiers essentiels : README.md (présentation), CONTRIBUTING.md (règles) et un template de PR.







\### TD 3 : Les Linters (Qualité de Code)



On cherche à analyser et à corriger un code.



&nbsp;- \*\*Outils installés via Composer :\*\*



&nbsp; - PHP Lint



&nbsp; - PHP Code Sniffer (phpcs)



&nbsp; - PHP Mess Detector (phpmd) : Détecte le code trop complexe ou non optimisé.







\- \*\*Automatisation :\*\*



&nbsp; - Création d'une commande make lint dans un Makefile.



&nbsp; - Utilisation de PHP CS Fixer pour corriger automatiquement les erreurs de style.



&nbsp; - Mise en place de Pre-commit hooks pour interdire un commit si le code n'est pas propre.







On nous a aussi demandé de corriger 5 erreurs dans le code :



\*\*5 | ERROR   | \[ ] Doc comment long description must start with a capital letter\*\*



\*\*11 | ERROR   | \[ ] Missing @category tag in file comment\*\*



\*\*11 | ERROR   | \[ ] Missing @package tag in file comment\*\*



\*\*11 | ERROR   | \[ ] Missing @author tag in file comment\*\*



\*\*33 | ERROR   | \[ ] Doc comment short description must start with a capital letter\*\*







\### TD 4 : Outils de Développement (Dev Tools)



Le but de ce TD a été d'améliorer le confort du développeur avec l'utilisation d'un bon IDE bine configuré, l'utilisation d'agent IA afin de nous aider durant le développement, l'utilisation de l'inspecteur du navigateur, ...







\### TD 6 : Introduction aux Tests



Apprentissage des différents niveaux de tests pour sécuriser l'application.



&nbsp;- Tests Unitaires : Tests de fonctions isolées (ici sur le projet NetFLOP) avec PHPUnit.



&nbsp;- Tests E2E (End-to-End) : Simulation du parcours d'un utilisateur réel dans le navigateur avec Cypress.



&nbsp;- Intégration Continue (CI) : Automatisation du lancement des tests et des linters sur chaque PR via les GitHub Actions pour empêcher le merge de code défectueux











---







\## 2. Objectifs des Tests Unitaires (8 tests)







J'ai réalisé \*\*8 tests unitaires\*\* couvrant deux parties critiques du projet : les \*\*Actions\*\* et le \*\*Repository\*\*.







\### A. Partie Repository (4 tests)



L'objectif est de valider la récupération des données sans dépendre d'un serveur MySQL actif.



\- \*\*Fichiers testés\*\* : `src/classes/repository/Repository.php`



\- \*\*Tests réalisés\*\* :



&nbsp;   1. `testGetAllSeries()` : Vérifie que la liste des séries n'est pas vide et contient les bonnes données.



&nbsp;   2. `testGetSerieById()` : Vérifie la récupération précise d'une série par son ID.



&nbsp;   3. `testGetUserByEmail()` : Valide la recherche d'un utilisateur pour l'authentification.



&nbsp;   4. `testGetEpisodeBySerieIdEmpty()` : Vérifie le comportement lorsqu'une série n'a pas encore d'épisodes.







\### B. Partie Actions (4 tests)



L'objectif est de tester la logique de présentation et la gestion des sessions.



\- \*\*Fichiers testés\*\* : `SigninAction.php` et `LogoutUserAction.php`



\- \*\*Tests réalisés\*\* :



&nbsp;   1. `testSigninActionGetForm()` : Vérifie que l'affichage du formulaire de connexion contient bien les mots-clés attendus.



&nbsp;   2. `testSigninActionPostFailure()` : Simule un échec de connexion et vérifie l'affichage du message d'erreur.



&nbsp;   3. `testLogoutActionCleansSession()` : Vérifie que la déconnexion supprime bien les données de l'utilisateur en session.



&nbsp;   4. `testLogoutActionHtml()` : Vérifie que le lien de redirection après déconnexion est correct.







---







\## 3. Choix Techniques et Extraits de Code







\### Utilisation de SQLite en mémoire



Pour garantir que les tests fonctionnent partout (indépendance du réseau et du serveur), j'ai utilisé une base de données \*\*SQLite `:memory:`\*\*. Elle est créée et détruite instantanément à chaque exécution de test.







\### Injection par Réflexion PHP (Astuce technique)



La classe `Repository` étant un Singleton avec un constructeur privé qui tente une connexion MySQL, il était difficile de la tester. J'ai utilisé la \*\*Réflexion PHP\*\* pour forcer l'injection de SQLite.







\*\*Extrait du `setUp()` dans `RepositoryTest.php` :\*\*



```php



$reflector = new ReflectionClass(Repository::class);







$configProperty = $reflector->getProperty('config');



$configProperty->setValue(null, \['host' => 'localhost', 'database' => 'test']);







$this->repo = $reflector->newInstanceWithoutConstructor();







$pdoProperty = $reflector->getProperty('pdo');



$pdoProperty->setValue($this->repo, new PDO('sqlite::memory:'));



```







\## 4. Exécution des tests



Pour lancer la suite de tests, utilisez la commande suivante à la racine du dossier NetFlop :







Bash







php vendor/phpunit/phpunit/phpunit tests



Résultat attendu :



Runtime:       PHP 8.2.12



Configuration: C:\\Users\\samyc\\IUT\\S4\\QDev\\s3\\Projet\_NetFLOP\\NetFlop\\phpunit.xml







........                                                            8 / 8 (100%)







Time: 00:16.354, Memory: 8.00 MB







OK (8 tests, 12 assertions)







\*\*Voici le lien git pour accéder a CharleBin :\*\*



git@github.com:samycherch/CharleBin.git

