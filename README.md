# Projet Web CIR1 Semestre 1

Participants :

- Lewandowski Léo
- Le Roux Zielinski Sasha
- Leroy Simon
- Lebrun Adèle
- Van Uytvanck Mathis

## Informations importantes

Apache est nécessaire afin de faire tourner le site, Nginx ou autre ne supportant pas les fichier `.htaccess`

2 extensions PHP sont nécessaires afin de faire tourner ce site, elles sont déjà préinstallées dans la plupart des stacks utilisant PHP et Apache, mais généralement non installées. Veuillez donc avant de lancer le site :

- Ouvrir le fichier `php.ini`
- Vérifier que la ligne `extension = gettext` est présente _sans `;` avant la ligne_, sinon la rajouter
- Vérifier que la ligne `extension = gd` est présente, sinon la rajouter

`gettext` est utilisée pour la traduction anglais / français, et `gd` est une extension de manipulation d'images, utilisée lors de la création d'un compte pour créer une photo de profil

## Détails du projet

Thème :
Site web d'une entreprise horlogère innovante

Pages :

- Accueil
- Contact
- Produits
  - Page détail pour chaque produit (1 seule page qui change en fonction du produit)
- Histoire de l'entreprise
- Concept de la montre octale
- Login / Création de compte (Même page)
- Equipe de développement
- Mentions légales
- Contact : message avec sujet, contenu, et image facultative. L'utilisateur doit être connecté pour pouvoir envoyer un message
- Page de gestion de compte :
  - Langue d'affichage (Anglais & Français supportés)
  - Nom, prénom, adresse email et autres informations relatives au compte
  - Déconnexion
  - Suppression du compte
- Page de panier :
  - Suppression des éléments du panier
  - Modification des éléments du panier
- Panel admin :
  - Suppression, modification et ajout de produits (nom, description en français et en anglais, image, prix, système temporel, matière du bracelet)
  - Visualisation des messages envoyés sur la page contact
- Page 404 en cas de mauvaise requête ou de page à laquelle l'utilisateur n'a pas d'accès

Autres :

- Les éléments aparaissant dans toutes les pages web (footear, head, header, nav, etc.) sont stockés dans un fichier PHP à part, requis via PHP dans toutes les pages. Permet d'apporter des modifications plus rapidement à ces éléments
- URL Rewrite pour embellir l'URL : `<site>/<chemin de page>` va afficher la page située dans `<site>/pages/<chemin de page>`. De plus, si l'extension `.php` n'apparaît pas dans l'URL donné par le client, le serveur le rajoute automatiquement

## Accès aux comptes

Deux comptes ont été préalablement créés :

- `admin@junia.com` : MdP = `Admin_1234`, compte administrateur
- `test@junia.com` : MdP = `Test_123`, compte utilisateur normal

D'autres comptes peuvent être créées via la page "Création de compte" sans aucun souci
