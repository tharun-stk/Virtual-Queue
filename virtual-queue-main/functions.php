
<?php 
ini_set('memory_limit', '1024M');
session_start();
class Functions{
    public function getConection(){
        $conn = mysqli_connect("localhost", "root", "", "vq");
        if (!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }

    public function select($conn,$sql){
        $value = mysqli_query($conn, $sql);

        return $value;

    }

    public function serverreq(){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            return 1;
        }
    }

    public function noofRows($data){

        
        return $data->num_rows;
        }
    

    public function fetchData($result){
      $value=$result->fetch_assoc();
      return $value;
       }


        
    
    public function postof($value){
        if(isset($value)){
            return 1;
        }
    }

    public function redirect($rows,$page){
        if ($rows==1){
        header('Location: .$page');
        
        }
        else{
           return "Please enter valid phone number or password";
            
       }

    }
   



    public function DistAB($lat1,$lon1,$lat2,$lon2)

      {
        
         
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515*1.609344;
        

          
          return $miles;

      }

      public function Sort ($distanceresult){
          $count=0;
        sort($distanceresult);
        foreach($distanceresult as $item){
            if($item <= 100){
                $final[$count++]=$item;
            }
        }
        return $final;
      }
    
    
} 
