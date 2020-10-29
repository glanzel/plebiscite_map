## About
Webapplikation acts as a Backend for umap.openstreetmap.fr/de/
and provides the posibility to 
1. Set up places
2. Search for places in the map
3. admin interface to administrate the places


## Installation

1. Create Database from Migrations dwe.sql
2. Copy app_local.php.example -> app_local.php and paste your credentials -> See ##Configuration
	-> you need a database and an email (smtp) provider 
3. lies http://kabelkopf.de/index.php/2019/10/18/apache-fuer-cakephp-vorbereiten/ (deutsch)	
	or prepare your apache for cakephp or use built in webserver
4. startup

5. prepare the map
	4.1 register at https://umap.openstreetmap.fr/de/ and set up a map.
	4.2 paste http//:YOUR_DOMAIN/points/umapJson somewhere inside  of umap
	4.3 add your map to src/bootstrap




You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.


## Configuration

Read and edit `config/app.php` and setup the `'Datasources'` and any other
configuration relevant for your application.

