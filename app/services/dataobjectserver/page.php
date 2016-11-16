<?php
require_once dirname(__FILE__) . '/common/objectbase.php';
class page extends objectbase {
  public function Save(){
    if (!$this->id) {
      $this->createdate = 'now()';
    }
    $this->modifieddate = 'now()';
    objectbase::Save();
  }
  public function Delete(){
    $this->markfordelete = 1;
    $this->Save();
  }
}
?>
