<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Traversal
*
* This class provides functions to handle Traversal in the database.
*
*/
class TraversalModel extends ArangoModel {

  public $name = 'TraversalModel';

  var $useTable = false;

  /**
   *  Execute Traversal
   *
   *  Execute a Traversal on the database
   *
   * @param string  $startVertex -  id of the startVertex.
   * @param string  $edgeCollection - name of the collection that contains the edges.
   * @param string  $graphName - name of the graph that contains the edges.
   * @param array  $param - Array of parameters to send to the database as a options for Traversal.
   *
   * @return array $response - Return a response array of the request.
   */
  public function execute($startVertex,$edgeCollection=NULL,$graphName=NULL,$param=NULL){
    if($edgeCollection!=NULL and $graphName!=NULL){
      $data = array();
      $data['startVertex']=$startVertex;
      if($edgeCollection!=NULL) $data['edgeCollection']=$edgeCollection;
      if($graphName!=NULL) $data['graphName']=$graphName;
      $data['actions']=$action;
      if(isset($param['filter'])) $data['filter']=$param['filter'];
      if(isset($param['minDepth'])) $data['minDepth']=$param['minDepth'];
      if(isset($param['maxDepth'])) $data['maxDepth']=$param['maxDepth'];
      if(isset($param['visitor'])) $data['viitor']=$param['visitor'];
      if(isset($param['direction'])) $data['direction']=$param['direction'];
      if(isset($param['int'])) $data['int']=$param['int'];
      if(isset($param['expander'])) $data['expander']=$param['expander'];
      if(isset($param['sort'])) $data['sort']=$param['sort'];
      if(isset($param['stategy'])) $data['stategy']=$param['strategy'];
      if(isset($param['order'])) $data['order']=$param['order'];
      if(isset($param['itemOrder'])) $data['itemOrder']=$param['itemOrder'];
      if(isset($param['order'])) $data['order']=$param['order'];
      if(isset($param['itemOrder'])) $data['itemOrder']=$param['itemOrder'];
      if(isset($param['uniqueness'])) $data['uniqueness']=$param['uniqueness'];
      if(isset($param['maxIterations'])) $data['maxIterations']=$param['maxIterations'];
      $response=$this->post('traversal',$data,'json');
      return $response;
    }else return array("error" => "Must have either EdgeCollection or Graphname");
  }
}

 ?>
