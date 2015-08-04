<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Collections
*
* This class provides functions to handle collections in the database.
*
*/
class CollectionModel extends ArangoModel {

  public $name = 'CollectionModel';

  var $useTable = false;

  /**
   *  Create Collection
   *
   *  Request to create a new collection in the database
   *
   * @param string  $name - specify the collection name to create.
   * @param array  $param - Array of parameters to send to the database as a options for collection.
   *
   * @return array $response - Return a response array of the request.
   */
  public function createCollection($name,$param=NULL){
    $data = array();
    $data['name']=$name;
    if(isset($param['waitForSync'])) $data['waitForSync']=$param['waitForSync'];
    if(isset($param['doCompact'])) $data['doCompact']=$param['doCompact'];
    if(isset($param['jurnalSize'])) $data['jurnalSize']=$param['jurnalSize'];
    if(isset($param['isSystem'])) $data['isSystem']=$param['isSystem'];
    if(isset($param['isVolatile'])) $data['isVolatile']=$param['isVolatile'];
    if(isset($param['keyOptions'])) $data['keyOptions']=$param['keyOptions'];
    if(isset($param['type'])) $data['type']=$param['type'];
    if(isset($param['numerOfShards'])) $data['numberOfShards']=$param['numberOfShards'];
    if(isset($param['shardKeys'])) $data['shardKeys']=$param['shardKeys'];
    $response=$this->post('collection',$data,'json');
    return $response;
  }

  /**
   *  Get Collection
   *
   *  Request to get the colection from the database
   *
   * @param string  $collection - specify the collection name to get from the database.
   * @param string  $command - command to specify which get request to send.
   * @param array  $param - Array of parameters to send to the database as a options for collection.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getCollection($collection,$command=NULL,$param=NULL){
    $option=array();
    $uri='collection/'.$collection;
    $chkv=array('properties','count','figures','revision','checksum');
    if($command!=NULL and (array_search(strtolower($command),$chkv)!=0 or strtolower($command)==$chkv[0])) $uri.='/'.strtolower($command);
    if(isset($param['withRevisions']))  $option['withRevisions']=$param['withRevisions'];
    if(isset($param['withData']))  $option['withData']=$param['withData'];
    $response=$this->get($uri,NULL,'json',$option);
    return $response;
  }

  /**
   *  Manage Collection
   *
   *  Request to handle the colection on the database
   *
   * @param string  $collection - specify the collection name to get from the database.
   * @param string  $command - command to specify which get request to send.
   * @param array  $param - Array of parameters to send to the database as a options for collection.
   *
   * @return array $response - Return a response array of the request.
   */
  public function manageCollection($collection,$command=NULL,$data=NULL){
    $option=array();
    $uri='collection/'.$collection;
    $chkv=array('load','unload','truncate','properties','rename','rotate');
    if($command!=NULL and (array_search(strtolower($command),$chkv)!=0 or strtolower($command)==$chkv[0])){
      $uri.='/'.strtolower($command);
      $response=$this->put($uri,$data,'json');
      return $response;
    }else{
      return(array('error'=>'Wrong Command'));
    }
  }

  /**
   *  List Collection
   *
   *  Request to list all the colection of the database
   *
   * @param array  $param - Array of parameters to send to the database as a options for collection.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listCollection($param=NULL){
    $option = array();
    if(isset($param['excludeSystem'])) $option['excludeSystem']=$param['excludeSystem'];
    $response=$this->get('collection',NULL,'json',$option);
    return $response;
  }

  /**
   *  Delete Collection
   *
   *  Request to delete the colection from the database
   *
   * @param string  $collection - specify the collection name to get from the database.
   *
   * @return array $response - Return a response array of the request.
   */
  public function deleteCollection($collection){
    $option=array();
    $response=$this->delete('collection/'.$collection,NULL,'json');
    return $response;
  }
}

 ?>
