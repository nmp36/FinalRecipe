<?php
/**
* Description of DBLayer
*This class is responsible for making DB Connection , create ,update ,delete or insert operations.
* This is being used through out application.
* @author Dishna
*/
class DBLayer
{
    //Create method to make database connection
    private $i = 0;
    private $colName;
    private $conn;
    private $Collect;
    private $dbObj;
    private $Id;
    private $abc;
    Protected $RecipeArray;
    private $arr;
    
    function __construct()
    {
    $username = 'kwilliams';
    $password = 'mongo1234';
    $conn= singleton::singleton($username, $password);
    $this->dbObj = $conn->recipe;
    }
    Function setCollectionObj($colName)
    {
    $this->Collect=$this->dbObj->selectCollection("$colName");
    }
    //Retrieve Collection Method
    public function get_CollectionObject($colName)
    {
    $this->Collect=$this->dbObj->selectCollection("$colName");
    $cursor = $this->Collect->find();
    return $cursor;
    }
    public function get_CollectionObjectbyId($colName,$Id)
    {

    $this->Collect=$this->dbObj->selectCollection("$colName");
    $cursor = $this->Collect->find();
    return $cursor;
    }
    /*get object collection by Search Paramter,Retrive all child documents and then create nested array 
    and sent back to Caller.*/
    public function get_CollectionObjectbysearchParameter($colName,$SrchParm,$srchprmval)
    {
        
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        $cursor = $this->Collect->find(array($SrchParm => $srchprmval));
        $this->i=0;
        /*Loop through all parent records and retrive child based on _ID attribute*/
       //if ($cursor->hasNext())
       //{
        while ($document = $cursor->getNext())
        {
        //echo $document['_id'];
        $CWback=$this->dbObj->CreativeWorkTest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
        $recipeback=$this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("_id" => $CWbackResult['_id']));
        /*Creating array of one recipe document*/
        $this->RecipeArray=array(
             "Thing"=>$document,
             "CreativeWork"=>$CWbackResult,
             "Recipe"=>$RecipeResult
                 );
        $this->arr[$this->i]=$this->RecipeArray;
        $this->i=$this->i+1;

        }    
    //print_r($arr);
        return $this->arr;
       
    }
    public function InsertCollection($obj)
    {
    
    $Recipe=$obj["Recipe"];
    $RecipeCollection=$this->dbObj->selectCollection("RecipeTest");
    $RecipeCollection->Insert($Recipe);
    //$RecipeRef = MongoDBRef::create($RecipeCollection->getName(),$Recipe['_id']);

    $CreativeWork=$obj["CreativeWork"];
    //$CreativeWork["RecipeReference"]=$RecipeRef;
    $CreativeWork['_id']=$Recipe['_id'];
    $CreativeWorkCollection=$this->dbObj->selectCollection("CreativeWorkTest");
    $CreativeWorkCollection->Insert($CreativeWork);
    //$CreativeWrokRef = MongoDBRef::create($CreativeWorkCollection->getName(), $CreativeWork['_id']);

    $thing=$obj["Thing"];
    $thingCollection=$this->dbObj->selectCollection("Thingtest");
    $thing['_id']=$CreativeWork['_id'];
    $thingCollection->Insert($thing);
     
    $recipeback=$this->dbObj->RecipeTest;
    $RecipeResult = $recipeback->findOne(array("ingredients" => "Chicken"));
    //echo 'Result'.$RecipeResult['_id'];
    //print_r($RecipeResult);
    $CWback=$this->dbObj->CreativeWorkTest;
    $CWbackResult = $CWback->findOne(array("_id" => $RecipeResult['_id']));
    //print_r($CWbackResult);
    
    $Thback=$this->dbObj->Thingtest;
    //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
    $ThbackResult = $Thback->findOne(array("_id" => $CreativeWork['_id']));
    //print_r($ThbackResult);
    }
    //Update collection based on Criteria and New data.
    public function SaveCollection($obj,$id)
    {
     //save obj values into Collection
     // save will insert if obj doesn't exists in database or updates obj if exists.
     if(!is_null($obj)|| !is_null($this->Collect))
     if (!is_null($id))
     {
     $obj['_id']=$id;
     }
     $this->Collect->save($obj);
     return $obj['_id'];
    }
    
//Update collection based on Criteria and New data.
    public function UpdateCollection($colName,$criteria,$newData)
    {
    //Insert obj values into Collection
    if(!is_null($colName)|| !is_null($this->Collect))
    $this->Collect=$this->dbObj->selectCollection("$colName");
    $this->Collect->update($criteria, $newData);
    }
    //Remove collection Record
    public function RemoveCollection($colName,$criteria)
    {
    //Insert obj values into Collection
     if(!is_null($colName)|| !is_null($this->Collect))
     $this->Collect=$this->dbObj->selectCollection("$colName");
     $this->Collect->remove($criteria, true );
    }
}
/*SingleTon design Pattern Implementation*/
class singleton
{
    private static $instance;
    private $count = 0;
    private function __construct()
    {
    }
    public static function singleton($username,$password)
    {
    if (!(self::$instance)) {
    $className = __CLASS__;
    self::$instance = new Mongo("mongodb://${username}:${password}@localhost/test",array("persist" => "x"));;
    }
    return self::$instance;
    }
    public function increment()
    {
        return $this->count++;
    }
    public function __clone()
    {
    trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
    trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}

?>


