<?php include 'functions.php';
class Queuefunctions{
    public function joinqueue($shopnumber,$custphone,$custlatitude,$custlongitude){
        

$connect= new Functions();
$connection=$connect-> getConection();
$sql="select * from shopdetails where phone='${shopnumber}'";
$value=$connect->select($connection,$sql);



$shopdetails=$connect->fetchData($value);
$shoplatitude=$shopdetails['latitude'];
$shopname=$shopdetails['shopname'];

$shoplongitude=$shopdetails['longitude'];
$shopnamefortablejoined=$shopname.'joined';
$shopnamefortablehistory=$shopname.'history';
$shopnamesorted=$shopname.'sorted';
$shopnamesortedhistory=$shopname.'sortedhistory';

$customerfullhistory=$custphone.'fullhistory';

$sqle = "create table if not exists $shopnamefortablejoined (phone varchar(100),distance varchar(30),id int auto_increment,primary key(id))";
$sqlvalue=$connect->select($connection,$sqle);
$sqlhistory="create table if not exists $shopnamefortablehistory (phone varchar(100),token varchar(100),date varchar(100))";
$sqlhistoryvalue=$connect->select($connection,$sqlhistory);
$sqlsorted = "create table if not exists $shopnamesorted (phone varchar(100),distance varchar(30),tokenno varchar(50))";
$sqlsortedvalue=$connect->select($connection,$sqlsorted);
$sqlsortedhistory = "create table if not exists $shopnamesortedhistory (phone varchar(100),distance varchar(30),tokenno varchar(50))";
$sqlsortedhistoryvalue=$connect->select($connection,$sqlsortedhistory);

$sqlcustomerfullhistory="create table if not exists $customerfullhistory (phone varchar(100),shopnumber varchar(30),isactive int )";
$sqlcustomerfullhistoryvalue=$connect->select($connection,$sqlcustomerfullhistory);
$sqlcustomerfullhistoryinsert="insert into $customerfullhistory(phone,shopnumber,isactive) values($custphone,$shopnumber,1)";
$sqlcustomerfullhistoryinsertvalue=$connect->select($connection,$sqlcustomerfullhistoryinsert);



$sqlcountrows="select * from $shopnamefortablejoined";
$sqlcountrowsvalue=$connect->select($connection,$sqlcountrows);
$sqlcountrowssorted="select * from $shopnamesorted";
$sqlcountrowssortedvalue=$connect->select($connection,$sqlcountrowssorted);


$countofrowsinjoined=$connect->noofRows($sqlcountrowsvalue);
$countofrowsinsorted=$connect->noofRows($sqlcountrowssortedvalue);



if($countofrowsinjoined>=100){
    $joinedremove="drop table $shopnamefortablejoined";
    $joinedremovevalue=$connect->select($connection,$joinedremove);
    $sqljoin = "CREATE TABLE IF NOT EXISTS $shopnamefortablejoined (
        phone varchar(100),
        distance VARCHAR(30) NOT NULL,
        id int auto_increment,primary key(id)
        )";
    $sqljoinvalue=$connect->select($connection,$sqljoin);
    

    $sortedremove="drop table $shopnamesorted";
    $sortedremovevalue=$connect->select($connection,$sortedremove);
    $sqlsorted = "CREATE TABLE IF NOT EXISTS $shopnamesorted (
        phone varchar(100),
        distance VARCHAR(30) NOT NULL,
        tokenno varchar(50)
        )";
    $sqlsortedvalue=$connect->select($connection,$sqlsorted);
    
}
$availabletoke=$shopdetails['availabletokens'];

