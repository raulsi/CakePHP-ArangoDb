<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for User Module
*
* This class provides functions to manage users in the server
*
*/
class DatabaseModel extends ArangoModel {

  public $name = 'DatabaseModel';

  var $useTable = false;

  /**
   *  Create User
   *
   *  Request to create a new user in the server
   *
   * @param string  $name - specify the user name to create.
   * @param array  $param - Array of parameters to send to the database as a data for user request.
   * @param string  $db - specify the database name to give access to.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function createUser($name,$param=NULL,$db=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($db!=NULL){
      $this->setDb($db);
    }
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $data = array();
    $data['user']=$name;
    if(isset($param['passwd'])) $data['passwd'] = $param['passwd'];
    if(isset($param['active'])) $data['active'] = $param['active'];
    if(isset($param['extra'])) $data['extra'] = $param['extra'];
    if(isset($param['changePassword'])) $data['changePassword'] = $param['changePassword'];
    $response=$this->post('user',$data,'json');
    $this->setDb($tempdb);
    return $response;
  }

  /**
   *  Get User
   *
   *  Request to get the user from the server
   *
   * @param string  $user - specify the user name to get.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getUser($user){
    $response=$this->get('user/'.$user,NULL,'json');
    return $response;
  }

  /**
   *  Replace User
   *
   *  Replaces the data of an existing user
   *
   * @param string  $name - specify the user name to replace.
   * @param array  $param - Array of parameters to send to the database as a data for user request.
   * @param string  $db - specify the database name to give access has.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function replaceUser($name,$param=NULL,$db=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($db!=NULL){
      $this->setDb($db);
    }
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $data = array();
    if(isset($param['passwd'])) $data['passwd'] = $param['passwd'];
    if(isset($param['active'])) $data['active'] = $param['active'];
    if(isset($param['extra'])) $data['extra'] = $param['extra'];
    if(isset($param['changePassword'])) $data['changePassword'] = $param['changePassword'];
    $response=$this->put('user/'.$name,$data,'json');
    $this->setDb($tempdb);
    return $response;
  }

  /**
   *  Update User
   *
   *  Partially updates the data of an existing user
   *
   * @param string  $name - specify the user name to update.
   * @param array  $param - Array of parameters to send to the database as a data for user request.
   * @param string  $db - specify the database name to give access has.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function updateUser($name,$param=NULL,$db=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($db!=NULL){
      $this->setDb($db);
    }
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $data = array();
    if(isset($param['passwd'])) $data['passwd'] = $param['passwd'];
    if(isset($param['active'])) $data['active'] = $param['active'];
    if(isset($param['extra'])) $data['extra'] = $param['extra'];
    if(isset($param['changePassword'])) $data['changePassword'] = $param['changePassword'];
    $response=$this->patch('user/'.$name,$data,'json');
    $this->setDb($tempdb);
    return $response;
  }

  /**
   *  Delete User
   *
   *  Removes an existing user
   *
   * @param string  $name - specify the user name to delete.
   * @param string  $db - specify the database name to give access has.
   * @param string  $user - specify the username to access the _system database if this user don't have access.
   * @param string  $user - specify the password to access the _system database if this user don't have access.
   *
   * @return array $response - Return a response array of the request.
   */
  public function deleteUser($name,$db=NULL,$user=NULL,$pass=NULL){
    $tempdb=$this->getDb();
    if($db!=NULL){
      $this->setDb($db);
    }
    if($user!=NULL and $pass!=NULL) {$this->setUser($user);$this->setPass($pass);}
    $response=$this->put('user/'.$name,NULL,'json');
    $this->setDb($tempdb);
    return $response;
  }
}

 ?>
