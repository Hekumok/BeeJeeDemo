<?

include_once('../db.php');

$db->query('CREATE TABLE admin (
  id       INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  login    VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  UNIQUE INDEX (login)
)');

?>