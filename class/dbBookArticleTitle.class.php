<?php
require_once 'class/db.class.php';
require_once 'dbBookTitle.class.php';

class DbBookArticleTitle {
  private $tableName;
  private $db;
  private $book_title;

  function __construct() {
    $this->tableName = 'Book_article_title';
    $this->db = new Db();
    $this->book_title = new DbBookTitle();
  }

  function createTable() {
    if (!$this->db->isTableExist($this->tableName)) {
      $query = "CREATE TABLE `{$this->tableName}` 
        ( `id` INT NOT NULL AUTO_INCREMENT , 
          `book_id` INT NOT NULL , 
          `title` VARCHAR(255) NOT NULL , 
          PRIMARY KEY (`id`)) ENGINE = InnoDB;";
      return ($this->db->getPDO()->exec($query) === 0);
    }
    return FALSE;
  }

  function addArticleTitle(string $articleTitle, int $book_id) {
    $query = "INSERT INTO `{$this->tableName}` (`id`, `book_id`, `title`) VALUES (NULL, ?, ?);";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->BindParam(1, $book_id, PDO::PARAM_INT);
    $zz->BindParam(2, $articleTitle);
    $zz->execute();

    $query = "SELECT LAST_INSERT_ID();";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->execute();

    $this->db->close();
    return $zz->fetch(PDO::FETCH_ASSOC)['LAST_INSERT_ID()'];
  }

  function getIdArticleTitle(string $articleTitle, int $book_id, bool $createIfNoExist = false) {
    $query = "SELECT `id` FROM `{$this->tableName}` WHERE `title` = ? AND `book_id` = ?";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->bindParam(1, $articleTitle);
    $zz->bindParam(2, $book_id, PDO::PARAM_INT);
    $zz->execute();

    $id = $zz->fetch(PDO::FETCH_ASSOC)['id'];

    unset($zz);
    $this->db->close();

    if ($createIfNoExist && (!isset($id))) {
      $id = $this->addArticleTitle($articleTitle, $book_id);
    }

    return ($id);
  }
}
