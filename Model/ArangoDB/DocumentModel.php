<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\model\ArangoDB\Document;

/**
* A class for Document
*
* This class provides functions to handle Document in the database.
*
*/
class DocumentModel extends ArangoModel {

  public $name = 'DocumentModel';

  var $useTable = false;

  /**
   *  Create Document
   *
   *  Request to create a new document in the collection
   *
   * @param array/Document  $data - Array of the data for document / Document Object to create .
   * @param string  $collection - specify the collectionID to create the document into.
   * @param array  $param - Array of parameters to send to the database as a options for document request.
   *
   * @return array/Document $response/$data - Return a response array of the request/Document object.
   */
  public function createDoc($data,$collection=NULL,$param=NULL){
    $option = array();
    if(isset($param['createCollection'])) $option['createCollection']=$param['createCollection'];
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if($data instanceof Document){
      $jdata=$data->getData();
      $option['collection']=$data->getCollectionID();
      $response=$this->post('document',$jdata,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      if($collection!=NULL){
        $option['collection']=$collection;
        $response=$this->post('document',$jdata,'json',$option);
        return $response;
      }else return array("error"=>"Must set collection ID");
    }
  }

  /**
   *  Get Document
   *
   *  Request to Get document from the collection
   *
   * @param string/Document  $doc - Collection ID / Document Object to get.
   * @param string  $id - specify the document ID to get the document.
   * @param array  $param - Array of parameters to send to the database as a header for document request.
   *
   * @return array/Document $response/$doc - Return a response array of the request/Document object.
   */
  public function getDoc($doc,$id=NULL,$param=NULL){
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Document){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
      $response=$this->get('document/'.$collection.'/'.$id,NULL,'json',NULL,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $doc->setData($response);
        return $doc;
      }else return $response;
    }else{
      $collection=$doc;
      $response=$this->get('document/'.$collection.'/'.$id,NULL,'json',NULL,$header);
      return $response;
    }
  }

  /**
   *  Check Document
   *
   *  Request check document in the collection
   *
   * @param string/Document  $doc - Collection ID / Document Object to check.
   * @param string  $id - specify the document ID to check the document.
   * @param array  $param - Array of parameters to send to the database as a header for document request.
   *
   * @return array/Document $response/$doc - Return a response array of the request/Document object.
   */
  public function checkDoc($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['rev']))  $option['rev']=$param['rev'];
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Document){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->head('document/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  List Document
   *
   *  Request to list all document from the collection
   *
   * @param string  $doc - Collection ID to get document from.
   * @param array  $param - Array of parameters to send to the database as a header for document request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listAll($collection,$param=NULL){
    $option = array();
    $option['collection']=$collection;
    if(isset($param['getType'])) $option['type']=$param['getType'];
    $response=$this->get('document',NULL,'json',$option);
    return $response;
  }

  /**
   *  Delete Document
   *
   *  Request to delete document from the collection
   *
   * @param string/Document  $doc - Collection ID to delete from / Document Object to delete.
   * @param string  $id - specify the document ID to delete the document.
   * @param array  $param - Array of parameters to send to the database as a header for document request.
   *
   * @return array/Document $response/$doc - Return a response array of the request/Document object.
   */
  public function deleteDoc($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Document){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->delete('document/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  Replace Document
   *
   *  Request to replace a document in the collection
   *
   * @param array/Document  $data - Array of the data for document / Document Object to replace .
   * @param string  $collection - specify the collectionID to replace the document from.
   * @param string  $id - specify the document ID to replace the document.
   * @param array  $param - Array of parameters to send to the database as a options for document request.
   *
   * @return array/Document $response/$data - Return a response array of the request/Document object.
   */
  public function replaceDoc($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Document){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->put('document/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->put('document/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  Update Document
   *
   *  Request to update a document in the collection
   *
   * @param array/Document  $data - Array of the data for document / Document Object to update .
   * @param string  $collection - specify the collectionID to update the document from.
   * @param string  $id - specify the document ID to update the document.
   * @param array  $param - Array of parameters to send to the database as a options for document request.
   *
   * @return array/Document $response/$data - Return a response array of the request/Document object.
   */
  public function updateDoc($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
    if(isset($param['mergeObjects'])) $option['mergeObjects']=$param['mergeObjects'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Document){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->patch('document/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->patch('document/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }
}



 ?>
