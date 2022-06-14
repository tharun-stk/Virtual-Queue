<?php include 'Functions.php';
  $shopnumber=$_SESSION["phone"];
  
  $connect= new Functions();
  $connection=$connect-> getConection();
  $sql="select * from shopdetails where phone='${shopnumber}'";
  $value=$connect->select($connection,$sql);
  $shopdetails=$connect->fetchdata($value);
  $rows=$connect->noofrows($value);
  if(isset($_POST['summit'])){
	$t=$_POST['name'];
	$u=$_POST['phone'];
	$p=$_POST['des'];
	$c=$_POST['tokens'];
    $lat=$_POST["latitude"];
    $lon=$_POST["longitude"];
    
    

	//code for image uploading
	if($_FILES['f1']['name']){
		move_uploaded_file($_FILES['f1']['tmp_name'], "uploads/".$_FILES['f1']['name']);
		$img="uploads/".$_FILES['f1']['name'];
 
	}

	$i="insert into shopdetails(shopname,phone,descrption,totaltokens,availabletokens,image,latitude,longitude) values('$t','$u','$p','$c','$c','$img','$lat','$lon')";
	if($connect->select($connection,$i)){?>
		<p><?php echo "account added!"; ?></p>
      <a href="shopdashboard.php"> <button type="submit" CLASS="shopredirect" >GO TO YOUR ACCOUNT</button></a> 
        <?php
	}
}
  
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<link rel="stylesheet" href="css/shop.css">

     <title>Shop</title>
 </head>
 <body onload=getLocation();>
<?php
    if($rows==NULL)
      {?>
      

<html>
	<head>
	<meta charset="UTF-8">
	<title></title>
	</head>
	<body>
    <div class="main-block">
            <form method="POST" class="myForm" enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <div class="title">
          <i class="fas fa-pencil-alt"></i> 
          <h2>Register here</h2>
        </div>
        <div class="info">
          <input class="text" type="text" name="name" placeholder="Shop name">
          <input type="text" name="des" placeholder="Descrption">
          <input type="text" name="phone" placeholder="Phone number">
          <input type="text" name="tokens" placeholder="Tokens you have">


          <input type="file" class='file' name="f1" placeholder="Image">
          <input type="hidden" class="lat" name="latitude" id="demo" value="">
          <input type="hidden" class="lon" name="longitude" id="longitude" value="">

        </div>
      
        <button type="submit" name="summit">Submit</button>
      </form>
    </div>
	</body>
</html>
        
     <?php }
     else{
        header('Location:shopdashboard.php');}?>
     <script>


function getLocation() {
    getLatitude();
    getLongitude();

}

function getLatitude() {
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionla);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPositionla(position) {
    
    var z= position.coords.latitude;

    document.querySelector('.myForm input[name = "latitude"]').value=z;
}




function getLongitude() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionlo);
    } else {
        y.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPositionlo(position) {
   var t=position.coords.longitude;
   document.querySelector('.myForm input[name = "longitude"]').value=t;

  

}

</script>


 </body>
 </html>