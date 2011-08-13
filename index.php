<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form method="post" name="search" >
<title>Schema Creator</title>
</head>
<?php
    $message = NULL;

    function __autoload($class_name) {
        include $class_name . '.php';
    }

    if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["url"])) 
    {
    echo 'Please Enter Recipe Name and Hit Search.' ;
    }
    else
    {
    $thing=new Recipe();
    $result=$thing->SearchRecipe("name", $_POST["name"]);
    if($result==0)
    {
    $message="Recipe does not exist"; 
    }
    }
    ?>

<body>
<div style="border-style: outset; width: 450px" align="left">
<h2 style="color: red" align="center">Welcome to Recipe System</h2>
<h4 align="center"><label id=questionLabel ><? echo $message; ?></label></h4>
<?php
            ini_set("display_errors", "On");
            $thing = new Thing();
            $form = new FormGenerator();

            $form->generate($thing);
            ?>
<input type="submit" name="Check" title="Check" value="Search Recipe"/>
<h4>
<a href='Add.php'>Add</a>
</h4>
<h4>
<a href='UpdateRecipe.php'>Update</a>
</h4>
<h4>
<a href='DeleteRecipe.php'>Delete</a>
</h4>
</div>
</body>
</form>
</html>