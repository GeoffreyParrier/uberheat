# API Exemple - SF5 / API Platform / Docker-compose

## Mise en place

Créer un fichier `.env.local` avec les variables suivantes (remplacer les `xxxxxx` par les valeurs de configuration de votre environnement) :

```env
# pour Doctrine
DATABASE_URL=mysql://root:xxxxxxxxxxxxxxxx@db:3306/xxxxxxx?serverVersion=8.0

# Pour le conteneur MySQL
MYSQL_HOST=%
MYSQL_ROOT_PASSWORD=xxxxxxxxxxxxxxxx
```


## Lancer la pile applicative avec Docker-compose

Dans l'environnement de développement :

```bash
docker-compose -f docker-compose.yml -f docker-compose.development.yml up -d
# ou bien
composer start-dev
```

## Effectuer des requêtes

Voir la [documentation de l'API](api-doc.md)
