<?php
namespace App\Model\ArangoDB;


/**
* A Edge class
*
* This class holds the Edge object and give easy access to the users of Edge document of databsae.
*
*/
class Edge{


  /**
   * Collection id where document exist
   *
   * @var string
   */
  protected $collection_id=NULL;

  /**
   * ID of the edge
   *
   * @var string
   */
  protected $edge_key=NULL;

  /**
   * revision id of the edge
   *
   * @var string
   */
  protected $rev=NULL;

  /**
   * from connected vertex
   *
   * @var string
   */
  protected $from=NULL;

  /**
   * to connected vertex
   *
   * @var string
   */
  protected $to=NULL;

  /**
   * array of the edge data
   *
   * @var array
   */
  protected $_data=array();

  /**
   * get a data of the edge
   *
   * @return array - edge data.
   */
  public function getData(){
    return $this->_data;
  }

  /**
   * set edge data
   *
   * This set data of the edge in the edge object
   *
   * @param array     $response  - response from database set all values else set the data as array
   *
   * @return void.
   */
  public function setData($response){
    $this->_data=$response;
    if(isset($response->_id)) $this->collection_id=explode('/',$response->_id)[0];
    if(isset($response->_key))$this->struct_key=$response->_key;
    if(isset($response->_rev)) $this->rev=$response->_rev;
    if(isset($response->_from)) $this->from=$response->_from;
    if(isset($response->_to)) $this->to=$response->_to;
  }

  /**
   * get ID of the edge
   *
   * @return string - edge ID.
   */
  public function getId(){
    return $this->edge_key;
  }

  /**
   * get ID of the edge collection
   *
   * @return string - collection ID.
   */
  public function getCollectionID(){
    return $this->collection_id;
  }

  /**
   * get ID of the edge revesion
   *
   * @return string - revesion ID.
   */
  public function getRev()
  {
    return $this->rev;
  }

  /**
   * get from connected vertex
   *
   * @return string - connected vertex.
   */
  public function getFrom()
  {
    return $this->from;
  }

  /**
   * get to connected vertex
   *
   * @return string - connected vertex.
   */
  public function getTo()
  {
    return $this->to;
  }

  /**
   * set from connected vertex
   *
   * @param string     $from  - from connected vertex to set in the Edge object
   *
   * @return void.
   */
  public function setFrom($from){
    $this->from=$from;
  }

  /**
   * set to connected vertex
   *
   * @param string     $from  - to connected vertex to set in the Edge object
   *
   * @return void.
   */
  public function setTo($to){
    $this->to=$to;
  }

  /**
   * set edge id
   *
   * This set edge ID
   *
   * @param string     $did  - edge id to set in the Edge object
   *
   * @return void.
   */
  public function setId($did){
    $this->edge_key=$did;
  }

  /**
   * set collection id
   *
   * This set collection ID for the Edge
   *
   * @param string     $cid  - collection id to set in the Edge object
   *
   * @return void.
   */
  public function setCollectionID($cid){
    $this->collection_id=$cid;
  }

  /**
   * set revesion id
   *
   * This set revesion ID for the Edge
   *
   * @param string     $rev  - revesion id to set in the Edge object
   *
   * @return void.
   */
  public function setRev($rev)
  {
    $this->rev=$rev;
  }
}


 ?>
