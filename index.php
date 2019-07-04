<?php
defined('MAX_FILE_SIZE') || define('MAX_FILE_SIZE', 1000000);

require_once 'class/parserRulateTitles.class.php';

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Parse Rulate books</title>
  <script src="js/jquery-3.4.1.min.js"></script>
</head>
<body>
<?php

if (isset($_POST['book_id'])) :
  $time1 = microtime(TRUE);
  $titles = new ParserRulateTitles('https://tl.rulate.ru', '/book/' . intval($_POST['book_id']));
  $titles = $titles->parse();
  echo 'Page parsed: ' . (microtime(TRUE) - $time1) . '<br>' . PHP_EOL . '<br>';

  ?>
  <a href="#" onclick="parse()">Parse</a>
  <table>
    <tr>
      <td>Name</td>
      <td>Href</td>
      <td>Status</td>
    </tr>
    <?php
    foreach ($titles as $key => $title):
      ?>
      <tr>
        <td id="name_<?= $key ?>"><?= $title['name'] ?></td>
        <td id="href_<?= $key ?>"><?= $title['href'] ?></td>
        <td id="status_<?= $key ?>"></td>
      </tr>
    <?php
    endforeach;
    ?>
  </table>
  <script>
    function parse() {
      for (var i = 0; i <= <?= $key ?>; i++) {
        $.ajax({
          type: 'POST',
          url: 'parse.php',
          async: false,
          data: 'name=' + $("#name_" + i).text() + '&href=' + $("#href_" + i).text()
              + '&book_title=<?= 'Warlock of the Magus World / Чернокнижник в мире Магов' //$_POST['book_id'] ?>',
          success: function (data) {
            $('#status_' + i).html(data);
            // console.log(data);
          }

        });
      }
    }

  </script>
<?php
else:
?>
  <form method="post">
    <input type="number" name="book_id" id="book_id"
           placeholder="Paste book id this" min="0">
    <input type="submit" value="submit">
  </form>
<?php endif; ?>

</body>
</html>
