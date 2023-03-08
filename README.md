# PHP Technical Test

## Instructions

The goal of this PHP test is to take you to space with the 
[picture of the day by the Nasa](https://apod.nasa.gov/apod/archivepixFull.html). We want to display a page on our 
website that will show us the current picture of the day (and its description). To achieve that, NASA gives us an 
API to fetch the data from their server. Unfortunately, This API has a limit on the number of calls we can make. So we 
will store the images on our side.

Here is an example of the response by the API :

```json
{
  "date": "2021-02-13",
  "explanation": "Get out your red/blue glasses and float next to asteroid 433 Eros. Orbiting the Sun once every 1.8 years, the near-Earth asteroid is named for the Greek god of love. Still, its shape more closely resembles a lumpy potato than a heart. Eros is a diminutive 40 x 14 x 14 kilometer world of undulating horizons, craters, boulders and valleys. Its unsettling scale and unromantic shape are emphasized in this mosaic of images from the NEAR Shoemaker spacecraft processed to yield a stereo anaglyphic view. Along with dramatic chiaroscuro, NEAR Shoemaker's 3-D imaging provided important measurements of the asteroid's landforms and structures, and clues to the origin of this city-sized chunk of Solar System. The smallest features visible here are about 30 meters across. Beginning on February 14, 2000, historic NEAR Shoemaker spent a year in orbit around Eros, the first spacecraft to orbit an asteroid. Twenty years ago, on February 12 2001, it landed on Eros, the first ever landing on an asteroid's surface. NEAR Shoemaker's final transmission from the surface of Eros was on February 28, 2001.",
  "hdurl": "https://apod.nasa.gov/apod/image/2102/PIA02471_800.jpg",
  "media_type": "image",
  "service_version": "v1",
  "title": "Stereo Eros",
  "url": "https://apod.nasa.gov/apod/image/2102/PIA02471_800.jpg"
}
```
For now, we only need these informations that will be displayed on our website, and thus will be saved on our database : 

- title ;
- explanation ;
- date ;
- image.

The application will only be accessible by logged in users. To achieve that, the login process will use Google as a login provider. 

Here are the steps you may want to follow to achieve this challenge :

- **Step 1**: make a CLI command that will be executed each day to fetch the picture of the day ;
- **Step 2**: make a page to display the picture of the day. If there is no picture (say the picture of the day is a video) we will display the picture of the previous day ;
- **Step 3**: protect our app, so the picture will only be visible by a logged in user. The user will be able to connect with a Google account using Google as login provider ;
- **Step 4**: make a small documentation explaining what you did, the technologies you used etc.

To fetch pictures from the NASA API, you need an API key. It will be sent to you by email.

When you finish this challenge, send a link to your repository by email. 

## Stack

The only constraint is to use PHP (use the version you want) and this Symfony project. You will then use any library you want, any database you want.

And most of all, have fun!

# Compte Rendu

## Installation
### Lancement des containers docker 
> docker-compose up -d
### Installation des dépendances
> docker-compose exec server composer install
### Mise à jour de la base de données
> docker-compose exec server php bin/console doctrine:migrations:migrate
### Avant le lancement de l'application
- Vous devez saisir votre clé API google dans le fichier .env
- La clé "DEMO_KEY" est utilisé dans le projet pour l'api de la NASA
- Lancer la commande pour récupérer la photo du jour
>docker-compose exec server php bin/console app:get:picture-of-day
- Vous pouvez dès à présent accéder à l'application
### Lancement de l'application
> http://localhost:9000


Explication: 

J'ai utilisé le bundle "knpuniversity/oauth2-client-bundle" pour l'authentification avec Google.<br/>
J'ai créé un système d'authentification personnalisé pour pouvoir gérer la connexion avec Google (enregistrement en base de données et vérification de l'utilisateur).<br/>
J'ai ensuite renseigné cette authenticator dans le fichier services.yaml.<br/>
J'ai ensuite créé un contrôleur pour permettre la connexion avec Google.<br/>
J'ai ensuite créé une commande pour faire une requête HTTP pour récupérer l'image du jour de la NASA et l'enregistrer en base de données tout en vérifiant si l'image n'est pas déjà en base de données et si le type de document est bien une image.<br/>
Pour finir, j'ai créé une vue et un contrôleur permettant de récupérer l'image la plus récente de notre base de données et de l'afficher avec son titre et son explication.<br/>