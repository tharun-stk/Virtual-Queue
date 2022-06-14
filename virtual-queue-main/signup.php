<?php include 'Functions.php';
if (isset($_POST["phone"]) && isset($_POST["psw"])){
$name=$_POST['name'];
$phone=$_POST['phone'];
$password=$_POST['psw'];
$user=$_POST['usertype'];
$secret=$_POST['secret'];
$answer=$_POST['answer'] ;
$connect= new Functions();
$connection=$connect-> getConection();
$sql="insert into user values($phone,'$name','$password','$secret','$answer','$user')";
$value=$connect->select($connection,$sql);
if(isset($value)){
    header('Location: index.php');
}
}
?>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">

<link rel="stylesheet" href="css/signup.css">
<link rel="stylesheet" href="css/login.css">
<nav>
        <div class='imglogo'>
            <img src="images/Eagle Mascot Logo.jpg" alt="">
</div>

</nav>
<div class="signupc">
<div class="testbox">
  <h1>Registration</h1>

  <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
      <hr>
      <label id="icon" for="usertype"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
</svg></label>
  <select type="text" name="usertype" id="secret" requied>
    <option value="1">Customer</option>
    <option value="2">Shopkeeper</option>
  </select>
  <hr>
  <label id="icon" for="phone"><i class="icon-phone "></i></label>
  <input type="number" name="phone" id="name" placeholder="Phone" required/>
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="name" id="name" placeholder="Name" required/>
  <label id="icon" for="psw"><i class="icon-shield"></i></label>
  <input type="password" name="psw" id="name" placeholder="Password" required/>
  <label for="secret" id="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question" viewBox="0 0 16 16">
  <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
</svg></label>
  <select name="secret" type="text" id="secret" requied>
    <option value="1">What is your Pets name</option>
    <option value="2">What is your nick name</option>
    <option value="3">What is your school name</option>
  </select>
  <label id="icon" for="answer"><i class="icon-check"></i></label>
  <input type="text" name="answer" id="name" placeholder="Answer" required/>
  <br><br>
 
   <p>By clicking Register, you agree on our <a href="">terms and condition</a>.</p>
   <button class="button">Register</button>
   <a href="index.php" class="button closesignup">Close</a>
  </form>
</div>
  </div>