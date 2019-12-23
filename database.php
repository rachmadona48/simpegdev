<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => '10.15.3.197',
// 	'username' => 'postgres',
// 	'password' => 'kom1nfo2oi5!!',
// 	'database' => 'dbkepeg',
// 	'dbdriver' => 'postgre',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

/* $db['ekinerja'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.34.22',
	'username' => 'postgres',
	'password' => 'mohonizinmasuk',
	'database' => 'ekinerja',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/

/* $db['ekinerja16'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.34.22',
	'username' => 'postgres',
	'password' => 'mohonizinmasuk',
	'database' => 'ekinerja_2016',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/

$db['etkd'] = array(
	'dsn'	=> '',
	 'hostname' => '10.15.3.100',
	 'username' => 'postgres',
	 'password' => 'Eabsensi18!',
	 'database' => 'dbets',

	// 'hostname' => '10.15.34.61',
	// 'username' => 'postgres',
	// 'password' => '123456',
	// 'database' => 'ekinerja_2016',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['ekinerja16'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.34.61',
	'username' => 'postgres',
	'password' => '123456',
	'database' => 'ekinerja_2016',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['ekinerja'] = array(
 	'dsn'	=> '',
 	'hostname' => '10.15.34.61',
 	'username' => 'postgres',
 	'password' => '123456',
 	'database' => 'ekinerja',
 	'dbdriver' => 'postgre',
 	'dbprefix' => '',
 	'pconnect' => FALSE,
 	'db_debug' => (ENVIRONMENT !== 'production'),
 	'cache_on' => FALSE,
 	'cachedir' => '',
 	'char_set' => 'utf8',
 	'dbcollat' => 'utf8_general_ci',
 	'swap_pre' => '',
 	'encrypt' => FALSE,
 	'compress' => FALSE,
 	'stricton' => FALSE,
 	'failover' => array(),
 	'save_queries' => TRUE
);

// $db['ekin234'] = array(
// 	'dsn'	=> '',
// 	'hostname' => '10.15.3.234',
// 	'username' => 'postgres',
// 	'password' => 'password15!!',
// 	'database' => 'ekinerja',
// 	'dbdriver' => 'postgre',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

/* $db['ekin234'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.34.22',
	'username' => 'postgres',
	'password' => 'mohonizinmasuk',
	'database' => 'ekinerja_2016',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/

/*$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.30)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = SIMPEG)))',
	'username' => 'simpeg',
	'password' => 'p102simp',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);*/

/*$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.74)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = dbpemerintah)))',
	'username' => 'simpegdev',
	'password' => 'simpegdev',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);*/

/* $db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.30)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = simpegdev)))',
	'username' => 'simpegnew',
	'password' => 'simpegnew',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/

// 'username' => 'simpegnew08',
// 	'password' => '123456',
// 'username' => 'simpegnew',
// 	'password' => 'simpegnew',


/*$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.61)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = simpegdev)))',
	'username' => 'simpegopd17',
	'password' => '123456',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.61)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = simpegdev)))',
	'username' => 'simpegopd17',
	'password' => '123456',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

//KONEKSI BATCHING TESTING DEV2

 $db['batch'] = array(
 	'dsn'	=> '',
 	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.61)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = SIMPEGDEV)))',
 	'username' => 'simpegopd17',
 	'password' => '123456',
 	'database' => '',
 	'dbdriver' => 'oci8',
 	'dbprefix' => '',
 	'pconnect' => FALSE,
 	// 'db_debug' => (ENVIRONMENT !== 'production'),
 	'cache_on' => FALSE,
 	'cachedir' => '',
 	'char_set' => 'utf8',
 	'dbcollat' => 'utf8_general_ci',
 	'swap_pre' => '',
 	'db_debug' => FALSE,
 	'encrypt' => FALSE,
 	'compress' => FALSE,
 	'stricton' => FALSE,
 	'failover' => array(),
 	'save_queries' => TRUE
 ); 


$db['DBfile'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.34.186',
	'username' => 'admin_file_dev',
	'password' => 'efile123_dev',
	'database' => 'e_file_dev',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

//juni2017

/*$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.61)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = simpegdev)))',
	'username' => 'simpegnew08',
	'password' => '123456',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);*/

/* $db['ORP1'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.6)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = ORP1)))',
	'username' => 'qsimpeg',
	'password' => 'qsimpp102',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
/*

/* $db['29'] = array(
	'dsn'	=> '',
	'hostname' => '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.34.29)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = SIMPEG)))',
	'username' => 'simpeg',
	'password' => 'dkis1mp3gn3w',
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
*/