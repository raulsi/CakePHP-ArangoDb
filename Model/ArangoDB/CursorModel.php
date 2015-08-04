<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for cursor
*
* This class provides functions to handle cursors in the database.
*
*/
class CursorModel extends ArangoModel {


  public $name = 'CursorModel';

  var $useTable = false;


  /**
   * ID of the cursor in the database
   *
   * @var string
   */
  protected $cursor_id=NULL;

  /**
   * Size limit of the result send from request
   *
   * @var number - default is zero(no limit)
   */
  protected $batchSize=NULL;

  /**
   * Time-to-live of the cursor
   *
   * @var number - in seconds
   */
  protected $ttl=NULL;

  /**
   * Number of result returned in the response.
   *
   * @var number
   */
  protected $count=NULL;

  /**
   * Flag weather to send the count of the result or not.
   *
   * @var boolean - false
   */
  protected $iscount=NULL;

  /**
   *  key/value list of bind parameters.
   *
   * @var array
   */
  protected $bindVars=NULL;

  /**
   *  key/value list of extra options for the query.
   *
   * @var array
   */
  protected $options=array();

  /**
   * Flag weather to check result has more valus or not.
   *
   * @var boolean - false
   */
  protected $hasMore=false;


  /**
   *  Construct cursor
   *
   *  Initialize with the values passed as parameter
   *
   * @param array  $param - Array of parameters to iitialize the cursor.
   *
   * @return void.
   */
  public function __construct($param=NULL){
    if(isset($param['batchSize'])) $this->batchSize=$param['batchSize'];
    if(isset($param['ttl'])) $data['ttl']=$param['ttl'];
    if(isset($param['iscount'])) $data['count']=$param['iscount'];
    if(isset($param['bindVars'])) $data['bindVars']=$param['bindVars'];
    if(isset($param['options'])) $data['options']=$param['options'];
  }


  /**
   *  Execute Query
   *
   *  Execute a query on the server
   *
   * @param string  $query - contains the query string to be executed.
   * @param array  $param - Array of parameters to send to the database as a options for Cursor.
   *
   * @return array $response - Return a response array of the request.
   */
  public function query($query,$param=NULL){
    $data=array();
    $data['query']=$query;
    if(isset($param['batchSize'])) {$this->batchSize=$param['batchSize'];$data['batchSize']=$param['batchSize'];}
    if(isset($param['ttl'])) {$this->ttl=$param['ttl'];$data['ttl']=$param['ttl'];}
    if(isset($param['iscount'])) {$this->iscount=$param['iscount'];$data['count']=$param['iscount'];}
    if(isset($param['bindVars'])) {$this->bindVars=$param['bindVars'];$data['bindVars']=$param['bindVars'];}
    if(isset($param['options'])) {$this->options=$param['options'];$data['options']=$param['options'];}
    $response=$this->post('cursor',$data,'json',NULL);
    $cursor=$response->json;
    if(isset($cursor['count'])) $this->count=$cursor['count'];
    if($cursor['hasMore']==true){ $this->cursor_id=$cursor['id']; $this->hasMore=$cursor['hasMore']; }
    return $response;
  }

  /**
   *  Explain Query
   *
   *  Explain the query
   *
   * @param string  $query - contains the query string to be executed.
   * @param array  $param - Array of parameters to send to the database as a options for explain.
   *
   * @return array $response - Return a response array of the request.
   */
  public function explain($query,$param=NULL){
    $data=array();
    $data['query']=$query;
    if(isset($param['options'])) {$this->options=$param['options'];$data['options']=$param['options'];}
    $response=$this->post('explain',$data,'json',NULL);
    return $response;
  }

  /**
   *  Next batch
   *
   *  If the cursor is still alive return the next batch with the cursor ID
   *
   * @return array $response - Return a response array of the request.
   */
  public function nextBatch(){
    if($this->hasMore==true){
      $response=$this->put('cursor/'.$this->cursor_id);
      $cursor=$response->json;
      if($cursor['hasMore']==false){  $this->hasMore=$cursor['hasMore']; }
      return $response;
    }else{
      return array('error'=>'No More Batch left');
    }
  }

  /**
   *  Get Query
   *
   *  Get the queries from the database
   *
   * @param string  $command - command to execute as request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getQuery($command){
    $cmd=array("properties","current","slow");
    if(strtolower($command)==$cmd[0] or (array_search(strtolower($command),$cmd)!=0)){
      $response=$this->get('query/'.strtolower($command));
      return $response;
    }else{
      return array("error" => "Wrong Command");
    }
  }

  /**
   *  Delete Query
   *
   *  delete queries from database
   *
   * @param string  $command - id command is slow then delete all slow queries else delete specified query id.
   *
   * @return array $response - Return a response array of the request.
   */
  public function deleteQuery($command){
    $cmd='slow';
    if(strtolower($command)!=$cmd) $cmd=$command;
      $response=$this->delete('query/'.strtolower($command));
      return $response;
  }

  /**
   *  Change Property
   *
   *  change properties of a queries in the database
   *
   * @param array  $param - Array of parameters to send to the database as a options for query.
   *
   * @return array $response - Return a response array of the request.
   */
  public function changeQueryProp($param=NULL){
    $response=$this->get('query/properties');
    $data=array();
    if(isset($param['enabled'])) $data['enabled']=$param['enabled']; else $data['enabled']=$response['enabled'];
    if(isset($param['trackSlowQueries'])) $data['trackSlowQueries']=$param['trackSlowQueries']; else $data['trackSlowQueries']=$response['trackSlowQueries'];
    if(isset($param['maxSlowQueries'])) $data['maxSlowQueries']=$param['maxSlowQueries']; else $data['maxSlowQueries']=$response['maxSlowQueries'];
    if(isset($param['slowQueryThreshold'])) $data['slowQueryThreshold']=$param['slowQueryThreshold']; else $data['slowQueryThreshold']=$response['slowQueryThreshold'];
    if(isset($param['maxQueryStringLength'])) $data['maxQueryStringLength']=$param['maxQueryStringLength']; else $data['maxQueryStringLength']=$response['maxQueryStringLength'];
    $response=$this->put('query/properties');
    return $response;
  }

  /**
   *  clean cursor
   *
   *  Reset the cursor as default
   *
   * @return array $response - Return a response array of the request.
   */
  public function cleanCursor(){
    $response=$this->delete('cursor/'.$this->cursor_id);
    $this->hasMore=false;
    $this->cursor_id=NULL;
    $this->count=0;
    return $response;
  }

  /**
   * get result count
   *
   * @return number - result count.
   */
  public function getCount(){
    return $this->count;
  }

  /**
   * get cursor ID
   *
   * @return string - cursor ID.
   */
  public function getCursorId(){
    return $this->cursor_id;
  }
}



 ?>
