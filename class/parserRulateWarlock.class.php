<?php
require_once 'parser.class.php';

class ParserRulateWarlock extends Parser{

  /**
   * @param bool $forceRecreate
   *
   * @return array
   * Return paragraphs
   */
  public function parse(bool $forceRecreate = FALSE) {
    if ($forceRecreate || !isset($this->parsed)) {
      $readPage = $this->getPage()->find('div#readpage', 0);

      $readPage = $readPage->find('div.content-text', 0);
      foreach ($readPage->find('p') as $p) {
        if ( empty(preg_replace(
          '/^[\s\x00]+|[\s\x00]+$/u',
          '',
          $p->plaintext) ) ) {
          continue;
        }
        $this->parsed[] = $p->plaintext;
      }
    }

    return $this->parsed;
  }

}
