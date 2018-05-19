<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=ketabras_ketabrasan',
	'username' => 'ketabras_rahbod',
    'password' => '-hp?!*GId*q+)e)i%e',
//    'connectionString' => 'mysql:host=localhost;dbname=ketabrasan',
//	'username' => 'root',
//    'password' => '',
    'tablePrefix'=>'ym_',
    'emulatePrepare' => true,
    'charset' => 'utf8',
);