<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\model\ArangoDB\Edge;

/**
* A class for Edge
*
* This class provides functions to handle Edge in the database.
*
*/
class EdgeModel extends ArangoModel {

  public $name = 'EdgeModel';

  var $useTable = false;

  /**
   *  Create Edge
   *
   *  Request to create a new edge in the collection
   *
   * @param array/Edge  $data - Array of the data for Edge / Edge Object to create .
   * @param string  $collection - specify the collectionID to create the Edge into.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Edge $response/$data - Return a response array of the request/Edge object.
   */
  public function CreateEdge($data,$collection=NULL,$param=NULL){
    $option = array();
    if(isset($param['createCollection'])) $option['createCollection']=$param['createCollection'];
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['from'])) $option['from']=$param['from'];
    if(isset($param['to'])) $option['to']=$param['to'];
    if($data instanceof Edge){
      $jdata=$data->getData();
      $option['collection']=$data->getCollectionID();
      $option['from']=$data->getFrom();
      $option['to']=$data->getTo();
      $response=$this->post('edge',$jdata,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      if($collection!=NULL){
        $option['collection']=$collection;
        $response=$this->post('edge',$jdata,'json',$option);
        return $response;
      }else return array("error"=>"Must set collection ID");
    }
  }

  /**
   *  Get Edge
   *
   *  Request to Get edge from the collection
   *
   * @param string/Edge  $doc - Collection ID / Edge Object to get.
   * @param string  $id - specify the edge ID to get the edge.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array/Edge $response/$doc - Return a response array of the request/Edge object.
   */
  public function getEdge($doc,$id=NULL,$param=NULL){
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Edge){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
      $response=$this->get('edge/'.$collection.'/'.$id,NULL,'json',NULL,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $doc->setData($response);
        return $doc;
      }else return $response;
    }else{
      $collection=$doc;
      $response=$this->get('edge/'.$collection.'/'.$id,NULL,'json',NULL,$header);
      return $response;
    }
  }

  /**
   *  Check Edge
   *
   *  Request check edge in the collection
   *
   * @param string/Edge  $doc - Collection ID / Edge Object to check.
   * @param string  $id - specify the edge ID to check the edge.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array/Edge $response/$doc - Return a response array of the request/Edge object.
   */
  public function checkEdge($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['rev']))  $option['rev']=$param['rev'];
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Edge){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->head('edge/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  List Edge
   *
   *  Request to list all edge from the collection
   *
   * @param string  $collection - Collection ID o get edge from.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listAll($collection,$param=NULL){
    $option = array();
    $option['collection']=$collection;
    $response=$this->get('edge',NULL,'json',$option);
    return $response;
  }

  /**
   *  List Edges with vertex
   *
   *  Request to list Edges according to the vertex
   *
   * @param string  $collection - Collection ID to get edge from.
   * @param string  $vertex - handle of the vertex.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listEdges($collection,$vertex,$param=NULL){
    $option = array();
    $option['vertex']=$vertex;
    if(isset($param['direction']))  $option['direction']=$param['direction'];
    $response=$this->get('edge/'.$collection,NULL,'json',$option);
    return $response;
  }

  /**
   *  Delete Edge
   *
   *  Request to Get edge from the collection
   *
   * @param string/Edge  $doc - Collection ID to delete from / Edge Object to delete.
   * @param string  $id - specify the edge ID to delete the edge.
   * @param array  $param - Array of parameters to send to the database as a header for edge request.
   *
   * @return array/Edge $response/$doc - Return a response array of the request/Edge object.
   */
  public function deleteEdge($doc,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($doc instanceof Edge){
      $collection=$doc->getCollectionID();
      $id=$doc->getId();
    }else{
      $collection=$doc;
    }
    $response=$this->delete('edge/'.$collection.'/'.$id,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  Replace Edge
   *
   *  Request to replace a edge in the collection
   *
   * @param array/Edge  $data - Array of the data for edge / Edge Object to replace .
   * @param string  $collection - specify the collectionID to replace the edge from.
   * @param string  $id - specify the edge ID to replace the edge.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Edge $response/$data - Return a response array of the request/Edge object.
   */
  public function replaceEdge($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    $option['waitForSync']=$waitForSync;
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Edge){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->put('edge/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->put('edge/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  Update Edge
   *
   *  Request to update a edge in the collection
   *
   * @param array/Edge  $data - Array of the data for edge / Edge Object to replace .
   * @param string  $collection - specify the collectionID to update the edge from.
   * @param string  $id - specify the edge ID to update the edge.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Edge $response/$data - Return a response array of the request/Edge object.
   */
  public function UpdateEdge($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
    if(isset($param['mergeObjects'])) $option['mergeObjects']=$param['mergeObjects'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Edge){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->patch('edge/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->patch('edge/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }
}



 ?>
