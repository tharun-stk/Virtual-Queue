<?php 
include 'queuefunctions.php';
$connect= new Functions();
  $connection=$connect-> getConection();
  $custphone=$_SESSION['phone'];
  $customerhistory=$custphone.'custhistory';
  $customerfullhistory=$custphone.'fullhistory';
  $customersortedhistory=$custphone.'sortedhistory';
  $checkqueue="select * from $customersortedhistory ";
  $checkqueuevalue=$connect->select($connection,$checkqueue);
  
  if($checkqueuevalue!=null)
  {
    $checkqueuevaluerows=$connect->noofRows($checkqueuevalue);
  if($checkqueuevaluerows!=0){
      header('location:queue.php');
  }
  }
$checkactive="select * from user where phone='$custphone'";
$checkactivevalue=$connect->select($connection,$checkactive);
$checkactivevaluedata=$connect->fetchData($checkactivevalue);
if($checkactivevaluedata['isactive']==0){
  header('location:queue.php');

}
if(isset($_POST['exitnow'])){
  $isqctiveselect="select * from $customerfullhistory where isactive=1";
  $isqctiveselectvalue=$connect->select($connection,$isqctiveselect);
  $isactiveselectvaluedata=$connect->fetchdata($isqctiveselectvalue);
  $shopnumber=$isactiveselectvaluedata['shopnumber'];

  $queue=new Queuefunctions();
  $exitrow=$queue->exitqueuebefore($custphone,$shopnumber);
  if($exitrow==1){
    header('location:queue.php');
  }
}
if(isset($_POST['dash'])){
  header('location:customer.php');

}
if(isset($_POST['history'])){
  header('location:historyqueue.php');

}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/queuewaiting.css">
    <title>Waiting</title>
</head>
<body>
<form method='POST' class="myForm" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
  
<button name='dash' class="button button2 ">My Dashboard</button>
<button  name='history'class="button button2 ">History Queues</button>
<button name='exitnow' class="button button2 ">Exit for now</button>


</form>
<div class="loader">Loading your Queue...</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js">
  </script>
   
  <script type="text/javascript">
    $(document).ready(function () {
      setTimeout(function () {
      
        location.reload(true);
      }, 5000);
    });
  </script>
</body>
</html>