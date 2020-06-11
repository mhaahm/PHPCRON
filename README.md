# Description:
c'est une classe php qui permet de lancer une tache planifié.<br/>
Le script est alimenté par une base de données sqlite.<br/>

Pour utiliser la classe, il faut lancre le script install.php en ligne de commande.<br/>

php install.php

ensuite il faut importer le namespace dans un script lancer en continue / arrière plan

```php
<?php
require_once __DIR__."/vendor/autoload.php";
use PCRON\Pcron;


$pcron = new Pcron();
$pcron->runCron();

