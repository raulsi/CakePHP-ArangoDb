<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;
/**
* A class for managing AQLFunctions
*
* This class provides functions to manage AQLFunctions in the server
*
*/
class AQLFunctionModel extends ArangoModel {

  public $name = 'AQLFunctionModel';

  var $useTable = false;

  /**
   *  Create AQLFunction
   *
   *  Request to create a new AQLFunction in the database
   *
   * @param string  $name - the fully qualified name of the user functions.
   * @param string  $code - a string representation of the function body.
   *
   * @return array $response - The response array.
   */
  public function createAQLFunction($name,$code){
    $data = array();
    $data['name']=$name;
    $data['code']=$code;
    $response=$this->post('aqlfunction',$data,'json');
    return $response;
  }

  /**
   *  Get AQLFunction
   *
   *  Request to get AQLFunction from database
   *
   * @param string  $namespace - User namespace to get the AQLFunction from.
   *
   * @return array $response - The response array.
   */
  public function getAQLFunction($namespace=NULL){
    if(isset($namespace))  $option['namespace']=$namespace;
    $response=$this->get("aqlfunction",NULL,'json',$option);
    return $response;
  }

  /**
   *  Delete AQLFunction
   *
   *  Request to delete AQLFunction from the database
   *
   * @param string  $name - the fully qualified name of the user functions.
   * @param string  $group - If set to true, then the function name provided in name is treated as a namespace prefix,
   *                         and all functions in the specified namespace will be deleted. If set to false, the function name provided
   *                         in name must be fully qualified, including any namespaces.
   *
   * @return array $response - The response array.
   */
  public function deleteAQLFunction($name,$group=false){
    $option=array();
    if(isset($group)) $option['group']=$group;
    $response=$this->delete('aqlfunction/'.$name,NULL,'json',$option);
    return $response;
  }
}

 ?>
