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

  public static function primaryKey() {
    return 'id';
  }

  abstract public static function tableName();

  protected static function createModel(array $fields) {
    $model = new static;

    foreach($fields as $field => $value) {
      $model->$field = $value;
    }

    return $model;
  }

  public function find(string $condition = '', array $params = []) {
    $whereCondition = empty($condition) ? '' : 'WHERE ' . $condition;
    $query = $this->db->prepare('SELECT * FROM `' . static::tableName() . '` ' . $whereCondition . ' LIMIT 1');
    $query->execute($params);
    $row = $query->fetch();

    if(!$row) {
      return null;
    }

    return static::createModel($row);
  }

  public function findAll(string $condition = '', array $params = [], int $limit = null, int $offset = null) {
    $queryStr = 'SELECT * FROM `' . static::tableName() . '`';

    if(!empty($condition)) {
      $queryStr .= ' WHERE ' . $condition;
    }

    if(!empty($limit)) {
      $queryStr .= ' LIMIT :limit';
      $params['limit'] = $limit;
    }

    if(!empty($offset)) {
      $queryStr .= ' OFFSET :offset';
      $params['offset'] = $offset;
    }

    $query = $this->db->prepare($queryStr);
    $query->execute($params);
    $res = [];

    foreach($query->fetchAll() as $row) {
      $model = static::createModel($row);

      array_push($res, $model);
    }

    return $res;
  }

  public function create(array $fields) {
    $keys = array_keys($fields);
    $values = array_values($fields);

    $query = $this->db->prepare('INSERT INTO `' . static::tableName() . '` (' . implode(',', $keys) . ') VALUES (' . implode(',', array_fill(0, count($fields), '?')) . ')');
    return $query->execute($values);
  }

  public function update(array $fields) {
    $keys = $fields;
    $values = array_map(function($key) {
      return $this->$key;
    }, $fields);

    $query = $this->db->prepare('UPDATE `' . static::tableName() . '` SET ' . implode(',', array_map(function($key) { return $key . ' = ?'; }, $keys)) . ' WHERE ' . $this->primaryKey() . ' = ?');
    return $query->execute(array_merge($values, [ $this->{$this->primaryKey()} ]));
  }

  public function count(string $condition = '', array $params = []) {
    $whereCondition = empty($condition) ? '' : 'WHERE ' . $condition;
    $query = $this->db->prepare('SELECT COUNT(*) FROM `' . static::tableName() . '` ' . $whereCondition);
    $query->execute($params);

    return $query->fetchColumn();
  }
}

?>