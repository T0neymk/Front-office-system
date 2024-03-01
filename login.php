
<?php
session_start(); // Start the session to use session variables


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
$email =$_POST['emlog'];
$password =$_POST['passlog'];

//sql query to validate the input
$sql = "SELECT * FROM signup WHERE email ='$email' AND password ='$password'  ";

$result = $conn->query($sql);


//validate the input

if ($result->num_rows>0){
  $row = $result->fetch_assoc();

  //verify password
  // if (password_verify($password,$row['password'])){
    $_SESSION['fname'] = $row['fname'];
    $_SESSION['email'] = $row['email'];
    header("location: services.html");
    exit();
  // }else{
    // echo"password did not match";
  // }
}else{
  echo"user not found or incorrect details";
}

//close connection
$conn->close();





?>

