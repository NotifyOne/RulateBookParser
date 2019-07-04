<?php
require_once 'class/dbBookId.class.php';
require_once 'class/dbBookTitle.class.php';
require_once 'class/dbBookArticleTitle.class.php';

$breol = PHP_EOL . '<br>' . PHP_EOL;
const bID = 'book_id';
const aID = 'article_id';

if (isset($_GET[bID])) {
  if (isset($_GET[aID])) {
    $article = new DbBookId();
    $article =  $article->getAllContentArticle((int)$_GET[aID]);
    echo '<a href="?' . bID . '=' . $_GET[bID] .'">Back</a>' . $breol;
    foreach ($article as $a) {
      echo $a . $breol;
    }
    echo '<a href="?' . bID . '=' . $_GET[bID] .'">Back</a>' . $breol;

  } else {
    $bookArticleTitles = new DbBookArticleTitle();
    echo '<a href="' . $_SERVER['SCRIPT_NAME'] .'">Back</a>' . $breol;

    foreach ($bookArticleTitles->getArticles((int) $_GET[bID]) as $id => $item) {
      ?>
      <a href="?<?= bID ?>=<?= $_GET[bID] ?>&<?= aID ?>=<?= $id ?>">
        <?= $item ?>
      </a> <?= $breol ?>
      <?php
    }
    echo '<a href="' . $_SERVER['SCRIPT_NAME'] .'">Back</a>' . $breol;
  }
} else {
  $bookTitles = new DbBookTitle();

  foreach ($bookTitles->getBookTitles() as $id => $bookTitle) {
    ?>
    <a href="?<?= bID ?>=<?= $id ?>"><?= $id ?>: <?= $bookTitle ?></a>
    <?php
  }
}



//$bookArticleTitles = new DbBookArticleTitle();
//foreach ($bookArticleTitles->getArticles(1) as $id=>$item) {
//  echo $id . ': ' . $item . '<br>';
//}


//$article = new DbBookId();
//$article =  $article->getAllContentArticle(10);
//foreach ($article as $a) {
//  echo $a . '<br>';
//}
