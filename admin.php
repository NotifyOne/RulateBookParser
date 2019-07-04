<?php
  require_once 'class/dbBookArticleTitle.class.php';
  require_once 'class/dbBookTitle.class.php';
  require_once 'class/dbBookId.class.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
</head>
<body>

<?php
  if (isset($_GET['createTable'])) {
    switch ($_GET['createTable']) {
      case 'Books_article':
        $book = new DbBookId();
        $create_article = $book->createTable();
        break;
      case 'Book_title':
        $book = new DbBookTitle();
        $create_titles =  $book->createTable();
        break;
      case 'Book_article_title':
        $book = new DbBookArticleTitle();
        $create_article_title =  $book->createTable();
        break;
      default:
        break;
    }
  }
?>

<a href="?createTable=Books_article">Create Book_article</a>
<?php echo $create_article ?? '' ?>
<br>
<a href="?createTable=Book_title">Create Book_title</a>
<?php echo $create_titles ?? '' ?>
<br>
<a href="?createTable=Book_article_title">Create Book_article_title</a>
<?php echo $create_article_title ?? '' ?>
<br>


</body>
</html>
