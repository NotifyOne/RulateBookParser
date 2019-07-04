<?php
defined('MAX_FILE_SIZE') || define('MAX_FILE_SIZE', 1000000);
require_once 'class/parserRulateWarlock.class.php';
require_once 'class/dbBookId.class.php';
require_once 'class/dbBookTitle.class.php';
require_once 'class/dbBookArticleTitle.class.php';


if (isset($_GET['getToPost'])) {
  $_POST['name'] = $_GET['name'] ?? '';
  $_POST['href'] = $_GET['href'] ?? '';
  $_POST['book_title'] = $_GET['book_title'] ?? '';
}

if (isset($_POST['name'], $_POST['href'], $_POST['book_title'])) {
  $time1 = microtime(true);
  $book_title = new DbBookTitle();
  $book_article_title = new DbBookArticleTitle();
  $book_content = new DbBookId();

  $warlock = new ParserRulateWarlock($_POST['href']);

  $idsContent = [];
  foreach ($warlock->parse() as $content) {
    $idsContent[] = $book_content->getIdContent(
      $book_article_title->getIdArticleTitle(
        $_POST['name'],
        $book_title->getIdBookTitle($_POST['book_title'], TRUE),
        TRUE
      ),
      $content,
      TRUE
    );
  }

  echo 'Count paragraphs: ' . (count($idsContent)) . '. Time: '
    . (microtime(true) - $time1);

}
else {
  echo $_POST['name'] ?? 'name' . PHP_EOL;
  echo ($_POST['href']) ?? 'href' . PHP_EOL;
  echo ($_POST['book_id']) ?? 'book_id' . PHP_EOL;
}
