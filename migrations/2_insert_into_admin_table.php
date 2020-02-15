<?

include_once('../db.php');

$db->query('INSERT INTO admin (login, password) VALUES ("admin", "' . password_hash('123', PASSWORD_DEFAULT) . '")');

?>