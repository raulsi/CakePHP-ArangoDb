<?php
namespace App\Model\ArangoDB;


class Structure{


  /**
   * Collection id where document exist
   *
   * @var string
   */
  protected $collection_id=NULL;

  /**
   * ID of the structure
   *
   * @var string
   */
  protected $struct_key=NULL;

  /**
   * revision id of the document
   *
   * @var string
   */
  protected $rev=NULL;

  /**
   * array of the structure data
   *
   * @var array
   */
  protected $_data=array();

  /**
   * get a data of the structure
   *
   * @return array - structure data.
   */
  public function getData(){
    return $this->_data;
  }

  /**
   * set structure data
   *
   * This set data of the structure in the structure object
   *
   * @param array     $response  - response from database set all values else set the data as array
   *
   * @return void.
   */
  public function setData($response){
    if(isset($response->json)) $this->_data=$response->json; else $this->_data=$response;
    if(isset($response->json['_id'])) $this->collection_id=explode('/',$response->json['_id'])[0];
    if(isset($response->json['_key'])) $this->document_key=$response->json['_key'];
    if(isset($response->json['_rev'])) $this->rev=$response->json['_rev'];
  }

  /**
   * get ID of the structure
   *
   * @return string - structure ID.
   */
  public function getId(){
    return $this->struct_key;
  }

  /**
   * get ID of the structure collection
   *
   * @return string - collection ID.
   */
  public function getCollectionID(){
    return $this->collection_id;
  }

  /**
   * get ID of the document revesion
   *
   * @return string - revesion ID.
   */
  public function getRev()
  {
    return $this->rev;
  }

  /**
   * set structure id
   *
   * This set structure ID
   *
   * @param string     $did  - structure id to set in the Structure object
   *
   * @return void.
   */
  public function setId($did){
    $this->struct_key=$did;
  }

  /**
   * set collection id
   *
   * This set collection ID for the Structure
   *
   * @param string     $cid  - collection id to set in the Structure object
   *
   * @return void.
   */
  public function setCollectionID($cid){
    $this->collection_id=$cid;
  }

  /**
   * set revesion id
   *
   * This set revesion ID for the Structure
   *
   * @param string     $rev  - revesion id to set in the Structure object
   *
   * @return void.
   */
  public function setRev($rev)
  {
    $this->rev=$rev;
  }
}


 ?>
