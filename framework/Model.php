<?
use BeeJee\MVCFramework as Framework;

abstract class Model {
  public function __construct() {
    $framework = Framework::getInstance();
    $this->db = $framework->db;
  }

  public static function model() {
    return new static;
  }

  abstract public static function tableName();

  protected static function create(array $fields) {
    $model = new static;

    foreach($fields as $field => $value) {
      $model->$field = $value;
    }

    return $model;
  }

  public function find(string $condition, array $params = []) {
    $whereCondition = empty($condition) ? '' : 'WHERE ' . $condition;
    $query = $this->db->prepare('SELECT * FROM `' . $this->tableName() . '` ' . $whereCondition . ' LIMIT 1');
    $query->execute($params);
    $row = $query->fetch();

    if(!$row) {
      return null;
    }

    return static::create($row);
  }

  public function findAll(string $condition = '', int $limit = null, int $offset = null) {
    $whereCondition = empty($condition) ? '' : 'WHERE :condition';
    $limitExpr = empty($limit) ? '' : 'LIMIT :limit';
    $offsetExpr = empty($offset) ? '' : 'OFFSET :offset';
    $query = $this->db->prepare('SELECT * from :table ' . $whereCondition . ' ' . $limitExpr . ' ' . $offsetExpr);
    $query->execute([ 'table' => static::tableName(), 'condition' => $condition, 'limit' => $limit, 'offset' => $offset ]);
    $res = [];

    while($row = $query->fetch()) {
      $model = static::create($row);

      array_push($res, $model);
    }

    return $res;
  }
}

?>