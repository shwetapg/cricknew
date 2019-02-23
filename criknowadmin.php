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
<div>
        <nav class="navbar navbar-inverse" style="background-color:lightgreen;border-color:lightgreen;">
          <?php session_start(); ?>
          <!--  <img src="criknow.jpeg" height="40px" style="margin-bottom: -3%;margin-left: 2%;"></img> -->
        <h5 class="welcome" style="color:white;text-align: right;margin-right: 193px;font-size: 18px;margin-top: 1%;"><b>Welcome    <?php echo $_SESSION['admin_name']; ?>,</b></h5>
        <div style="text-align: right;margin-top: -28px;margin-right: 24px;"><a href="./criknowlog.php" style="color: red;"><b>LOGOUT</b></a></div>
    </nav>
    </div>

<!-- <button name="login" type="sumbit" class="btn btn-success form-control" style="margin-top:13px;width: 112px;margin-left:32px;margin-bottom:10px;"><a href="criknownews.php"></a>LOGIN</button> -->
<div style="margin-left: 200px;margin-top: 111px;">
<div style="margin-top: 33px;width: 180px;margin-left: 90px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;"><a href="./criknownews.php" style="color:white;">NEWS</a></div>
<div style="margin-top: -50px;width: 180px;margin-left: 304px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;"><a href="./criknowvideos.php" style="color:white;">VIDEOS</a></div>
<div style="margin-top: -50px;width: 180px;margin-left: 515px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;"><a href="#" style="color:white;">MATCHES</a></div>
<div style="width: 180px;margin-left: 90px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;"><a href="#" style="color:white;">TEAMS</a></div>
<div style="width: 180px;margin-left: 305px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;margin-top: -52px"><a href="#" style="color:white;">SERIES</a></div>
<div style="width: 180px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;margin-top: -51px;margin-left: 516px;"><a href="./criknowplayersdb.php" style="color:white;">PLAYERS DB</a></div>
<div style="width: 180px;margin-left: 90px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;"><a href="#" style="color:white;">LIVE MATCHES</a></div>
<div style="width: 180px;margin-left: 305px;margin-bottom: 10px;background-color: lightgreen;height: 40px;padding: 12px 33px 29px 39px;margin-top: -52px"><a href="#" style="color:white;">SCHEDULE</a></div>
</div>

</body>
</html>