<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
use App\model\ArangoDB\Graph;

/**
* A class for Graph
*
* This class provides functions to handle Graph in the database.
*
*/
class GraphModel extends ArangoModel {

  public $name = 'GraphModel';

  var $useTable = false;

  /**
   *  Create Graph
   *
   *  Request to create a new Garph in the database
   *
   * @param array/Graph  $data - Array of the data for Graph / Graph Object to create .
   * @param array  $edgeDefinitions - Array of edge Definition to send as edgeDefinitions in data for Graph.
   * @param array  $orphanCollections - Array of extra vertices send as orphanCollections in data for the graph.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function createGraph($data,$edgeDefinitions=NULL,$orphanCollections=NULL,$param=NULL){
    $option = array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if($data instanceof Graph){
      $jdata['name']=$data->getKey();
      $jdata['edgeDefinitions']=$data->getEdgeDefinition();
      $jdata['orphanCollections']=$data->getOrphanCollection();
      $response=$this->post('gharial',$jdata,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata['_key']=$data;
      if($edgeDefinitions==NULL and $orphanCollections==NULL) return array("error" =>  "Please Specify Vertices or Edges");
      $jdata['edgeDefinitions']=$edgeDefinitions;
      $jdata['orphanCollections']=$orphanCollections;
      $response=$this->post('gharial',$jdata,'json',$option);
      return $response;
    }
  }

  /**
   *  Get Graph
   *
   *  Request to Get Graph from the database
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to get.
   * @param string  $id - specify the graph ID to get the edge.
   * @param array  $param - Array of parameters to send to the database as a header for graph request.
   *
   * @return array/Graph $response/$graph - Return a response array of the request/Graph object.
   */
  public function getGraph($graph,$id=NULL,$param=NULL){
    $header=array();
    if(isset($param['ifnmatch'])) $header['If-None-Match']=$param['ifnmatch'];
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
      $response=$this->get('gharial/'.$graphname,NULL,'json',NULL,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->setData($response);
        return $graph;
      }else return $response;
    }else{
      $graphname=$graph;
      $response=$this->get('gharial/'.$graphname,NULL,'json',NULL,$header);
      return $response;
    }
  }

  /**
   *  Add Vertex Collection
   *
   *  Request to add a vertex collection in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to add .
   * @param string  $name - specify the name of the collection to add into the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function addVertexCol($graph,$name,$param=NULL){
    $option=array();
    $data['collection'] = $name;
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
      $response=$this->post('gharial/'.$graphname.'/'.'vertex',$data,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->addOrphanCollection($name);
        return $graph;
      }else return $response;
    }else{
      $response=$this->post('gharial/'.$graph.'/'.'vertex',$data,'json',$option);
      return $response;
    }
  }

  /**
   *  List Vertex Collection
   *
   *  Request to list a vertex collection in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to add .
   *
   * @return array $response - Return a response array of the request.
   */
  public function listVertexCol($graph){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
    }else{
      $graphname=$graph;
    }
    $response=$this->get('gharial/'.$graphname.'/'.'vertex',NULL,'json');
    return $response;
  }

  /**
   *  Remove Vertex Collection
   *
   *  Request to remove a vertex collection in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to remove vertex.
   * @param string  $name - specify the name of the collection to remove from the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function removeVertexCol($graph,$name,$param=NULL){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if(isset($param['dropCollection']))  $option['dropCollection']=$param['dropCollection'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
      $response=$this->delete('gharial/'.$graphname.'/'.'vertex/'.$name,NULL,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->setData($response);
        return $graph;
      }else return $response;
    }else{
      $response=$this->delete('gharial/'.$graph.'/'.'vertex/'.$name,NULL,'json',$option);
      return $response;
    }
  }

  /**
   *  Create Vertex
   *
   *  Request to create a vertex in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to create vertex.
   * @param string  $collection - specify the name of the collection where vertex is created.
   * @param string  $name - specify the name of the vertex to add into the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function createVertex($graph,$collection,$name,$param=NULL){
    $option = array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
      $response=$this->post('gharial/'.$graphname.'/'.'vertex/'.$collection,array("name"=>$name),'json',$option);
      return $response;
    }else{
      $response=$this->post('gharial/'.$graph.'/'.'vertex/'.$collection,array("name"=>$name),'json',$option);
      return $response;
    }
  }

  /**
   *  Get Vertex
   *
   *  Request to get a vertex from the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to get vertex.
   * @param string  $collection - specify the name of the collection get vertex fom.
   * @param string  $name - specify the name of the vertex to get from the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function getVertex($graph,$collection,$name,$param=NULL){
    $header=array();
    if(isset($param['ifmatch']))  $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
      $response=$this->get('gharial/'.$graphname.'/'.'vertex/'.$collection.'/'.$name,NULL,'json',NULL,$header);
      return $response;
    }else{
      $response=$this->get('gharial/'.$graph.'/'.'vertex/'.$collection.'/'.$name,NULL,'json',NULL,$header);
      return $response;
    }
  }

  /**
   *  Delete Vertex
   *
   *  Request to delete a vertex from the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to remove vertex.
   * @param string  $collection - specify the name of the collection to remove vertex from.
   * @param string  $name - specify the name of the vertex to remove from the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function deleteVertex($graph,$collection,$name,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
    }else{
      $graphname=$graph;
    }
    $response=$this->delete('gharial/'.$graphname.'/'.'vertex/'.$collection.'/'.$name,NULL,'json',$option,$header);
    return $response;
  }

  /**
   *  Replace Vertex
   *
   *  Request to replace a vertex in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to replace vertex.
   * @param string  $collection - specify the name of the collection to replace vertex from.
   * @param string  $name - specify the name of the vertex to replace in the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function replaceVertex($graph,$collection,$name,$data,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
      $response=$this->put('gharial/'.$graphname.'/'.'vertex/'.$collection.'/'.$name,$data,'json',$option,$header);
      return $response;
    }else{
      $response=$this->put('gharial/'.$graph.'/'.'vertex/'.$collection.'/'.$name,$data,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  update Vertex
   *
   *  Request to update a vertex in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to update vertex.
   * @param string  $collection - specify the name of the collection to update vertex from.
   * @param string  $name - specify the name of the vertex to update in the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for vertex request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function updateVertex($graph,$collection,$name,$data,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
      $response=$this->patch('gharial/'.$graphname.'/'.'vertex/'.$collection.'/'.$name,$data,'json',$option,$header);
      return $response;
    }else{
      $response=$this->patch('gharial/'.$graph.'/'.'vertex/'.$collection.'/'.$name,$jdata,'json',$option,$header);
      return $response;
    }
  }

  /**
   *  Add Edge Definition
   *
   *  Request to add a Edge Definition in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to add edge Definition .
   * @param string  $name - specify the name of the edge to add into the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function addEdgeDef($graph,$edge,$param=NULL){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
      $data['collection'] = $name;
      $response=$this->post('gharial/'.$graphname.'/'.'edge',$edge,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->addEdgeDefinition($edge);
        return $graph;
      }else return $response;
    }else{
      $response=$this->post('gharial/'.$graph.'/'.'edge',$edge,'json',$option);
      return $response;
    }
  }

  /**
   *  List Edge Definition
   *
   *  Request to list a Edge Definition of the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to list edge Definition .
   * @param string  $name - specify the name of the edge to get list from the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function listEdgeDef($graph,$name){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
    }else{
      $graphname=$graph;
    }
    $response=$this->get('gharial/'.$graphname.'/'.'edge',NULL,'json');
    return $response;
  }

  /**
   *  Remove Edge Definition
   *
   *  Request to remove a Edge Definition in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to remove edge Definition .
   * @param string  $name - specify the name of the edge to remove into the Graph.
   * @param array  $data - Array of data to send to the database .
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function removeEdgeDef($graph,$name,$data=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if(isset($param['dropCollection']))  $option['dropCollection']=$param['dropCollection'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
      $edgeDefinition=$graph->getEdgeDefinition();
      $response=$this->put('gharial/'.$graphname.'/'.'edge/'.$name,$data,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->setData($response);
        return $graph;
      }else return $response;
    }else{
      $response=$this->put('gharial/'.$graph.'/'.'edge/'.$name,$data,'json',$option);
      return $response;
    }
  }

  /**
   *  Remove Edge Definition
   *
   *  Request to remove a Edge Definition in the graph
   *
   * @param string/Graph  $graph - Graph Name / Graph Object to remove edge Definition .
   * @param string  $name - specify the name of the edge to remove into the Graph.
   * @param array  $param - Array of parameters to send to the database as a options for edge request.
   *
   * @return array/Graph $response/$data - Return a response array of the request/Graph object.
   */
  public function removeEdgeDef($graph,$name,$param=NULL){
    $option=array();
    if(isset($param['waitForSync']))  $option['waitForSync']=$param['waitForSync'];
    if(isset($param['dropCollection']))  $option['dropCollection']=$param['dropCollection'];
    if($graph instanceof Graph){
      $graphname=$graph->getkey();
      $response=$this->delete('gharial/'.$graphname.'/'.'edge/'.$name,NULL,'json',$option);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $graph->setData($response);
        return $graph;
      }else return $response;
    }else{
      $response=$this->delete('gharial/'.$graph.'/'.'edge/'.$name,NULL,'json',$option);
      return $response;
    }
  }

  /**
   *  Delete Graph
   *
   *  Request to Get document from the collection
   *
   * @param string/Document  $doc - Collection ID to delete from / Document Object to delete.
   * @param string  $id - specify the document ID to delete the document.
   * @param array  $param - Array of parameters to send to the database as a header for document request.
   *
   * @return array/Document $response/$doc - Return a response array of the request/Document object.
   */
  public function deleteGraph($graph,$id=NULL,$param=NULL){
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($graph instanceof Graph){
      $graphname=$graph->getKey();
    }else{
      $collection=$graph;
    }
    $response=$this->delete('gharial/'.$graphname,NULL,'json',NULL,$header);
    return $response;
  }

  public function replaceGraph($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    $option['waitForSync']=$waitForSync;
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Graph){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->put('graph/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->put('graph/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }

  public function UpdateGraph($data,$collection=NULL,$id=NULL,$param=NULL){
    $option=array();
    if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
    if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
    if(isset($param['mergeObjects'])) $option['mergeObjects']=$param['mergeObjects'];
    if(isset($param['rev'])) $option['rev']=$param['rev'];
    if(isset($param['policy'])) $option['policy']=$param['policy'];
    $header=array();
    if(isset($param['ifmatch'])) $header['If-Match']=$param['ifmatch'];
    if($data instanceof Graph){
      $jdata=$data->getData();
      $collection=$data->getCollectionID();
      $id=$data->getID();
      $response=$this->patch('graph/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      if($response->code=='201' or $response->code=='202' or $response->code=='200'){
        $data->setData($response);
        return $data;
      }else return $response;
    }else{
      $jdata=$data;
      $response=$this->patch('graph/'.$collection.'/'.$id,$jdata,'json',$option,$header);
      return $response;
    }
  }
}



 ?>
