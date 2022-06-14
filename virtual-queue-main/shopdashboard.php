<?php include 'Functions.php';
  $shopnumber=$_SESSION["phone"];
  $connect= new Functions();
  $connection=$connect-> getConection();
  $sql="select * from shopdetails where phone='${shopnumber}'";
  $value=$connect->select($connection,$sql);
  $shopdetails=$connect->fetchdata($value);
  if(isset($_POST['start'])){
      if($shopdetails['isactive']==0){
      $sqlupdateactive="update shopdetails set isactive=1,availabletokens=100 where phone='${shopnumber}'";
      $sqlupdateactivevalue=$connect->select($connection,$sqlupdateactive);
      header('location:shopdashboard.php');
      }
  }
  if(isset($_POST['stop'])){
    if($shopdetails['availabletokens']==100){
    $sqlupdateactive="update shopdetails set isactive=0 where phone='${shopnumber}'";
    $sqlupdateactivevalue=$connect->select($connection,$sqlupdateactive);
    header('location:shopdashboard.php');

 }
    else{
        ?><div class='error'><h2 >you have pending queue</h2></div>
    <?php }
}
if(isset($_POST['view'])){
    header('location:shopdashboardhistory.php');
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shopdashboard.css">
    <title>Shop Dashboard</title>
</head>
<body>
<div class='name-logout'>
        <p><?php echo "HI "; echo $shopdetails['shopname'];?><p>
        <a href="index.php"><button class="button button2 button1">Logout</button></a>
    </div>

<form method='POST' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?> ">
    <div class='summary'>
        <div class="img"><img src="<?php echo $shopdetails['image']; ?>" alt="loading" srcset=""></div>
        <div class="des">
            <h2>Description</h2>
            <p><?php echo $shopdetails['descrption'] ; ?></p>
           <div class=separtor> <div class='action'>
          <button id='start' onClick="window.location.reload();" name='start' class="button button2">Start Token</button>
          <button id='stop' onClick="window.location.reload();" name='stop' class="button button2">Stop Token</button>
          <button name='view'class="button button2">View Customers</button>
    </div>
    <div class='table'>
        <table>
            <tr>
                <th>
                    TOTAL TOKENS
                </th>
                <th>AVAILABLE TOKENS</th>
</tr>
<tr><td><?php echo $shopdetails['totaltokens'] ;?></td><td><?php echo $shopdetails['availabletokens'] ;?></td></tr></table>

    </div>
</div>
  

</div>
</form>
<script>
    
    shop=<?php echo $shopdetails['isactive'] ?>;

    if (shop == 1) {
        document.getElementById("stop").style.backgroundColor = 'red';
} 
else
if (shop == 0) {
        document.getElementById("start").style.backgroundColor = '#4CAF50';}
      </script>
</body>
</html>