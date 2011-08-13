<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Schema Creator</title>
</head>
<?php
function __autoload($class_name) {
include $class_name . '.php';
}
echo 'Welcome';
$thing=new Recipe('' ,'',''); //As Thing, the super parent class extends Tag. Tag construtor is invoked.
/* Update the existing recipe record Coffee */
echo $thing->RemoveThing(array("name" => "Tea"));
//echo $thing->UpdateCreativeWork(array("name" => "Coffee"), $newdata);
//echo $thing->UpdateRecipe(array("name" => "Coffee"), $newdata);
?>

</body>
</form>
</html>