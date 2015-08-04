<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Tasks
*
* This class provides functions to handle Task in the database.
*
*/
class TasksModel extends ArangoModel {

  public $name = 'TasksModel';

  var $useTable = false;

  /**
   *  Create Task
   *
   *  Request to create a new Task in the database
   *
   * @param string  $name - specify the task name to create.
   * @param string  $command - JavaScript code to be executed.
   * @param array  $param - Array of parameters to send to the database as a options for task.
   *
   * @return array $response - Return a response array of the request.
   */
  public function createTasks($name,$command,$param=NULL){
    $data = array();
    $data['name']=$name;
    $data['command']=$command;
    if(isset($param['paramss'])) $data['params']=$param['params'];
    if(isset($param['period'])) $data['period']=$param['period'];
    if(isset($param['offset'])) $data['offset']=$param['offset'];
    $response=$this->post('tasks',$data,'json');
    return $response;
  }

  /**
   *  Get Task
   *
   *  Request to get the task from the database
   *
   * @param string  $id - specify the task id to get from the database.
   *
   * @return array $response - Return a response array of the request.
   */
  public function getTasks($id){
    $response=$this->get('tasks/'.$id,NULL,'json');
    return $response;
  }

  /**
   * Regiser New Task
   *
   *  Request to Register new task in the database
   *
   * @param string  $id - specify the task ID .
   * @param string  $name - Task name to register new task .
   * @param string  $command - specify the command to update the task.
   * @param array  $param - Array of parameters to send to the database as a options for task request.
   *
   * @return array $response - Return a response array of the request.
   */
  public function RegNewTasks($id,$name,$command,$param=NULL){
    $option=array();
    $data['name']=$name;
    $data['command']=$command;
    if(isset($param['paramss'])) $data['params']=$param['params'];
    if(isset($param['period'])) $data['period']=$param['period'];
    if(isset($param['offset'])) $data['offset']=$param['offset'];
    $response=$this->put('tasks/'.$id,$data,'json');
    return $response;
  }

  /**
   *  Delete Task
   *
   *  Request to delete the task from the database
   *
   * @param string  $id - specify the task name to get from the database.
   *
   * @return array $response - Return a response array of the request.
   */
  public function deleteTasks($id){
    $option=array();
    $response=$this->delete('tasks/'.$id,NULL,'json');
    return $response;
  }
}

 ?>
