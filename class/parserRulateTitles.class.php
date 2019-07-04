<?php
require_once 'parser.class.php';

class ParserRulateTitles extends Parser {

  /**
   * Return parsed page
   *
   * If the page has been processed - returns the result
   *
   * @param $forceRecreate
   *  if true -> Forced to process the page and return result
   *
   * @return array
   *  an array in which there is a link and title
   */
  function parse(bool $forceRecreate = FALSE) {
    if ($forceRecreate || !isset($this->parsed)) {
      $readPage = $this->getPage()->find('table#Chapters', 0);

      foreach ($readPage->find('tr.chapter_row') as $table) {
        $title = $table->find('td.t', 0);
        $title = $title->find('a', 0);
        if ($table->find('span.disabled', 0)) {
          continue;
        }
        $this->parsed[] = [
          'href' => ((($title->href[0] == '/') ? $this->getUri() : '') . $title->href),
          'name' => $title->plaintext,
        ];
      }
    }
    return $this->parsed;
  }
}
