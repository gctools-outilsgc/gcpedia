<?php

## Database credentials
$wgDBuser = (getenv('DBUSER') != '') ? getenv('DBUSER') : 'wiki';
$wgDBpassword = (getenv('DBPASS') != '') ? getenv('DBPASS') : 'gcpedia';

#$wgSecretKey = "";
$GAaccount = 'UA-xxxxxxx-x';