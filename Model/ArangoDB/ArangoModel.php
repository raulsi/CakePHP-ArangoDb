<?php

namespace App\Model\ArangoDB;

use Cake\Network\Http\Client;

 /**
 * A class for ArangoDB connection
 *
 * This class provides functions to manage connection and handling request from server
 *
 */
class ArangoModel
{
    /**
     * Protocol used to connect
     *
     * @var string
     */
    protected $protocol = 'http';
    /**
     * Host of the server to connect
     *
     * @var string
     */
    protected $host = 'localhost';
    /**
     * Port of the server to connect
     *
     * @var string
     */
    protected $port = '8529';
    /**
     * Username to connect to server
     *
     * @var string
     */
    protected $user = 'root';
    /**
     * password to connect to server
     *
     * @var string
     */
    protected $pass = 'root';
    /**
     * Database to connect to
     *
     * @var string
     */
    protected $db = 'raulsi';

    /**
     *Database name index
     */
    const ENTRY_DB = '_db';

    /**
     * Api  index
     */
    const ENTRY_API = '_api';

    /**
     * Admin index
     */
    const ENTRY_ADMIN = '_admin';

    /**
     * Database ID index
     */

    const ENTRY_ID = '_id';

    /**
     * Document key index
     */
    const ENTRY_KEY = '_key';

    /**
     * Revision id index
     */
    const ENTRY_REV = '_rev';

    /**
     * isNew id index
     */
    const ENTRY_ISNEW = '_isNew';

    /**
     * hidden attribute index
     */
    const ENTRY_HIDDEN = '_hidden';

    /**
     * waitForSync option index
     */
    const OPTION_WAIT_FOR_SYNC = 'waitForSync';

    /**
     * policy option index
     */
    const OPTION_POLICY = 'policy';

    /**
     * keepNull option index
     */
    const OPTION_KEEPNULL = 'keepNull';



    /**
     * set a database
     *
     * This set a database
     *
     * @param string     $db       - the database specification, for example 'myDatabase'
     *
     * @return void.
     */
    public function setDb($db){
      $this->db=$db;
    }

    /**
     * get a database
     *
     * @return string - database name.
     */
    public function getDb(){
      return $this->db;
    }

    /**
     * set a username
     *
     * This set a username to connect
     *
     * @param string     $user       - Username to connect, for example 'root'
     *
     * @return void.
     */
    public function setUser($user){
      $this->user=$user;
    }

    /**
     * get a Username
     *
     * @return string - username name.
     */
    public function getUser(){
      return $this->user;
    }

    /**
     * set a password
     *
     * This set a password to connect
     *
     * @param string     $pass       - Password to connect, for example 'root'
     *
     * @return void.
     */
    public function setPass($pass){
      $this->pass=$pass;
    }

    /**
     * get a pass
     *
     * @return string - Password.
     */
    public function getPass(){
      return $this->pass;
    }

    /**
     *  Get Request
     *
     *  Execute get request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function get($url,$data=NULL,$type=NULL,$option=NULL,$header=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response=$http->get($uri,json_encode($data),['headers' => $header]);
      return $response;
    }

    /**
     *  Post Request
     *
     *  Execute post request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function post($url,$data=NULL,$type=NULL,$option=NULL,$headers=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response = $http->post(
        $uri,
        json_encode($data),
        ['type' => $type ],['headers' => $headers]
      );

      return $response;
    }

    /**
     *  Batch Request
     *
     *  Execute batch request as multiple request in a $data variable
     *
     * @param string  $url - url of the to send the request.
     * @param string  $data - list of multiple request divided by boundary value.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function batch($url,$data,$type=NULL,$option=NULL,$headers=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response = $http->post(
        $uri,
        $data,
        ['type' => $type ],['headers' => $headers]
      );

      return $response;
    }

    /**
     *  Push Request
     *
     *  Execute push request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function push($url,$data=NULL,$type=NULL,$option=NULL,$headers=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response = $http->push(
        $uri,
        json_encode($data),
        ['type' => 'json'],['headers' => $headers]
      );
      return $response;
    }

    /**
     *  Put Request
     *
     *  Execute put request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function put($url,$data=NULL,$type=NULL,$option=NULL,$headers=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response = $http->put(
        $uri,
        json_encode($data),
        ['type' => 'json'],['headers' => $headers]
      );
      return $response;
    }
    /**
     *  Patch Request
     *
     *  Execute patch request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function patch($url,$data=NULL,$type=NULL,$option=NULL,$headers=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response = $http->patch(
        $uri,
        json_encode($data),
        ['type' => 'json'],['headers' => $headers]
      );

      return $response;
    }

    /**
     *  delete Request
     *
     *  Execute delete request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function delete($url,$data=NULL,$type=NULL,$option=NULL,$header=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }

      $http = new Client();
      $response=$http->delete($uri,json_encode($data),['headers' => $header]);
      return $response;
    }

    /**
     *  Head Request
     *
     *  Execute head request
     *
     * @param string  $url - url of the to send the request.
     * @param Array  $data - Array to data to send if not null.
     * @param string  $type - Type of data specified in request.
     * @param Array  $option -  Array of options to add into request as get variables.
     * @param Array  $header -  Array of header to add into request as http headers.
     * @param boolean  $entityAdmin -  flag to use either _api or _admin in request.
     *
     *
     * @return array $response - The response array.
     */
    public function head($url,$data=NULL,$type=NULL,$option=NULL,$header=NULL,$entityAdmin=false){
      $entity=self::ENTRY_API;
      if($entityAdmin) $entity=self::ENTRY_ADMIN;
      $uri=$this->protocol.'://'.$this->user.':'.$this->pass.'@'.$this->host.':'.$this->port.'/'.self::ENTRY_DB.'/'.$this->db.'/'.$entity.'/'.$url;
      if($option != NULL){
        $uri.='?';
        foreach ($option as $key => $value) {
          # code...
          $uri.=$key.'='.$value.'&';
        }
      }
      $http = new Client();
      $response=$http->head($uri,['headers' => $header]);
      return $response;
    }

}
