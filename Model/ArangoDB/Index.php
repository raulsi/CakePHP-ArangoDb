<?php
namespace App\Model\ArangoDB;

/**
* A Index Class
*
* This class holds the Index object and give easy access to the users of Index of databsae.
*
*/
class Index{

  /**
   * Collection id where Index exist
   *
   * @var string
   */
  protected $collection_id=NULL;

  /**
   * ID of the Index
   *
   * @var string
   */
  protected $index_key=NULL;

  /**
   * Type of Index
   *
   * @var string
   */
  protected $type=NULL;

  /**
   * array of the Index data
   *
   * @var array
   */
  protected $_data=array();

  /**
   * get a data of the Index
   *
   * @return array - index data.
   */
  public function getData(){
    return $this->_data;
  }

  /**
   * set Index data
   *
   * This set data of the index in the index object
   *
   * @param array     $response  - response from database set all values else set the data as array
   *
   * @return void.
   */
  public function setData($response){
    if(isset($response->fields)) $this->_data=$response->fields; else $this->_data=$response;
    if(isset($response->id)) $this->collection_id=explode('/',$response->id)[0];
    if(isset($response->id)) $this->index_key=explode('/',$response->id)[1];
    if(isset($response->type)) $this->type=$response->type;
  }

  /**
   * get ID of the index
   *
   * @return string - index ID.
   */
  public function getId(){
    return $this->index_key;
  }

  /**
   * get ID of the index collection
   *
   * @return string - collection ID.
   */
  public function getCollectionID(){
    return $this->collection_id;
  }

  /**
   * get ID of the Index type
   *
   * @return string - index type.
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * set index id
   *
   * This set index ID
   *
   * @param string     $did  - index id to set in the Index object
   *
   * @return void.
   */
  public function setId($did){
    $this->index_key=$did;
  }

  /**
   * set collection id
   *
   * This set collection ID for the Index
   *
   * @param string     $cid  - collection id to set in the Index object
   *
   * @return void.
   */
  public function setCollectionID($cid){
    $this->collection_id=$cid;
  }

  /**
   * set Type
   *
   * This set type of the index
   *
   * @param string     $type  - type to set in the index object
   *
   * @return void.
   */
  public function setType($type)
  {
    $this->type=$type;
  }
}


 ?>
