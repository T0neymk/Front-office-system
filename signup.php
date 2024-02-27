<?php
$servername= "localhost";
$username="root";
$password="";
$dbname="userdb";

//create connection
$conn= new mysqli($servername,$username,$password,$dbname);


//check connection
if($conn->connect_error){
  die("connection failed:"  .$conn->connect_error);
}

//Retrieve data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

// sql query to insert the data
$sql  = "INSERT INTO signup(fname,lname,email,password)VALUES('$fname','$lname','$email','$password')";

//check if the sql query has been executed successfully

if ($conn->query($sql)  === TRUE){
  echo "signup successfull";
}else{
  echo "error: " . $sql ."<br>" .$conn->error;
}


//close connection
$conn->close();

header("Location: home.html");
exit();
?>