if($availabletoke>0){
$sqlcountrows="select * from $shopnamefortablejoined";
$sqlcountrowsvalue=$connect->select($connection,$sqlcountrows);
$countofrowsinjoined=$connect->noofRows($sqlcountrowsvalue);
if($countofrowsinjoined>=0 and $countofrowsinjoined<100 ){
    $distance=$connect->DistAB($custlatitude,$custlongitude,$shoplatitude,$shoplongitude);
    $sqlinsertjoined="insert into $shopnamefortablejoined(phone,distance) values($custphone,$distance)";
    $sqlinsertjoinedvalue=$connect->select($connection,$sqlinsertjoined);
   
    $setactivecustomer="update user set isactive=1 where phone='$custphone'";
    $setactivecustomer=$connect->select($connection,$setactivecustomer);



    $countofrowsjoined="select * from $shopnamefortablejoined";
    $countofrowsselect=$connect->select($connection,$countofrowsjoined);
    $countofrowsjoinedvalue=$connect->noofRows($countofrowsselect);
   
    
    if(($countofrowsjoinedvalue)!=0 and ($countofrowsjoinedvalue) % 5 == 0){

        $sqlordered="(select * from $shopnamefortablejoined order by id desc limit 5)order by distance asc";
        $sqlorderedvalue=$connect->select($connection,$sqlordered);

        while($ordervalue=$connect->fetchData($sqlorderedvalue)){
            $sqlsortedcount="select * from $shopnamesorted";
            $sqlsortedcountvalue=$connect->select($connection,$sqlsortedcount);
            $countsortedvalue=$connect->noofRows($sqlsortedcountvalue);
           
            if($countsortedvalue==null)
            {
                
                $finalcount=0;
            }
            else{
                $finalcount=$countsortedvalue;
            }
            $finalcount=$finalcount+1;
            
            $updatephone=$ordervalue['phone'];
            
            $updatedistance=$ordervalue['distance'];
            $date = date('d-m-y h:i:s');
            $sqlsortedentry="insert into $shopnamesorted values($updatephone,$updatedistance,$finalcount)";
            $sqlsortedentryvalues=$connect->select($connection,$sqlsortedentry);
            $sqlsortedhistoryentry="insert into $shopnamesortedhistory values($updatephone,$updatedistance,$finalcount)";
            $sqlsortedhistoryentryvalue=$connect->select($connection,$sqlsortedhistoryentry);
            $customerhistory=$updatephone.'custhistory';
            $customersortedhistory=$updatephone.'sortedhistory';
            $sqlinserthistory="insert into $shopnamefortablehistory(phone,token,date) values($custphone,$finalcount,'$date')";
            $sqlinsertjoinedvalue=$connect->select($connection,$sqlinserthistory);
            $sqlcustomerhistory = "create table if not exists $customerhistory (phone varchar(100),shopnumber varchar(30),tokenno varchar(50),date varchar(250))";
            $sqlcustomerhistoryvalue=$connect->select($connection,$sqlcustomerhistory);
            $sqlcustomersortedhistory = "create table if not exists $customersortedhistory (phone varchar(100),shopnumber varchar(30),tokenno varchar(50))";
            $sqlcustomersortedhistory=$connect->select($connection,$sqlcustomersortedhistory);
            if($customersortedhistory==$updatephone.'sortedhistory'){
            $sqlcustomersortedhistoryentry="insert into $customersortedhistory values($updatephone,$shopnumber,$finalcount)";
            $sqlcustomersortedhistoryentryvalue=$connect->select($connection,$sqlcustomersortedhistoryentry);
           
            }
            if($customerhistory==$updatephone.'custhistory'){
                $sqlcustomerhistoryentry="insert into $customerhistory values($updatephone,$shopnumber,$finalcount,'$date')";
                $sqlcustomerhistoryentryvalue=$connect->select($connection,$sqlcustomerhistoryentry);
            }
            

        }
        $sqlgettokens="select availabletokens from shopdetails where phone='${shopnumber}'";
        $sqlgettokensvalue=$connect->select($connection,$sqlgettokens);
        $sqlavailabletokens=$connect->fetchData($sqlgettokensvalue);
        $availabletokenatshop=$sqlavailabletokens['availabletokens'];
        $sqlupdatetokens="update shopdetails set availabletokens=$availabletokenatshop-5 where phone='$shopnumber'";
        $sqlupdatetokensvalue=$connect->select($connection,$sqlupdatetokens);
        return 1;
           
    }
    return 0;
    
    

}
}
else{
    return -1;
}

}
public function exitqueue($custphonenumber,$shopphonenumber){
   
    $connect= new Functions();
$connection=$connect-> getConection();
$sql="select * from shopdetails where phone='${shopphonenumber}'";
$value=$connect->select($connection,$sql);
$shopdetails=$connect->fetchData($value);
$shopname=$shopdetails['shopname'];

    
    $shopnamefortablejoined=$shopname.'joined';
    $shopnamefortablehistory=$shopname.'history';
    $shopnamesorted=$shopname.'sorted';
    $shopnamesortedhistory=$shopname.'sortedhistory';
    $customerhistory=$custphonenumber.'custhistory';
    $customersortedhistory=$custphonenumber.'sortedhistory';
    $deleteshopnamesortedhistory="delete from $shopnamesortedhistory where phone='$custphonenumber'";
    $deleteshopnamesortedhistoryvalue=$connect->select($connection,$deleteshopnamesortedhistory);
    $deletecustomersorted="delete from $customersortedhistory where phone='$custphonenumber'";
    $deletecustomersortedvalue=$connect->select($connection,$deletecustomersorted);
    $sqlgettokens="select * from shopdetails where phone= '${shopphonenumber}'";
    $sqlgettokensvalue=$connect->select($connection,$sqlgettokens);
    $sqlavailabletokens=$connect->fetchData($sqlgettokensvalue);
    $availabletokenatshop=$sqlavailabletokens['availabletokens'];
    $sqltokenupdate="update shopdetails set availabletokens=$availabletokenatshop+1 where phone=$shopphonenumber";
    $sqltokenupdatevalue=$connect->select($connection,$sqltokenupdate);
$customerfullhistory=$custphonenumber.'fullhistory';

    $sqlsetactive="update $customerfullhistory set isactive=0 where phone=$custphonenumber";
    $sqlsetactivevalue=$connect->select($connection,$sqlsetactive);
    $setactivecustomer="update user set isactive=0 where phone='$custphonenumber'";
    $setactivecustomer=$connect->select($connection,$setactivecustomer);
    return 1;
    

}

public function exitqueuebefore($custphonenumber,$shopnumber){
    $connect= new Functions();
    $connection=$connect-> getConection();
    $sql="select * from shopdetails where phone='${shopnumber}'";
    $value=$connect->select($connection,$sql);
    $shopdetails=$connect->fetchData($value);
    $shopname=$shopdetails['shopname'];
 
    $shopnamefortablejoined=$shopname.'joined';
    $deleteshopnametablejoinedhistory="delete from $shopnamefortablejoined where phone='$custphonenumber'";
    $deleteshopnametablejoinedhistoryvalue=$connect->select($connection,$deleteshopnametablejoinedhistory);
    $customerfullhistory=$custphonenumber.'fullhistory';
    $setactivecustomer="update user set isactive=0 where phone='$custphonenumber'";
    $setactivecustomer=$connect->select($connection,$setactivecustomer);

    return 1;

    

    



}


}