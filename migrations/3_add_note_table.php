<?

include_once('../db.php');

$db->query('CREATE TABLE note (
  id    INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  text  TEXT NOT NULL
)');

?>