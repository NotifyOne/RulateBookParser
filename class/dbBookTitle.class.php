<?php
require_once 'class/db.class.php';

class DbBookTitle {
  private $tableName;
  private $db;

  function __construct() {
    $this->tableName = 'Book_title';
    $this->db = new Db();
  }

  function createTable() {
    if (!$this->db->isTableExist($this->tableName)) {
      $query = "CREATE TABLE `{$this->tableName}` 
        ( `id` INT NOT NULL AUTO_INCREMENT ,
          `title` VARCHAR(255) NOT NULL , 
           PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;";
      return ($this->db->getPDO()->exec($query) === 0);
    }
    return FALSE;
  }

  function addBookTitle(string $bookTitle) {
    $query = "INSERT INTO `{$this->tableName}` (`id`, `title`) VALUES (NULL, ?);";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->BindParam(1, $bookTitle);
    $zz->execute();

    $query = "SELECT LAST_INSERT_ID();";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->execute();

    $this->db->close();
    return $zz->fetch(PDO::FETCH_ASSOC)['LAST_INSERT_ID()'];
  }

  function getIdBookTitle(string $bookTitle, bool $createIfNoExist = false) {
    $query = "SELECT `id` FROM `{$this->tableName}` WHERE `title` = ?";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->bindParam(1, $bookTitle);
    $zz->execute();
    $id = $zz->fetch(PDO::FETCH_ASSOC)['id'];
    unset($zz);
    $this->db->close();

    if ($createIfNoExist && (!isset($id))) {
      $id = $this->addBookTitle($bookTitle);
    }

    return ($id);
  }

  function getBookTitles() {
    $query = "SELECT `id`, `title` FROM `{$this->tableName}`";
    $titles = [];
    foreach ($this->db->getPDO()->query($query, PDO::FETCH_NUM) as $row) {
      $titles[$row[0]] = $row[1];
    }
    $this->db->close();
    return $titles;
  }
}
