<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Extraa functions
*
* This class provides extra functions provided by the server.
*
*/
class ExtraModel extends ArangoModel {

  public $name = 'ExtraModel';

  var $useTable = false;

  /**
   * Get WAL
   *
   * Retrieves the configuration of the write-ahead log.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getWal(){
    $response=$this->get('wal/properties',NULL,'json',NULL,NULL,true);
    return $response;
  }

  /**
   *  Update WAL
   *
   *  Configures the behavior of the write-ahead log.
   *
   * @param array  $param - Array of parameters to send to the database as a options for WAL request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function updateWal($param){
    $data=array();
    if(isset($param['allowOversizeEntries'])) $data['allowOversizeEntries']=$param['allowOversizeEntries'];
    if(isset($param['logfileSize'])) $data['logfileSize']=$param['logfileSize'];
    if(isset($param['historicLogfiles'])) $data['historicLogfiles']=$param['historicLogfiles'];
    if(isset($param['reserveLogfiles'])) $data['reserveLogfiles']=$param['reserveLogfiles'];
    if(isset($param['throttleWait'])) $data['throttleWait']=$param['throttleWait'];
    if(isset($param['throttleWhenPending'])) $data['throttleWhenPending']=$param['throttleWhenPending'];
    $response=$this->put('wal/properties',$data,'json',NULL,NULL,true);
    return $response;
  }

  /**
   *  Flush WAL
   *
   *  Flushes the write-ahead log.
   *
   * @param array  $param - Array of parameters to send to the database as a options for WAL request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function flushWal($param){
    $data=array();
    if(isset($param['waitForSync'])) $data['waitForSync']=$param['waitForSync'];
    if(isset($param['waitForCollector'])) $data['waitForCollector']=$param['waitForCollector'];

    $response=$this->put('wal/properties',$data,'json',NULL,NULL,true);
    return $response;
  }

  /**
   * Get Version
   *
   * Returns the server name and version number.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getVersion($details=false){
    $option=array('details'=>$details);
    $response=$this->get('version',NULL,'json',$option);
    return $response;
  }

  /**
   * Get LOG
   *
   * Returns fatal, error, warning or info log messages from the server's global log.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getLog($param=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($this->getDb()!='_system') $this->setDb('_system');
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $option = array();
    if(isset($param['upto'])) $option['upto']=$param['upto']; elseif (isset($param['level'])) $option['level'] = $param['level'];
    if(isset($param['start'])) $option['start']=$param['start'];
    if(isset($param['size'])) $option['size']=$param['size'];
    if(isset($param['offset'])) $option['offset']=$param['offset'];
    if(isset($param['search'])) $option['search']=$param['search'];
    if(isset($param['sort'])) $option['sort']=$param['sort'];
    $response=$this->post('log',NULL,'json',$option,NULL,true);
    $this->setDb($tempdb);
    return $response;
  }

  /**
   * Get WAL
   *
   * Retrieves the configuration of the write-ahead log.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getTime(){
    $response=$this->get('time',NULL,'json',NULL,true);
    return $response;
  }

  /**
   * Get Time
   *
   * Get Database time.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getEcho(){
    $response=$this->get('echo',NULL,'json',NULL,true);
    return $response;
  }

  /**
   * Get shutdown
   *
   * Send shutdown sequence
   *
   * @return array $response - Return a response array of the request.
   */
  public function getShutdown(){
    $response=$this->get('shutdown',NULL,'json',NULL,true);
    return $response;
  }

  /**
   * Get Test
   *
   *  Send test request
   *
   * @return array $response - Return a response array of the request.
   */
  public function getTest($body){
    $response=$this->get('test',$body,'json',NULL,true);
    return $response;
  }

  /**
   * Get Execute
   *
   * Execute the code on the database.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getExecute($body){
    $response=$this->get('execute',$body,'json',NULL,true);
    return $response;
  }

}



 ?>
