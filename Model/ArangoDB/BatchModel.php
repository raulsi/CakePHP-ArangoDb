<?php
namespace App\Model\ArangoDB;

use Cake\Core\App;
use App\Model\ArangoDB\ArangoModel;

/**
* A class for Batch Request
*
* This class provides functions to handle Batch request to the server
*
*/
class BatchModel extends ArangoModel {

  public $name = 'BatchModel';

  var $useTable = false;

  /**
   * Array of request to execute
   *
   * @var array
   */
  protected $_batch = array();

  /**
   * Array of headers for each request
   *
   * @var array
   */
  protected $_headers=array();

  /**
   * Array of response returned after execution
   *
   * @var array
   */
  protected $_response=array();

  /**
   * autoincrement content id if not specified
   *
   * @var number
   */
  protected $_contentId=0;

  /**
   * Batch Boundary to divide the multiple request
   *
   * @var string
   */
  protected $_boundaryValue='BatchBoundary';

  /**
   *  Add request
   *
   *  add a new request into the batch array
   *
   * @param string  $command - specify what function to execute on the server.
   * @param string  $method - specify which request to execute.
   * @param array  $option - Array of options to send as get request.
   * @param string  $contentId - specify content ID of batch request if null then a autoincrement value is added.
   * @param array  $data - Array of data to send with request.
   * @param array  $headers - Array of headers to set for request.
   *
   * @return string $cid - Return contentId after addition to the batch array.
   */
  public function add($command,$method,$option=NULL,$contentId=NULL,$data=NULL,$headers=NULL){
    $chkm=array('POST','GET','HEAD','PUT','PATCH','DELETE');
    $cid='';
    if((array_search(strtoupper($method),$chkm))!=0 or strtoupper($command)==$chkm[0]){
      switch(strtolower($command)){
        case 'document' :{
              switch (strtoupper($method)) {
                case 'POST':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="POST /_api/document?collection=".$option['collection'].(isset($option['createCollection'])!=0?"&createCollection=".$option['createCollection']:''.isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'GET':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  if(isset($option['id']))
                    $this->_batch[$cid]="GET /_api/document/".$option['collection']."/".$option['id'] ." HTTP/1.1 ";
                  else
                    $this->_batch[$cid]="GET /_api/document/?collection=".$option['collection']. (isset($option['type'])!=0?"&type=".$option['type']:'') . " HTTP/1.1 ";
                  break;
                case 'HEAD':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="GET /_api/document/".$option['collection']."/".$option['id'].  (isset($option['rev'])!=0?"?rev=".$option['rev']:'') . " HTTP/1.1 ";
                  break;
                case 'PUT':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="PUT /_api/document/".$option['collection']."/".$option['id']."?".(isset($option['rev'])!=0?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'PATCH':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="PATCH /_api/document/".$option['collection']."/".$option['id']."?".(isset($option['keepNull'])!=0?"&keepNull=".$option['keepNull']:'').(isset($option['mergeObjects'])!=0?"&mergeObjects=".$option['mergeObjects']:'').(isset($option['rev'])?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'DELETE':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="DELETE /_api/document/".$option['collection']."/".$option['id']."?".(isset($option['rev'])!=0?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
              }
              break;
        }
        case 'edge' :{
              switch (strtoupper($method)) {
                case 'POST':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="POST /_api/edge?collection=".$option['collection'].(isset($option['createCollection'])!=0?"&createCollection=".$option['createCollection']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'GET':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  if(isset($option['id']))
                    $this->_batch[$cid]="GET /_api/edge/".$option['collection']."/".$option['id'] ." HTTP/1.1 ";
                  else if(isset($option['vertex']))
                    $this->_batch[$cid]="GET /_api/edge/".$option['collection']."?".$option['vertex']. (isset($option['direction'])!=0?"&direction=".$option['direction']:'') . " HTTP/1.1 ";
                  else
                    $this->_batch[$cid]="GET /_api/edge/?collection=".$option['collection']. (isset($option['type'])!=0?"&type=".$option['type']:'') . " HTTP/1.1 ";
                  break;
                case 'HEAD':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="GET /_api/edge/".$option['collection']."/".$option['id'].  (isset($option['rev'])!=0?"?rev=".$option['rev']:'') . " HTTP/1.1 ";
                  break;
                case 'PUT':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="PUT /_api/edge/".$option['collection']."/".$option['id']."?".(isset($option['rev'])!=0?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'PATCH':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="PATCH /_api/edge/".$option['collection']."/".$option['id']."?".(isset($option['keepNull'])!=0?"&keepNull=".$option['keepNull']:'').(isset($option['mergeObjects'])!=0?"&mergeObjects=".$option['mergeObjects']:'').(isset($option['rev'])!=0?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
                case 'DELETE':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="DELETE /_api/edge/".$option['collection']."/".$option['id']."?".(isset($option['rev'])!=0?"&rev=".$option['rev']:'').(isset($option['waitForSync'])!=0?"&waitForSync=".$option['waitForSync']:'').(isset($option['policy'])!=0?"&policy=".$option['policy']:'') ." HTTP/1.1 \n " .json_encode($data);
                  break;
              }
              break;
        }
        case 'collection' :{
              switch (strtoupper($method)) {
                case 'POST':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="POST /_api/collection/ HTTP/1.1 \n ". json_encode($data);
                  break;
                case 'GET':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  if(isset($option['collection'])){
                    $cmd='';
                    if(isset($option['part'])) $cmd=$option['part'];
                    $this->_batch[$cid]="GET /_api/collection/".$option['collection']."/".$cmd.'?'. (isset($option['withRevisions'])!=0?"&withRevisions=".$option['withRevisions']:'').(isset($option['withData'])!=0?"&withData=".$option['withData']:'') ." HTTP/1.1 ";
                  }
                  else
                    $this->_batch[$cid]="GET /_api/collection".(isset($option['excludeSystem'])!=0?"&excludeSystem=".$option['excludeSystem']:'') . " HTTP/1.1 ";
                  break;
                case 'PUT':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $chkv=array('load','unload','truncate','properties','rename','rotate');
                  if(isset($option['part']) and (array_search(strtolower($option['part']),$chkv)!=0 or strtolower($option['part'])==$chkv[0])){
                    $this->_batch[$cid]="PUT /_api/collection/".$option['collection']."/".strtolower($option['part']) ." HTTP/1.1 \n " .json_encode($data);
                  }
                  break;
                case 'DELETE':
                  if($contentId!=NULL) $cid.=$contentId; else $cid.=$this->_contentId++;
                  $this->_batch[$cid]="DELETE /_api/collection/".$option['collection'] ." HTTP/1.1 \n " .json_encode($data);
                  break;
              }
              break;
        }
      }
      if($headers!=NULL) $this->_headers[$cid] = $headers;
      return (''.$cid);
    }else return (array("error" => "wrong method"));
  }

  /**
   *  Remove request
   *
   *  remove the the request from batch array
   *
   * @param string  $contentId - specify conetnt ID of batch request.
   *
   * @return boolean flag - return true if is removed successfully.
   */
  public function remove($contentId){
    if(isset($this->_batch[$contentId])){
      unset($this->_batch[$contentId]);
      return true;
    }else {
      return array("error" => "No content Id matched");
    }

  }

  /**
   *  Reset BatchModel
   *
   *  reset the whole model
   *
   * @return void.
   */
  public function reset(){
      $this->_contentId=0;
      $this->_batch=array();
      $this->_headers=array();
      $this->_response=array();
  }

  /**
   *  Preview batch request
   *
   *  preview the batch request to send
   *
   * @return string $batch - return string of requests divided by bounday value.
   */
  public function preview(){
    $batch='';

    foreach ($this->_batch as $key => $value) {
      $batch.="--".$this->_boundaryValue."\nContent-Type: application/x-arango-batchpart\nContent-Id: ".$key."\n";
      if(isset($this->_headers[$key])){
        foreach ($this->_headers[$key] as $k => $val) {
          $batch.=$k." : ".$val."\n";
        }
      }
      $batch.="\n".$value."\n";
    }
    $batch.="--".$this->_boundaryValue."--";

    return $batch;
  }

  /**
   *  Execute batch request
   *
   *  format the batch request and execute, divide each response and save it with there contentid.
   *
   * @return array $response - return response array of the ececuted batch request.
   */
  public function execute(){
    $batch='';
    $keys=array();
    foreach ($this->_batch as $key => $value) {
      array_push($keys,$key);
      $batch.="--".$this->_boundaryValue."\nContent-Type: application/x-arango-batchpart\nContent-Id: ".$key."\n";
      if(isset($this->_headers[$key])){
        foreach ($this->_headers[$key] as $k => $val) {
          $batch.=$k." : ".$val."\n";
        }
      }
      $batch.="\n".$value."\n";
    }
    $batch.="--".$this->_boundaryValue."--";
    $header=array();
    $header['Content-Type']='multipart/form-data';
    $header['boundary']=$this->_boundaryValue;
    $response=$this->batch('batch',$batch,'json',NULL,$header);
    $ar=explode('--BatchBoundary',$response->body);
    unset($ar[0]);
    foreach ($keys as $key => $value) {
      $ex=explode('{',$ar[$key+1],2);
      $this->_response[$value]=json_decode("{".$ex[1]);
    }
    return $response;
  }

  /**
   *  Get response
   *
   *  get the response requet executed
   *
   * @param string  $contentId - specify conetnt ID of batch reques.
   *
   * @return array $this->_response - if contentId is specified return specific object in a array else return whole array.
   */
  public function getResponse($contentId=NULL){
    if($contentId!=NULL) return $this->_response[''.$contentId]; else return $this->_response;
  }
}



 ?>
