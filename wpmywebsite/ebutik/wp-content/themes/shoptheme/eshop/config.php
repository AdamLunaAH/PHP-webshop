<?php



require '../../vendor/autoload.php';


use Dotenv\Dotenv;

// Specify the path to the root directory where the .env file is located
$rootPath = __DIR__ . '../../../../../../../';
$dotenv = Dotenv::createImmutable($rootPath);
$dotenv->load();

// database config
session_start();

// // define('DBSERVER', 'localhost'); // servername.
// define('DBSERVER', '192.168.0.6'); // servername.
// // define('DBUSERNAME', 'ebutikMain'); // database username.
// define('DBUSERNAME', 'admin'); // database username.
// // define('DBPASSWORD', 'ebutikMainPassword'); //  database password.
// define('DBPASSWORD', 'password'); //  database password.
// define('DBNAME', 'ebutik'); // database name.

define('DBSERVER', $_ENV['DBSERVER']); // servername.
define('DBUSERNAME', $_ENV['DBUSERNAME']); // database username.
define('DBPASSWORD', $_ENV['DBPASSWORD']); // database password.
define('DBNAME', $_ENV['DBNAME']); // database name.


// destroy session after 30 miniutes of inactivity
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
// update session if its longer than 30 minutes
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}


?>