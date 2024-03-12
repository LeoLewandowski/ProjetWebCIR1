# Projet Web CIR1 Semestre 1

Participants :

- Lewandowski Léo
- Le Roux Zielinski Sasha
- Leroy Simon
- Lebrun Adèle
- Van Uytvanck Mathis

## Détails du projet

Thème :
Site web d'une entreprise horlogère

Pages :

- Accueil
- Contact
- Produits
- Histoire de l'entreprise
- Concept de la montre octale
- Login
- Register
- Equipe de développement
- Mentions légales
- Page d'affichage de montre

Autres :

- Les éléments aparaissant dans toutes les pages web (footear, head, header, nav, etc.) sont stockés dans un fichier PHP à part, requis via PHP dans toutes les pages. Permet d'apporter des modifications plus rapidement à ces éléments
- Page 404 en cas de mauvaise requête
- URL Rewrite pour embellir l'URL : `<site>/<nom de page>` va afficher la page située dans `<site>/pages/<nom de page>`. De plus, si l'extension `.php` n'apparaît pas dans l'URL donné par le client, le serveur le rajoute automatiquement

### A rajouter

- Ajout d'une base de données
- Enregistrer des produits dans la base de données
- Fetch les produits depuis la BDD avec PHP et SQL, pour les afficher automatiquement sur les pages, en utilisant les filtres
- Mettre en place un système de compte client (création de compte, login avec mdp, etc.)
