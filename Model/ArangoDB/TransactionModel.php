<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Tansaction
*
* This class provides functions to handle transaction in the database.
*
*/
class TransactionModel extends ArangoModel {

  public $name = 'TransactionModel';

  var $useTable = false;

  /**
   *  Execute Tansaction
   *
   *  Execute a Transaction query on the database
   *
   * @param string  $action - contains the Transaction query string to be executed.
   * @param array  $read - Array of collection with read access.
   * @param array  $wite - Array of collection with write access.
   * @param array  $param - Array of parameters to send to the database as a options for Transaction.
   *
   * @return array $response - Return a response array of the request.
   */
  public function execute($action,$read=NULL,$write=NULL,$param=NULL){
    if($read!=NULL and $write!=NULL){
      $data = array();
      $data['collections']['read']=$read;
      $data['collections']['write']=$write;
      $data['actions']=$action;
      if(isset($param['waitForSync'])) $data['waitForSync']=$param['waitForSync'];
      if(isset($param['lockTimeout'])) $data['lockTimeout']=$param['lockTimeout'];
      if(isset($param['params'])) $data['params']=$param['params'];
      $response=$this->post('transaction',$data,'json');
      return $response;
    }else return array("error" => "Specify the collection");
  }
}

 ?>
