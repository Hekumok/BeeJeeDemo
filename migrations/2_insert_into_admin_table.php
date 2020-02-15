<?

include_once('../framework/MVCFramework.php');

$framework = BeeJee\MVCFramework::getInstance();
$db = $framework->db;

$db->query('INSERT INTO admin (login, password) VALUES ("admin", "' . password_hash('123', PASSWORD_DEFAULT) . '")');

?>