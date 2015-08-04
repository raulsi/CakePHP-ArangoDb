<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Siple Query
*
* This class provides functions to handle Simple Query.
*
*/
class SimpleModel extends CursorModel {

  public $name = 'SimpleModel';

  var $useTable = false;

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
   *  Execute simpleQuery
   *
   *  Execute a Simple query on the server
   * @param string $command - Type of simple Query to execute.
   * @param string $collection - Collection Id on which the simple query to execute.
   * @param string  $query - contains the query string to be executed.
   * @param array  $data - Array of data to pass as request.
   * @param array  $param - Array of parameters to send to the database as a options for Cursor.
   *
   * @return array $response - Return a response array of the request.
   */
  public function simpleQuery($command,$collection,$query=NULL,$data=NULL,$param=NULL){
    $jdata=array();
    switch (strtolower($command)) {
      case 'by-example-skiplist':{
        $jdata['collection']=$collection;
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        if(isset($param['index'])) $jdata['index']=$param['index']; else return (array("error"=>"Index must be exist of SkipList type"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        break;
      }
      case 'by-condition-skiplist':{
        $jdata['collection']=$collection;
        if($query!=NULL) $jdata['condition']=$query; else return (array("error"=>"Condition Query is required"));
        if(isset($param['index'])) $jdata['index']=$param['index']; else return (array("error"=>"Index must be exist of SkipList type"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        break;
      }
      case 'all':{
        $jdata['collection']=$collection;
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        break;
      }
      case 'any':{
        $jdata['collection']=$collection;
        break;
      }
      case 'near':{
        $jdata['collection']=$collection;
        if(isset($param['latitude'])) $jdata['latitude']=$para['latitude']; else return (array("error"=>"Latitude is required"));
        if(isset($param['longitude'])) $jdata['longitude']=$param['longitude']; else return (array("error"=>"Longitude is required"));
        if(isset($param['distance'])) $jada['distance']=$param['distance'];
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        if(isset($param['geo'])) $jada['geo']=$param['geo'];
        break;
      }
      case 'within':{
        $jdata['collection']=$collection;
        if(isset($param['latitude'])) $jdata['latitude']=$para['latitude']; else return (array("error"=>"Latitude is required"));
        if(isset($param['longitude'])) $jdata['longitude']=$param['longitude']; else return (array("error"=>"Longitude is required"));
        if(isset($param['radius'])) $jdata['radius']=$param['radius']; else return (array("error"=>"Radius is required"));
        if(isset($param['distance'])) $jada['distance']=$param['distance'];
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        if(isset($param['geo'])) $jada['geo']=$param['geo'];
        break;
      }
      case 'within-rectangle':{
        $jdata['collection']=$collection;
        if(isset($param['latitude1'])) $jdata['latitude1']=$para['latitude1']; else return (array("error"=>"Latitude is required"));
        if(isset($param['longitude1'])) $jdata['longitude1']=$param['longitude1']; else return (array("error"=>"Longitude is required"));
        if(isset($param['latitude2'])) $jdata['latitude2']=$para['latitude2']; else return (array("error"=>"Latitude is required"));
        if(isset($param['longitude2'])) $jdata['longitude2']=$param['longitude2']; else return (array("error"=>"Longitude is required"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        if(isset($param['geo'])) $jada['geo']=$param['geo'];
        break;
      }
      case 'fulltext':{
        $jdata['collection']=$collection;
        if($query!=NULL) $jdata['query']=$query; else return (array("error"=>"Query is required"));
        if(isset($param['attribute'])) $jdata['attribute']=$para['attribute']; else return (array("error"=>"Attribute is required"));
        if(isset($param['index'])) $jdata['index']=$param['index']; else return (array("error"=>"Index is required"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        break;
      }
      case 'by-example':{
        $jdata['collection']=$collection;
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        break;
      }
      case 'first-example':{
        $jdata['collection']=$collection;
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        break;
      }
      case 'first':{
        $jdata['collection']=$collection;
        if(isset($param['count'])) $jdata['count']=$param['count']; else $jdata['count']=1;
        break;
      }
      case 'last':{
        $jdata['collection']=$collection;
        if(isset($param['count'])) $jdata['count']=$param['count'];
        break;
      }
      case 'range':{
        $jdata['collection']=$collection;
        if(isset($param['attribute'])) $jdata['attribute']=$para['attribute']; else return (array("error"=>"Attribute is required"));
        if(isset($param['left'])) $jdata['left']=$param['left']; else return (array("error"=>"Left is required"));
        if(isset($param['right'])) $jdata['rigt']=$para['right']; else return (array("error"=>"Right is required"));
        if(isset($param['closed'])) $jdata['closed']=$param['closed']; else return (array("error"=>"Closed is required"));
        if(isset($param['skip'])) $jada['skip']=$param['skip'];
        if(isset($param['limit']) and isset($param['skip'])) $jada['limit']=$param['limit'];
        if(isset($param['geo'])) $jada['geo']=$param['geo'];
        break;
      }
      case 'remove-by-example':{
        $jdata['collection']=$collection;
        $option=array();
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
        if(isset($param['limit'])) $option['limit']=$param['limit'];
        $jdata['options']=$option;
        break;
      }
      case 'replace-by-example':{
        $jdata['collection']=$collection;
        $option=array();
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        if($data!=NULL) $jdata['newValue']=$data; else return (array("error"=>"NewValue is required"));
        if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
        if(isset($param['limit'])) $option['limit']=$param['limit'];
        $jdata['options']=$option;
        break;
      }
      case 'update-by-example':{
        $jdata['collection']=$collection;
        $option=array();
        if($query!=NULL) $jdata['example']=$query; else return (array("error"=>"Example Query is required"));
        if($data!=NULL) $jdata['newValue']=$data; else return (array("error"=>"NewValue is required"));
        if(isset($param['keepNull'])) $option['keepNull']=$param['keepNull'];
        if(isset($param['waitForSync'])) $option['waitForSync']=$param['waitForSync'];
        if(isset($param['limit'])) $option['limit']=$param['limit'];
        $jdata['options']=$option;
        break;
      }
      case 'remove-by-keys': case 'lookup-by-keys':{
        if($query!=NULL) $jdata['keys']=$query; else return (array("error"=>"Example Query is required"));
        $jdata['collection']=$collection;
        break;
      }
    }
    $response=$this->put('simple/'.strtolower($command),$jdata,'json');
    $cursor=$response->json;
    if(isset($cursor['count'])) $this->count=$cursor['count'];
    if(isset($cursor['count'])) if($cursor['hasMore']==true){ $this->cursor_id=$cursor['id']; $this->hasMore=$cursor['hasMore']; }
    return $response;
  }

}



 ?>
