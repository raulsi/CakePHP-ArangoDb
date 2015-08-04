# CakePHP-ArangoDb
ArangoDB Model for CakePHP

Installation:
--------

To use the code just copy the ArangoDB Folder in /src/Model/ folder.


Example:
------

include the models

```PHP
  use App\Model\ArangoDB\Document;
  use App\Model\ArangoDB\DocumentModel;
```

either
```PHP
  $doc= new Document();
  $data=array("name"=>"ABC","email"=>"abc@abc.com");
  $doc->setData($data);
  $doc->setCollection('users');
  $model=new DocumentModel();
  $doc=$model->createDoc($doc);
  echo $doc->getID();
```

or
```PHP
  $doc= new Document();
  $data=array("name"=>"ABC","email"=>"abc@abc.com");
  $model=new DocumentModel();
  //$doc->setData($model->createDoc($data,'users',array("createCollection"-=>true,...)));
  $doc->setData($model->createDoc($data,'users'));
  echo $doc->getID();
```


To use the Default AuthComponent:
-------------------
Copy the UserModel.php into the Model Folder and edit the BaseAuthenticate in 
<app_dir>/vendor/cakephp/cakephp/src/Auth/BaseAuthenticate.php


```PHP
.......
use App\model\UserModel;
abstract class BaseAuthenticate implements EventListenerInterface
{
..........
  protected function _query($username)
    {
        $config = $this->_config;
        $doc=new UserModel();
        $query=$doc->findUser($username);
        
        return $query;
    }
..........
}
```



Thank You <br>
Rahul Singh

