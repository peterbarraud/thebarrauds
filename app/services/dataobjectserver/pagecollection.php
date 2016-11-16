<?php
require_once dirname(__FILE__) . '/common/collectionbase.php';
class pagecollection extends collectionbase {
  public function __construct($classAttrValuePairs=null,$sortby=null,$getrelatedobjectcollection = 0){
      parent::__construct($classAttrValuePairs,$sortby,$getrelatedobjectcollection);
      $pages = array();
      foreach ($this->Items as $item){
        if ($item->id == 2){
          array_push($pages,$item);
        }
      }
      $this->Items = $pages;
      // $pages = array();
  		// $logger = new Logger('getpagelist');
  		// foreach ($items as $item){
  		// 	$logger->write($item);
  		// 	if ($item->markfordelete != 1){
  		// 		array_push($pages,$item);
  		// 	}
  		// }
      // $this->Items
  }
}
?>
