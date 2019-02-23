<!DOCTYPE html>
<html lang="en">
<head>
<title>criknow</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="login.css">
 
</head>
<body>
<?php
      session_start();
        if(isset($_POST['login'])){
        $url2 = 'https://criknowapp.herokuapp.com/login/';
        $options2 = array(
          'http' => array(
            'header'  => array(
                          'USERNAME: '.$_POST['username'],
                          'PASSWORD: '.$_POST['pwd'],
                        ),
            'method'  => 'GET',
          ),
        );
        $context2 = stream_context_create($options2);
        $output2 = file_get_contents($url2, false,$context2);
        /*echo $output2;*/
        $arr2 = json_decode($output2,true);

        if($arr2['status']==200){
          $_SESSION['login_mmi_dealer'] = 1;
          $_SESSION['admin_name'] = $arr2['admin_details']['name'];
          echo "<script>location='criknowadmin.php'</script>";
        }elseif($arr2['status']==400){
          echo "<script>alert('Invalid Credentials');</script>";
        }
        }
    ?>


<div class="container-fluid cf1">

    <div class="row">
      <div class="col-sm-4 c1">
       <img  src="criknow.jpeg" height="61px"></img>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          
          <form class="mainform" style="margin-top:50%;" method="post">
          <div style="padding-top: 45px;"></div>
            <p class="p1" style="font-size:15px;">Username</p>
          <input type="text" id="username" placeholder="Enter Username" name="username" style="font-size:15px;">

          <p class="p2" style="font-size:15px;">Password</p>
          <input type="password" id="pwd" placeholder="Enter Password" name="pwd" style="font-size:15px;">

          <button name="login" id="login" style="margin-top: 33px;width: 130px;margin-left: 30px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;">LOGIN<!-- <a href="./criknowadmin.php" style="color:white;">LOG IN</a> --></button>
           
         <!--  <a name="" type="button" href="forgot_password.php" class="fp" style="font-size: 12px;margin-left:28px;">FORGOT PASSWORD</a> -->
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>



 <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
</body>
</html>
