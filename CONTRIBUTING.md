# Guide de Contribution à CharleBin

Merci de votre intérêt pour contribuer à CharleBin ! Ce document décrit les règles et le processus pour soumettre vos contributions.

## Prérequis

Avant de commencer, assurez-vous d'avoir :
- PHP 8.0 ou supérieur
- Composer pour la gestion des dépendances PHP
- Git configuré avec votre identité

## Installation en local

1. Clonez votre fork du repository :
```bash
git clone git@github.com:samycherch/CharleBin.git
cd CharleBin
```

2. Installez les dépendances :
```bash
php bin/composer install
```

3. Configurez l'application :
```bash
copy cfg/conf.sample.php cfg/conf.php
```

4. Lancez le serveur de développement :
```bash
php -S localhost:8080
```

## Processus de contribution

### 1. Créer une nouvelle branche

Assurez-vous d'être sur `main` et créez une branche pour votre contribution :
```bash
git checkout main
git pull origin main
git switch -C nom-de-votre-fonctionnalite
```

Nommage des branches :
- `feature/nom` pour une nouvelle fonctionnalité
- `fix/nom` pour une correction de bug
- `chore/nom` pour des tâches techniques

### 2. Développer votre contribution

- Effectuez vos modifications
- Créez des commits réguliers avec des messages clairs
- Suivez les standards de code (voir section suivante)

### 3. Tester votre code

Avant de pousser votre code, vérifiez :
- La syntaxe PHP : `php -l chemin/vers/fichier.php`
- Les tests unitaires : `.\vendor\bin\phpunit tst`
- Le fonctionnement en local : testez manuellement l'application

### 4. Pousser votre branche
```bash
git push -u origin nom-de-votre-fonctionnalite
```

### 5. Ouvrir une Pull Request

Sur GitHub, cliquez sur "Compare & pull request" et remplissez le template fourni.

## Standards de code

### PHP
- Respect du standard PSR-12
- Indentation : 4 espaces
- Nommage en anglais
- Pas de code mort ou commentaires inutiles

### JavaScript
- Conserver la structure modulaire existante
- Code commenté si complexité

### Frontend
- Respecter les politiques de sécurité (CSP)
- Tester la compatibilité navigateur

## Règles pour une bonne Pull Request

Une PR doit :
- **Avoir un contexte clair** : expliquez ce que fait votre PR et pourquoi
- **Adresser un seul problème** : une PR = une fonctionnalité ou un bug
- **Fonctionner en local** : testez avant de soumettre
- **Passer tous les tests** : `.\vendor\bin\phpunit tst` doit être vert
- **Avoir des commits explicites** : décrivez votre démarche
- **Être propre** : pas de code de debug, commentaires superflus ou code mort
- **Être compréhensible** : nommage clair, architecture logique
- **Respecter les conventions** : anglais partout, standards de code

## Principes architecturaux

- **Principe zéro-connaissance** : le serveur ne doit jamais déchiffrer les données
- **Isolation des données** : utiliser les abstractions existantes (lib/Data, lib/Persistence)
- **Sécurité par défaut** : maintenir les en-têtes de sécurité
- **Pas de dépendances superflues** : réutiliser le code existant

## Processus de review

1. Un mainteneur récupère votre branche en local
2. Il effectue une review du code et des tests
3. Il peut demander des modifications
4. Discussion bienveillante pour améliorer le code ensemble
5. Une fois approuvée, la PR est mergée dans `main`