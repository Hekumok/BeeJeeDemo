<?

$dsn = 'mysql:host=localhost;dbname=beejee';
$username = 'hekumok';
$password = 'admin';
$options = [
  \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
  \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
  \PDO::ATTR_EMULATE_PREPARES   => false,
];

$db = new \PDO($dsn, $username, $password, $options);

?>