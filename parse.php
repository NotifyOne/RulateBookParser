<?php
defined('MAX_FILE_SIZE') || define('MAX_FILE_SIZE', 1000000);
require_once 'class/parserRulateTitles.class.php';
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
//  foreach ($idsContent as $i) {
//    echo $i . PHP_EOL;
//  }
  echo 'Count paragraphs: ' . (count($idsContent)) . '. Time: '
    . (microtime(true) - $time1);

}
else {
  echo $_POST['name'] ?? 'name' . PHP_EOL;
  echo ($_POST['href']) ?? 'href' . PHP_EOL;
  echo ($_POST['book_id']) ?? 'book_id' . PHP_EOL;
}



//var_dump($book_content->getIdContent(
//  $book_article_title->getIdArticleTitle(
//    'Глава 1',
//    $book_title->getIdBookTitle('Book 1', true),
//    true
//  ),
//  'content 2313',
//  true
//));

//echo $book_article_title->getIdArticleTitle(
//  'Глава 111',
//  $sendToDb->getIdBookTitle('Бла бла назва13', true),
//  true
//  ) . '<br>';

/*
if (isset($_GET['getToPost'])) {
  $_POST['name'] = $_GET['name'] ?? '';
  $_POST['href'] = $_GET['href'] ?? '';
  $_POST['book_id'] = $_GET['book_id'] ?? '';
}

if (isset($_POST['name'], $_POST['href'], $_POST['book_id'])) {

  $sendToDb = new DbBookId();
  $warlock = new ParserRulateWarlock($_POST['href']);
  $sendToDb->insertToDatabase($_POST['book_id'], $_POST['name'], $warlock->parse());
  echo 'ok';

} else {
  echo $_POST['name'] ?? 'name' . PHP_EOL;
  echo ($_POST['href']) ?? 'href' . PHP_EOL;
  echo ($_POST['book_id']) ?? 'book_id' . PHP_EOL;
}
*/

//
//$titles = new ParserRulateTitles('https://tl.rulate.ru', '/book/111');
//
//if (false) {
//  foreach ($titles->parse() as $p) {
//    foreach ($p as $key => $value) {
//      echo "$key: $value" . PHP_EOL . '<br>' . PHP_EOL;
//    }
//    echo PHP_EOL . '<hr>' . PHP_EOL;
//  };
//}
//
//if (false) {
//  for ($i= 0; $i < 3; $i++) {
//    $tt = $titles->parse()[$i];
//    echo $tt['name'] . PHP_EOL . '<br>' . PHP_EOL;
//    $warlock = new ParserRulateWarlock($tt['href']);
//    var_dump($warlock->parse());
//  }
//}
//
//if (false) {
//  $tt = $titles->parse()[0];
//  $sendToDB = new DbBookId();
//  $warlock = new ParserRulateWarlock($tt['href']);
//  $sendToDB->insertToDatabase(1, $tt['name'], $warlock->parse());
//  unset($tt, $sendToDB, $warlock, $sendToDB);
//}
