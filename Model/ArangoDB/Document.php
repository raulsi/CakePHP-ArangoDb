<?php
namespace App\Model\ArangoDB;


/**
* A Document class
*
* This class holds the Document object and give easy access to the users of document of the databsae.
*
*/
class Document{


  /**
   * Collection id where document exist
   *
   * @var string
   */
  protected $collection_id=NULL;

  /**
   * ID of the document
   *
   * @var string
   */
  protected $document_key=NULL;

  /**
   * revision id of the document
   *
   * @var string
   */
  protected $rev=NULL;

  /**
   * cookies of the document
   *
   * @var array
   */
  protected $_cookies=array();

  /**
   * header of the document
   *
   * @var array
   */
  protected $_headers=array();

  /**
   * data as json object of the document
   *
   * @var string
   */
  protected $_json=NULL;

  /**
   * data as xml object of the document
   *
   * @var string
   */
  protected $_xml=NULL;

  /**
   * array of the document data
   *
   * @var array
   */
  protected $_data=array();

  /**
   * get a data of the document
   *
   * @return array - document data.
   */
  public function getData(){
    return $this->_data;
  }

  /**
   * set document data
   *
   * This set data of the document in the document object
   *
   * @param array     $response  - response from database set all values else set the data as array
   *
   * @return void.
   */
  public function setData($response){
    if(isset($response->headers)) $this->_headers=$response->headers;
    if(isset($response->cookies)) $this->_cookies=$response->cookies;
    if(isset($response->_json)) $this->_json=$response->_json;
    if(isset($response->_xml)) if($response->_xml != NULL) $this->_xml=$response->xml;
    if(isset($response->json)) $this->_data=$response->json; else $this->_data=$response;
    if(isset($response->json['_id'])) $this->collection_id=explode('/',$response->json['_id'])[0];
    if(isset($response->json['_key'])) $this->document_key=$response->json['_key'];
    if(isset($response->json['_rev'])) $this->rev=$response->json['_rev'];
  }

  /**
   * get ID of the document
   *
   * @return string - document ID.
   */
  public function getId(){
    return $this->document_key;
  }

  /**
   * get ID of the document collection
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
   * set document id
   *
   * This set document ID
   *
   * @param string     $did  - document id to set in the document object
   *
   * @return void.
   */
  public function setId($did){
    $this->document_key=$did;
  }

  /**
   * set collection id
   *
   * This set collection ID for the document
   *
   * @param string     $cid  - collection id to set in the document object
   *
   * @return void.
   */
  public function setCollectionID($cid){
    $this->collection_id=$cid;
  }

  /**
   * set revesion id
   *
   * This set revesion ID for the document
   *
   * @param string     $rev  - revesion id to set in the document object
   *
   * @return void.
   */
  public function setRev($rev)
  {
    $this->rev=$rev;
  }
}


 ?>
