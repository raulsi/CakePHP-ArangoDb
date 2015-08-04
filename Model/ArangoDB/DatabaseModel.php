<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Database Module
*
* This class provides functions to manage database in the server
*
*/
class DatabaseModel extends ArangoModel {

  public $name = 'DatabaseModel';

  var $useTable = false;


  /**
   *  Create Database
   *
   *  Request to create a new databsae in the server
   *
   * @param string  $name - specify the database name to create.
   * @param array  $param - list of user objects to initially create for the new database.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function createDatabase($name,$param=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($this->getDb()!='_system') $this->setDb('_system');
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $data = array();
    $data['name']=$name;
    if($param!=NULL) $data['users']=$param;
    $response=$this->post('database',$data,'json');
    $this->setDb($tempdb);
    return $response;
  }

  /**
   *  Get Database
   *
   *  Request to get the database from the server
   *
   * @param string  $command - command to specify surrent or users all database.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getDatabase($command='current'){
    $uri='database';
    $chkv=array('current','user');
    if($command!=NULL and (array_search(strtolower($command),$chkv)!=0 or strtolower($command)==$chkv[0])){
      $uri.='/'.strtolower($command);
      $response=$this->get($uri,NULL,'json');
      return $response;
    }else{
      return (array('error'=>"Wrong Command!"));
    }
  }

  /**
   *  List Database
   *
   *  Request to list all database from server
   *
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function listDatabase($user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($this->getDb()!='_system') $this->setDb('_system');
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $response=$this->get('database',NULL,'json');
    $this->setDb($tempdb);
    return $response;
  }

  /**
   *  Delete Database
   *
   *  Request to delete the database from the server
   *
   * @param string  $database - specify the database name to delete.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function deleteDatabase($database,$user=NULL,$pass=NULL){
    if($database!='_system'){
      $tempdb=$this->getDb();
      if($this->getDb()!='_system') $this->setDb('_system');
      if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
      $response=$this->delete('database/'.$database,NULL,'json');
      $this->setDb($tempdb);
      return $response;
    }else{
      return (array('error'=>"Cannot delete _system Database!"));
    }
  }
}

 ?>
