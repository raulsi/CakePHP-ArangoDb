<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\model\ArangoDB\Structure;

/**
* A class for Structure
*
* This class provides functions to handle Structure in the database.
*
*/
class StructureModel extends ArangoModel {

  public $name = 'StructureModel';

  var $useTable = false;

  /**
   *  Create Structure
   *
   *  Request to create a new structure in the collection
   *
   * @param array/Structure  $data - Array of the data for Structure / Structure Object to create .
   * @param string  $collection - specify the collectionID to create the Structure into.
   * @param array  $param - Array of parameters to send to the database as a options for structure request.
   *
   * @return array/Structure $response/$data - Return a response array of the request/Structure object.
   */
  public function createStructure($data,$collection=NULL,$param=NULL){
    $option = array();
    if(isset($param['createCollection'])) $option['createCollection']=$param['createCollection'];
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['lang'])) $option['lang']=$param['lang'];
    if(isset($param['format'])) $option['format']=$param['format'];
    if($data instanceof Structure){
      $jdata=$data->getData();
      $option['collection']=$data->getCollectionID();
      $response=$this->post('structure',$jdata,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $option['collection']=$collection;
      $response=$this->post('structure',$jdata,'json',$option);
      return $response;
    }
  }

  /**
   *  Get Structure
   *
   *  Request to Get structure from the collection
   *
   * @param string/Structure  $doc - Collection ID / Structure Object to get.
   * @param string  $id - specify the structure ID to get the structure.
   * @param array  $param - Array of parameters to send to the database as a header for structure request.
   *
   * @return array/Structure $response/$doc - Return a response array of the request/Structure object.
   */
  public function getStructure($doc,$id=NULL,$param=NULL){
    $header=array();
    $option=array();
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['lang'])) $option['lang']=$param['lang'];
    if(isset($param['format'])) $option['format']=$param['format'];
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Structure){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
      $response=$this->get('structure/'.$collection.'/'.$id,NULL,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $doc->setData($response);
        return $doc;
      }else return $response;
    }else{
      $collection=$doc;
      $response=$this->get('structure/'.$collection.'/'.$id,NULL,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  Check Structure
   *
   *  Request check structure in the collection
   *
   * @param string/Structure  $doc - Collection ID / Structure Object to check.
   * @param string  $id - specify the structure ID to check the structure.
   * @param array  $param - Array of parameters to send to the database as a header for structure request.
   *
   * @return array/Structure $response/$doc - Return a response array of the request/Structure object.
   */
  public function checkStructure($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['rev']))  $option['rev']=$param['rev'];
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Structure){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->head('structure/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  Delete Structure
   *
   *  Request to Get structure from the collection
   *
   * @param string/Structure  $doc - Collection ID to delete from / Structure Object to delete.
   * @param string  $id - specify the structure ID to delete the structure.
   * @param array  $param - Array of parameters to send to the database as a header for structure request.
   *
   * @return array/Structure $response/$doc - Return a response array of the request/Structure object.
   */
  public function deleteStructure($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Structure){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->delete('structure/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  Replace Structure
   *
   *  Request to replace a structure in the collection
   *
   * @param array/Structure  $data - Array of the data for structure / Structure Object to replace .
   * @param string  $collection - specify the collectionID to replace the structure from.
   * @param string  $id - specify the structure ID to replace the structure.
   * @param array  $param - Array of parameters to send to the database as a options for structure request.
   *
   * @return array/Structure $response/$data - Return a response array of the request/Structure object.
   */
  public function replaceStructure($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    $option['waitForSync']=$waitForSync;
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    if(isset($param['lang'])) $option['lang']=$param['lang'];
    if(isset($param['format'])) $option['format']=$param['format'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Structure){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->put('structure/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->put('structure/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  Update Structure
   *
   *  Request to update a structure in the collection
   *
   * @param array/Structure  $data - Array of the data for structure / Structure Object to replace .
   * @param string  $collection - specify the collectionID to update the structure from.
   * @param string  $id - specify the structure ID to update the structure.
   * @param array  $param - Array of parameters to send to the database as a options for structure request.
   *
   * @return array/Structure $response/$data - Return a response array of the request/Structure object.
   */
  public function UpdateStructure($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    if(isset($param['lang'])) $option['lang']=$param['lang'];
    if(isset($param['format'])) $option['format']=$param['format'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Structure){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->patch('structure/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->patch('structure/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }
}



 ?>
