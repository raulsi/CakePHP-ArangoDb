<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\model\ArangoDB\Index;

/**
* A class for Edge
*
* This class provides functions to handle Edge in the database.
*
*/
class IndexModel extends ArangoModel {

  public $name = 'IndexModel';

  var $useTable = false;

  /**
   *  Create Edge
   *
   *  Request to create a new edge in the collection
   *
   * @param array/Edge  $index - Collection ID / Edge Object to create .
   * @param string  $type - specify the type of index.
   * @param array  $data - Array of the data for index.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Edge $response/$data - Return a response array of the request/Edge object.
   */
  public function CreateIndex($index,$type=NULL,$data=NULL,$param=NULL){
    $option = array();
    if($data instanceof Index){
      $jdata=array();
      $jdata['type']=strtolower($index->getType());
      switch (strtolower($index->getType())) {
        case 'cap':
          if(isset($param['size'])) $jdata['size']=intval($param['size'])>0?$param['size']:0;
          if(isset($param['byteSize'])) $jdata['byteSize']=intval($param['byteSize'])>16384?$param['byteSize']:0;
          break;
        case 'geo':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['geoJson'])) $jdata['geoJson']=$param['geoJson'];
          break;
        case 'hash':
        case 'skiplist':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['unique'])) $jdata['unique']=$param['unique'];
          if(isset($param['sparse'])) $jdata['sparse']=$param['sparse'];
          break;
        case 'fulltext':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['mineLngth'])) $jdata['minLength']=$param['minLength'];
          break;
      }
      $option['collection']=$index->getCollectionID();
      $response=$this->post('index',$jdata,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $index;
      }else return $response;
    }else{
      $jdata=array();
      $jdata['type']=strtolower($type);
      switch (strtolower($type)) {
        case 'cap':
          if(isset($param['size'])) $jdata['size']=intval($param['size'])>0?$param['size']:0;
          if(isset($param['byteSize'])) $jdata['byteSize']=intval($param['byteSize'])>16384?$param['byteSize']:0;
          break;
        case 'geo':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['geoJson'])) $jdata['geoJson']=$param['geoJson'];
          break;
        case 'hash':
        case 'skiplist':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['unique'])) $jdata['unique']=$param['unique'];
          if(isset($param['sparse'])) $jdata['sparse']=$param['sparse'];
          break;
        case 'fulltext':
          if($data!=NULL) $jdata['fields']=$data; else return (array("error" => "Fields Required"));
          if(isset($param['mineLngth'])) $jdata['minLength']=$param['minLength'];
          break;
      }
      $option['collection']=$index;
      $response=$this->post('index',$jdata,'json',$option);
      return $response;
    }
  }

  /**
   *  Get Index
   *
   *  Request to Get index from the collection
   *
   * @param string/Edge  $index - Collection ID / Edge Object to get.
   * @param string  $id - specify the edge ID to get the edge.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array/Edge $response/$doc - Return a response array of the request/Edge object.
   */
  public function getIndex($index,$id=NULL,$param=NULL){
    if($doc instanceof Index){
      $collection=$index->getCollectionID();
      $id=$index->getId();
      $response=$this->get('index/'.$collection.'/'.$id,NULL,'json');
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $index->setData($response);
        return $index;
      }else return $response;
    }else{
      $collection=$index;
      $response=$this->get('index/'.$collection.'/'.$id,NULL,'json');
      return $response;
    }
  }

  /**
   *  List Edge
   *
   *  Request to list all edge from the collection
   *
   * @param string  $collection - Collection ID o get edge from.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listAll($collection){
    $option = array();
    $option['collection']=$collection;
    $response=$this->get('index',NULL,'json',$option);
    return $response;
  }

  /**
   *  Delete Edge
   *
   *  Request to Get edge from the collection
   *
   * @param string/Edge  $index - Collection ID to delete from / Edge Object to delete.
   * @param string  $id - specify the index ID to delete the Index.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array/Edge $response/$doc - Return a response array of the request/Edge object.
   */
  public function deleteIndex($index,$id=NULL,$param=NULL){
    if($doc instanceof Index){
      $collection=$index->getCollectionID();
      $id=$index->getId();
    }else{
      $collection=$index;
    }
    $response=$this->delete('index/'.$collection.'/'.$id,NULL,'json');
    return $response;
  }
}



 ?>
