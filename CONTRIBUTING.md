# Guide de Contribution à CharleBin

Merci de votre intérêt pour contribuer à CharleBin ! Ce document décrit les règles et le processus pour soumettre vos contributions.

---

## Prérequis

Avant de commencer, assurez-vous d'avoir :

- PHP 8.0 ou supérieur
- Composer pour la gestion des dépendances PHP
- Git configuré avec votre identité

---

## Installation en local

### 1. Cloner le repository
```bash
git clone git@github.com:samycherch/CharleBin.git
cd CharleBin
```

### 2. Installer les dépendances
```bash
php bin/composer install
```

### 3. Configurer l'application
```bash
copy cfg/conf.sample.php cfg/conf.php
```

### 4. Lancer le serveur de développement
```bash
php -S localhost:8080
```

L'application sera accessible sur `http://localhost:8080` 🎉

---
## Processus de contribution

### Créer une nouvelle branche

Assurez-vous d'être sur `main` et créez une branche pour votre contribution :
```bash
git checkout main
git pull origin main
git switch -C nom-de-votre-fonctionnalite
```

**Nommage des branches :**

| Type | Format | Exemple |
|------|--------|---------|
| Nouvelle fonctionnalité | `feature/nom` | `feature/dark-mode` |
| Correction de bug | `fix/nom` | `fix/memory-leak` |
| Tâche technique | `chore/nom` | `chore/update-deps` |

### Développer votre contribution

- Effectuez vos modifications
- Créez des commits réguliers avec des messages clairs
- Suivez les standards de code (voir section suivante)

### Tester votre code

Avant de pousser votre code, vérifiez :
```bash
# Vérifier la syntaxe PHP
php -l chemin/vers/fichier.php

# Lancer les linters
.\lint.ps1

# Lancer les tests unitaires
.\vendor\bin\phpunit tst

# Tester manuellement l'application
php -S localhost:8080
```

### Pousser votre branche
```bash
git push -u origin nom-de-votre-fonctionnalite
```

### Ouvrir une Pull Request

Sur GitHub, cliquez sur **"Compare & pull request"** et remplissez le template fourni.

---

## Standards de code

### PHP

- Respect du standard **PSR-12**
- Indentation : **4 espaces**
- Nommage en **anglais**
- Pas de code mort ou commentaires inutiles

### JavaScript

- Conserver la structure modulaire existante
- Code commenté si complexité

### Frontend

- Respecter les politiques de sécurité (**CSP**)
- Tester la compatibilité navigateur

---

## Linters et outils de qualité

Le projet utilise plusieurs linters pour garantir la qualité du code.

### PHP Lint

Vérification de la syntaxe PHP :
```bash
find . -type f -name '*.php' -not -path './vendor/*' -exec php -l {} \;
```

### PHP CodeSniffer

Vérification du respect des standards PSR :
```bash
.\vendor\bin\phpcs --extensions=php --standard=PSR12 .\lib
```

### PHP Mess Detector

Détection de code smell et problèmes potentiels :
```bash
.\vendor\bin\phpmd .\lib ansi codesize,unusedcode,naming
```

### PHP CS Fixer

Correction automatique du formatage :
```bash
.\vendor\bin\php-cs-fixer fix --config=.php-cs-fixer.dist.php .\lib
```

### Commandes groupées (Windows)

**Vérifier le code :**
```powershell
.\lint.ps1
```

**Corriger automatiquement :**
```powershell
.\fix.ps1
```

---

## Pre-commit Hook

Un pre-commit hook est disponible pour vérifier automatiquement le code avant chaque commit.

### Installation

Le hook doit être copié depuis `hooks/pre-commit.sample` vers `.git/hooks/pre-commit`.

**Windows (PowerShell) :**
```powershell
Copy-Item hooks\pre-commit.sample .git\hooks\pre-commit
```

**Linux/Mac :**
```bash
cp hooks/pre-commit.sample .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

### Fonctionnement

Le hook s'exécute automatiquement avant chaque commit et :

1. Corrige automatiquement le formatage avec **PHP CS Fixer**
2. Vérifie le code avec **PHPMD**
3. Bloque le commit si des erreurs critiques sont détectées

### Bypass (déconseillé)

En cas d'urgence, vous pouvez bypasser le hook avec :
```bash
git commit --no-verify
```

> **Attention** : Cette pratique est fortement déconseillée car elle contourne toutes les vérifications de qualité.

---

## Règles pour une bonne Pull Request

Une PR doit :

| Critère | Description |
|---------|-------------|
| **Contexte clair** | Expliquez ce que fait votre PR et pourquoi |
| **Un seul problème** | Une PR = une fonctionnalité ou un bug |
| **Fonctionner en local** | Testez avant de soumettre |
| **Passer tous les tests** | `.\vendor\bin\phpunit tst` doit être vert |
| **Commits explicites** | Décrivez votre démarche |
| **Être propre** | Pas de code de debug, commentaires superflus ou code mort |
| **Être compréhensible** | Nommage clair, architecture logique |
| **Respecter les conventions** | Anglais partout, standards de code |

---

## Principes architecturaux

### Principe zéro-connaissance

Le serveur ne doit **jamais** déchiffrer les données. Toute la logique de chiffrement/déchiffrement se fait côté client.

### Isolation des données

Utiliser les abstractions existantes (`lib/Data`, `lib/Persistence`) pour manipuler les données.

### Sécurité par défaut

Maintenir les en-têtes de sécurité (**CSP**, **CORS**, etc.) et ne pas introduire de failles.

### Pas de dépendances superflues

Réutiliser le code existant plutôt que d'ajouter de nouvelles dépendances.