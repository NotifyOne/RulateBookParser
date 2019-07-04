<?php

require_once 'libs/simple_html_dom.php';

abstract class Parser {
  private $uri;
  private $path;

  private $page;

  protected $parsed;

  function __construct($uri, $path = null) {
    $this->uri = $uri;
    $this->path = $path;
  }
  /**
   * Return HTML-page by $url . $path
   *
   * If it is launched for the first time - first download the page
   * The second time - returns only the page
   *
   * @param $recreate
   *  Force download page and return
   *
   * @return mixed
   *  Return simple_html_dom class
   */
  function getPage(bool $recreate = false) {
    if ($recreate || !isset($this->page)) {
      $this->page = file_get_html($this->uri . $this->path);
    }
    return $this->page;
  }

  /**
   * Return $uri page;
   */
  function getUri() {
    return $this->uri;
  }

  /**
   * Function parsed page, and return result
   *
   * @param bool $forceRecreate
   * if true -> reparsind
   *
   * @return array
   * Function parsed page, and return result
   */
  abstract function parse(bool $forceRecreate = FALSE);

}
