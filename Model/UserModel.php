<?php
namespace App\Model;

use Cake\Auth\PasswordHasherFactory;
use Cake\Core\App;
use App\Model\ArangoDB\SimpleModel;
use App\Model\ArangoDB\DocumentModel;
use Cake\Network\Http\Client;
use Cake\Validation\Validator;

class UserModel {

  public $name = 'UserModel';

  var $useTable = false;

  protected $_passwordHasher;
  protected $_user = NULL;
  protected $_validateError='';
  public function findUser($username){
    $smq=new SimpleModel();
    $response=$smq->simpleQuery('first-example','users',array('username'=>$username));
    if($response->json['error'] === false)  return $response->json; else return '';

  }

  public function validateUser(){
    $this->_validateError='ok';

    $validator = new Validator();
    $validator
        ->requirePresence('email')
        ->add('email', 'validFormat', [
            'rule' => 'email',
            'message' => 'E-mail must be valid'
        ])
        ->add('password', 'length', ['rule' => ['minLength', 6]])
        ->requirePresence('name')
        ->notEmpty('name', 'We need your name.')
        ->requirePresence('username')
        ->notEmpty('username', 'We need Your Username.')
        ->add('username', 'length', ['rule' => ['minLength', 6]]);

    $errors = $validator->errors($this->_user);
    if (!empty($errors)) {
        $this->_validateError=$errors;
        return false;
    }else {
      return true;
    }
  }

  public function checkEmail($email){
    $smq=new SimpleModel();
    $response=$smq->simpleQuery('first-example','users',array('email'=>$email));
    if($response->json['error'] === false)  return $response->json; else return '';

  }
  public function passwordHasher()
  {
      if ($this->_passwordHasher) {
          return $this->_passwordHasher;
      }

      $passwordHasher = 'default';
      return $this->_passwordHasher = PasswordHasherFactory::build($passwordHasher);
  }
  public function add($data){
    $this->_user=$data;
    if($this->validateUser()){
      $hasher = $this->passwordHasher();
      $data['password']=$hasher->hash($data['password']);
      $this->_user=$data;
      if(empty($this->findUser($this->_user['username']))){
        if(empty($this->checkEmail($this->_user['email']))){
          $user=new DocumentModel();
          $response=$user->createDoc($this->_user,'users');
          if($response->json['error']==false){
            return true;
          } else return 'Some Error!';
        }else{
          return 'Email Already in use!';
        }
      }else {
        return 'Username Already Taken!';
      }
    }else {
      return $this->_validateError;
    }


    /*$data = array("name" => "Hagrid", "age" => "136");
    $option = array();
    $option['collection']='users';
    $res=$this->get('document',$data,'json',$option);

    var_dump($res);
    /*  $http = new Client();
  $response = $http->post(
      'http://root:root@localhost:8529/_db/raulsi/_api/document?collection=users',
      json_encode($data),
      ['type' => 'json']
    );

    $id=$response->json['_id'];
    $res=$http->get('http://root:root@localhost:8529/_db/raulsi/_api/document/'.$id);
    var_dump($res->json);
    $data = array("name" => "Rahul Singh", "age" => "24");
    $res = $http->patch(
      'http://root:root@localhost:8529/_db/raulsi/_api/document/'.$id,
      json_encode($data),
      ['type' => 'json']
    );
    var_dump($res->json);

      $data = array("query" => "FOR i IN users  FILTER i.`username` == 'raulsi'  RETURN i");
    $response = $http->post(
       'http://root:root@localhost:8529/_db/raulsi/_api/cursor',
       json_encode($data),
       ['type' => 'json']
     );

     var_dump($response->json);
*/

    /*
    $ch = curl_init();
    //step2
    curl_setopt($ch,CURLOPT_URL,"http://localhost:8529/_api/document?collection=users");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    /*curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cSession,CURLOPT_HEADER, false);
    //step3
    $result=curl_exec($cSession);
    //step4
    curl_close($ch);
    //step5
    echo $result;
    */
  }
}



 ?>
