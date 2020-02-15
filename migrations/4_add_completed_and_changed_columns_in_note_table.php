<?

include_once('../db.php');

$db->query('ALTER TABLE note
ADD COLUMN completed BOOLEAN NOT NULL DEFAULT 0,
ADD COLUMN changed BOOLEAN NOT NULL DEFAULT 0');

?>