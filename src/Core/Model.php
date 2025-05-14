<?php

namespace App\Core;

use PDO;

abstract class Model
{
  protected static $table;
  protected static $primaryKey = []; // [id1, id2]

  /**
   * Find all records
   *
   * @param string $orderBy Column name to order by
   * @param string $direction ASC or DESC
   * @return array Array of model instances
   */
  public static function all($orderBy = null, $direction = 'ASC')
  {
    $query = "SELECT * FROM " . static::$table;

    if ($orderBy) {
      $query .= " ORDER BY $orderBy $direction";
    }

    $stmt = PDO()->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
  }

  private static function buildWhereClause(array|string|int $ids)
  {
    $keys =  static::$primaryKey;
    if (!is_array($ids)) $ids = [$ids];

    $where = [];
    foreach ($keys as $i => $key) {
      $where[] = "$key = :$key"; // [0 => 'id1 = :id1', 1 => 'id2 = :id2'] -> id1 = :id1 AND id2 = :id2
    }

    return [$keys, implode(' AND ', $where), $ids]; // id1 = :id1 AND id2 = :id2
  }

  public static function find(array|string|int $ids)
  {
    [$keys, $where, $ids] =  static::buildWhereClause($ids);
    $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . $where . ' LIMIT 1';
    $stmt = PDO()->prepare($query);

    foreach ($keys as $i => $key) {
      $stmt->bindValue(":$key", $ids[$i]);
    }

    $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result ?: null;
  }

  public static function create(array $data)
  {
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));

    $query = "INSERT INTO " . static::$table . " ({$columns}) VALUES ({$placeholders})";
    $stmt = PDO()->prepare($query);

    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }

    if ($stmt->execute()) {
      $id = PDO()->lastInsertId();
      return static::find($id);
    }

    return false;
  }

  public static function update(array|string|int $ids, array $data)
  {
    [$keys, $where, $ids] =  static::buildWhereClause($ids);
    $setClause = [];
    foreach (array_keys($data) as $column) {
      $setClause[] = "{$column} = :{$column}";
    }
    $setClause = implode(', ', $setClause);

    $query = "UPDATE " . static::$table . " SET {$setClause} WHERE {$where}";
    $stmt = PDO()->prepare($query);

    foreach ($keys as $i => $key) {
      $stmt->bindValue(":$key", $ids[$i]);
    }

    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }

    return $stmt->execute();
  }

  public static function delete(array|string|int $ids)
  {
    [$keys, $where, $ids] = static::buildWhereClause($ids);
    $query = "DELETE FROM " . static::$table . " WHERE {$where}";
    $stmt = PDO()->prepare($query);

    foreach ($keys as $i => $key) {
      $stmt->bindValue(":$key", $ids[$i]);
    }

    return $stmt->execute();
  }

  public  static function findBy($field, $value)
  {
    $query = "SELECT * FROM " . static::$table . " WHERE $field = :$field";
    $stmt = PDO()->prepare($query);
    $stmt->bindValue(":$field", $value);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    return $result;
  }

  public static function findOneBy($field, $value)
  {
    $query = "SELECT * FROM " . static::$table . " WHERE $field = :$field LIMIT 1";
    $stmt = PDO()->prepare($query);
    $stmt->bindValue(":$field", $value);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
    $result = $stmt->fetch();
    return $result ?: null;
  }
}
