<?php
require_once dirname(__FILE__) . '/common/collectionbase.php';
class pagecollection extends collectionbase {
  // if you need to fiddle with the Items collection for a specific object,
  // you need to override call that constructor and then make changes to $this->Items
  public function __construct($classAttrValuePairs=null,$sortby=null,$getrelatedobjectcollection = 0){
      parent::__construct($classAttrValuePairs,$sortby,$getrelatedobjectcollection);
      $pages = array();
      foreach ($this->Items as $item){
        if ($item->markfordelete != 1){
          array_push($pages,$item);
        }
      }
      $this->Items = $pages;
  }
}
?>
