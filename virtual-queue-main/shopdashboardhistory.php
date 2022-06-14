<?php include 'queuefunctions.php';
  $connect= new Functions();
  $connection=$connect-> getConection();
  $shopnumber=$_SESSION["phone"];
  $sqlshop="select * from shopdetails where phone='$shopnumber'";
  $sqlshopvalue=$connect->select($connection,$sqlshop);
  $sqlshopvaluedata=$connect->fetchdata($sqlshopvalue);
  $shopname=$sqlshopvaluedata['shopname'];
  $sqlshophistoryname=$shopname.'sortedhistory';
  $sqlshophistory="select * from $sqlshophistoryname";
  $sqlshophistoryvalue=$connect->select($connection,$sqlshophistory);
  

  $selectcurentrow="select * from $sqlshophistoryname";
  $selectcurentrowvalue=$connect->select($connection,$selectcurentrow);
  $selectcurentrowvaluecount=$connect->noofRows($selectcurentrowvalue);
if($selectcurentrowvalue==null or $selectcurentrowvaluecount==0){
  header('location:notavailable.php');
}



  if(isset($_POST['remove'])){
    $customerphone=$_POST['remove'];
    $customersortedhistory=$customerphone.'sortedhistory';
    $selectcurentrow="select * from $customersortedhistory where phone='${customerphone}'";
  $selectcurentrowvalue=$connect->select($connection,$selectcurentrow);
    $selectcurentrowdataphone=$connect->fetchData($selectcurentrowvalue);
    $inqueueshop=$selectcurentrowdataphone['shopnumber'];
  $queue=new Queuefunctions();
  $rowremove=$queue->exitqueue($customerphone,$inqueueshop);
  if($rowremove==1){
    header('location:shopdashboardhistory.php');
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/shopdashboardhistory.css">
  <title>Shop History</title>
</head>
<body>
  <nav>
<a href="shopdashboard.php"><button class="button button2 ">My Dashboard</button></a>
<a href="shophistory.php"><button class="button button2 ">My History</button></a>


  </nav>
  <form method="POST" class="myForm"  action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

<div class="container">
<h1>PRESENT QUEUE </h1>
  <table class="rwd-table">
    <tbody>
      <tr>
        <th>Phone</th>
        <th>Token No</th>
        <th></th>

      </tr>
      
      <?php while($sqlshophistoryvaluedata=$connect->fetchData($sqlshophistoryvalue)){?>
        <tr>
<td><?php echo $sqlshophistoryvaluedata['phone'];?></td>
<td><?php echo $sqlshophistoryvaluedata['tokenno'];?></td>
<td><button name='remove' value='<?php echo $sqlshophistoryvaluedata['phone'];?>'>Remove</button></td>
</tr>
<?php } ?>
     
    </tbody>
  </table>
  
</div>
      </form>
</body>
</html>
