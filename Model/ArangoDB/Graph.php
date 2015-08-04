<?php
namespace App\Model\ArangoDB;

/**
* A Graph class
*
* This class holds the Graph object and give easy access to the users of Graph of databsae.
*
*/
class Graph{

  /**
   * ID of the graph
   *
   * @var string
   */
  protected $graph_key=NULL;

  /**
   * revision id of the graph
   *
   * @var string
   */
  protected $rev=NULL;

  /**
   * array of the extra vertices
   *
   * @var array
   */
  protected $_orphanCollections=array();

  /**
   * array of Edge Definition
   *
   * @var array
   */
  protected $_edgeDefinitions=array();

  /**
   * array of the vertex
   *
   * @var array
   */
  protected $_vertex=array();

  /**
   * array of Edge
   *
   * @var array
   */
  protected $_edge=array();

  /**
   * array of the edge data
   *
   * @var array
   */
  protected $_data=NULL;

  /**
   * get a data of the graph
   *
   * @return array - graph data.
   */
  public function getData(){
    return $this->_data;
  }

  /**
   * Set graph data
   *
   * This set data of the graph in the graph object
   *
   * @param array     $response  - response from database set all values else set the data as array
   *
   * @return void.
   */
  public function setData($response){
    $this->_data=$response;
    if(isset($response->edgeDefinitions)) $this->_edgeDefinitions=$response->edgeDefinitions;
    if(isset($response->orphanCollections)) $this->_orphanCollections=$response->orphanCollections;
    if(isset($response->_key)) $this->graph_key=$response->_key;
    if(isset($response->_rev)) $this->rev=$response->_rev;
  }

  /**
   * get edge Definition
   *
   * @return array - Graph Edge Definition
   */
  public function getEdgeDefinition(){
    return $this->_edgeDefinitions;
  }

  /**
   * get extra vertices
   *
   * @return array - graph extra vertices.
   */
  public function getOrphanCollection(){
    return $this->_edgeDefinitions;
  }

  /**
   * get Graph Key
   *
   * @return string - graph Key.
   */
  public function getKey(){
    return $this->graph_key;
  }

  /**
   * get Graph revision
   *
   * @return string - graph revision.
   */
  public function getRev()
  {
    return $this->rev;
  }

  /**
   * set graph key
   *
   * This set graph key
   *
   * @param string     $gid  - Graph key to set in the Graph object
   *
   * @return void.
   */
  public function setKey($gid){
    $this->graph_key=$gid;
  }

  /**
   * set edge Definition
   *
   * This set edge Definition
   *
   * @param array     $edgeDefinition  - array of edge Definition to set
   *
   * @return void.
   */
  public function setEdgeDefinition($edgeDefinition){
    $this->_edgeDefinitions=$edgeDefinition;
  }

  /**
   * Add Edge Definition
   *
   * This add edge Definition
   *
   * @param array  $edgeDefinition - append edge Definition into the $this->_edgeDefinitions
   *
   * @return void.
   */
  public function addEdgeDefinition($edgeDefinition){
    array_push($this->_edgeDefinitions,$edgeDefinition);
  }

  /**
   * set Extra vertices
   *
   * This set extraa vertices
   *
   * @param array $orphanCollection - array of extra vertices
   *
   * @return void.
   */
  public function setOrphanCollection($orphanCollection){
    array_push($this->_orphanCollections,$orphanCollection);
  }

  /**
   * Add vertices
   *
   * This add vertices
   *
   * @param array  $orphanCollection - append vertices into the $this->_orphanCollections
   *
   * @return void.
   */
  public function addOrphanCollection($orphanCollection){
    $this->_orphanCollections=$orphanCollection;
  }

  /**
   * Set Revision key
   *
   * This set revision key
   *
   * @param string  $rev - set Revision key for the graph object
   *
   * @return void.
   */
  public function setRev($rev)
  {
    $this->rev=$rev;
  }
}


 ?>
