<?php

class Db {
  private $DB; // array parameters

  private $PDO;

  /**
   * Database constructor.
   * And connect to database;
   *
   * @param null $db_name
   * @param null $db_user
   * @param null $db_password
   * @param null $db_host
   * @param null $db_driver
   */
  function __construct($db_name = NULL,
                          $db_user = NULL,
                          $db_password = NULL,
                          $db_host = NULL,
                          $db_driver = NULL) {
    $this->DB = [
      'name' => $db_name ?? $_ENV['DB_NAME'] ?? '',
      'user' => $db_user ?? $_ENV['DB_USER'] ?? '',
      'password' => $db_password ?? $_ENV['DB_PASSWORD'] ?? '',
      'host' => $db_host ?? $_ENV['DB_HOST'] ?? '',
      'driver' => $db_driver ?? $_ENV['DB_DRIVER'] ?? 'mysql',
    ];

  }

  /**
   *  Connect to Database
   */
  function connect() {
    $this->PDO = new PDO(
      "{$this->DB['driver']}:host={$this->DB['host']};dbname={$this->DB['name']}",
      $this->DB['user'],
      $this->DB['password']);
  }

  function close() {
    $this->PDO = null;
  }

  /**
   * @param $tableName
   * Table name
   *
   * @return bool
   * is table existed
   */
  function isTableExist($tableName) {
    $query = "SHOW TABLES LIKE ?;";
    $prepared = $this->getPDO()->prepare($query);
    $prepared->bindParam(1, $tableName, PDO::PARAM_STR);
    $prepared->execute();
    $this->close();
    return (!empty($prepared->fetch()));
  }

  function getLastId() {
    $query = "SELECT LAST_INSERT_ID();";
    $zz = $this->getPDO()->prepare($query);
    $zz->execute();
    return $zz->fetch(PDO::FETCH_ASSOC)['LAST_INSERT_ID()'];
  }

  function getPDO() {
    if (!isset($this->PDO)) {
      $this->connect();
    }
    return $this->PDO;
  }
}
