This is a Laravel Sanctum App for APIs

See API endpoints in routes/api.php
See POSTMAN-exported API endpoints in __Swipeup mobile app.postman_collection.json

APIs for:
- Register user
- Login user
- Logout user
- GET Logged-in User Details API
- CRUD for a "Collection" object: Create, Read (get single record / get all records), Update, Delete.


-----------------
Install Firebase package for Laravel / Lumen: https://github.com/kreait/laravel-firebase
which is built on top of the Firebase PHP Admin SDK: https://github.com/kreait/firebase-php

Installation: https://www.twilio.com/blog/create-restful-crud-api-php-using-laravel-google-firebase

Login to https://console.firebase.google.com/
Select your project (or create a new one): https://console.firebase.google.com/project/firestore-laravel-crud/overview
From left Nav, select "Project Settings": https://console.firebase.google.com/project/firestore-laravel-crud/settings/general/web

Create a new directory in storage/app named firebase and move the JSON file there.
Add config to .env file

IMPORTANT:
# You can find the database URL for your project at
# https://console.firebase.google.com/project/_/database

FIREBASE_DATABASE_URL=https://console.firebase.google.com/project/firestore-laravel-crud/firestore/data/~2F
