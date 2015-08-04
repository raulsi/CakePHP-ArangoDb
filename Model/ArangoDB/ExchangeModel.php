<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\Model\ArangoDB\Document;

/**
* A class for Exchange of data
*
* This class provides functions to import and export data.
*
*/
class ExchangeModel extends ArangoModel {

  public $name = 'ExchangeModel';

  var $useTable = false;

  /**
   *  Export Data
   *
   *  Request export the data from the database
   *
   * @param string  $collection - specify the collectionID to create the document into.
   * @param array  $param - Array of parameters to send to the database as a options for export request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function export($collection,$param=NULL){
    $data = array();
    if(isset($param['flush'])) $data['flush']=$param['flush']; elseif(isset($param['flushWait'])) $data['flushWait']=$param['flushWait'];
    if(isset($param['count'])) $data['count']=$param['count'];
    if(isset($param['batchSize'])) $data['batchSize']=$param['batchSize'];
    if(isset($param['limit'])) $data['limit']=$param['limit'];
    if(isset($param['ttl'])) $data['ttl']=$param['ttl'];
    if(isset($param['restrictFields']) and isset($param['restrictType'])) $data['restrict']=array($param['restrictFields'],$param['restrictType']);
    $response=$this->post('export',$data,'json',array("collection" => $collection));
    return $response;
  }


  /**
   *  import Data
   *
   *  Request import the data into the database
   *
   * @param array/Document  $data - Array of Document to import/ Array of document data to import/ Array of the data to import / Document Object to import .
   * @param string  $collection - specify the collectionID to create the document into.
   * @param array  $param - Array of parameters to send to the database as a options for export request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function import($doc,$collection,$param=NULL){
    $data=NULL;
    $option = array();
    if(isset($param['type'])){
      $option['type']=$param['type'];
      if(is_array($doc)) {
        $data=array();
        if($doc[0] instanceof Document){
          foreach ($doc as $key => $value) {
            array_push($data,$value->json);
          }
        }else{
          foreach ($doc as $key => $value) {
            array_push($data,$value);
          }
        }
      }elseif($doc instanceof Document){
        $data=$doc->json;
      }else {
        $data=$doc;
      }
    }else{
      if(is_array($doc)) {
        $data=array();
        if($doc[0] instanceof Document){
          $k=array();
          foreach ($doc[0]->json as $key => $value) {
            array_push($k,$key);
          }
          array_push($data,$k);
          $k=array();
          foreach ($doc as $key => $value) {
            foreach ($value->json as $i => $val) {
              array_push($k,$val);
            }
            array_push($data,$k);
          }
        }else{
          $k=array();
          foreach ($doc[0] as $key => $value) {
            array_push($k,$key);
          }
          array_push($data,$k);
          $k=array();
          foreach ($doc as $key => $value) {
            foreach ($value as $i => $val) {
              array_push($k,$val);
            }
            array_push($data,$k);
          }
        }
      }elseif($doc instanceof Document){
        $k=array();
        foreach ($doc->json as $key => $value) {
          array_push($k,$key);
        }
        array_push($data,$k);
        $k=array();
        foreach ($doc->json as $i => $val) {
          array_push($k,$val);
        }
        array_push($data,$k);
      }else {
        $k=array();
        foreach ($doc as $key => $value) {
          array_push($k,$key);
        }
        array_push($data,$k);
        $k=array();
        foreach ($doc as $i => $val) {
          array_push($k,$val);
        }
        array_push($data,$k);
      }
    }
    $option['collection']=$collection;
    if(isset($param['createCollection'])) $option['createCollection']=$param['createCollection'];
    if(isset($param['overwrite'])) $option['overwrite']=$param['overwrite'];
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['onDuplicate'])) $option['onDuplicate']=$param['onDuplicate'];
    if(isset($param['complete'])) $option['complete']=$param['complete'];
    if(isset($param['details'])) $option['details']=$param['details'];
    $response=$this->post('export',$data,'json',array("collection" => $collection));
    return $response;
  }



}

 ?>
