<?php
require_once 'db.class.php';
require_once 'dbBookTitle.class.php';

class DbBookId {

  private $db;

  private $dbBookTitle;

  private $tableName;


  public function __construct() {
    $this->tableName = 'Books_article';
    $this->db = new Db();
    $this->dbBookTitle = new dbBookTitle();
  }

  function createTable() {
    if (!$this->db->isTableExist($this->tableName)) {
      $query = "CREATE TABLE `{$this->tableName}` 
        ( `id` INT NOT NULL AUTO_INCREMENT ,
        `article_title_id` INT NOT NULL ,
        `content` TEXT NOT NULL ,
        PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;";
      return ($this->db->getPDO()->exec($query) === 0);
    }
    return FALSE;
  }

  function getIdContent(int $article_title_id, string $article, bool $createIfNoExist = FALSE) {
    $query = "SELECT `id` FROM `{$this->tableName}` WHERE `content` = ? AND `article_title_id` = ?";
    $zz = $this->db->getPDO()->prepare($query);
    $zz->bindParam(1, $article);
    $zz->bindParam(2, $article_title_id);
    $zz->execute();
    $id = $zz->fetch(PDO::FETCH_ASSOC)['id'];
    unset($zz);
    $this->db->close();

    if ($createIfNoExist && (!isset($id))) {
      $id = $this->addContent($article_title_id, $article);
    }

    return ($id);
  }

  function addContent(int $article_title_id, string $article) {
    $query = "INSERT INTO `{$this->tableName}` (`id`, `article_title_id`, `content`) VALUES (NULL, ?, ?);";
    $zz = $this->db->getPDO()->prepare($query);

    $zz->bindParam(1, $article_title_id, PDO::PARAM_STR);
    $zz->bindParam(2, $article, PDO::PARAM_STR);
    $zz->execute();
    $id = $this->db->getLastId();

    unset($zz);
    $this->db->close();

    return $id;
  }

  function addContents(int $article_title_id, array $arrayArticles) {
    $id = [];
    foreach ($arrayArticles as $paragraph) {
      $id[] = $this->getIdContent($article_title_id, $paragraph, TRUE);
    }

    return $id;
  }
}
