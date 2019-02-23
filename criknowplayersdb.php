<!DOCTYPE html>
<html lang="en">
<head>
<title>criknow</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="login.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body style="background-color:#e4d9d966;">

<?php
    $url2 = 'https://criknowapp.herokuapp.com/get_player_list/';
    $options2 = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',
      ),
    );
    $context2 = stream_context_create($options2);
    $output2 = file_get_contents($url2, false,$context2);
    /*echo $output2;*/
    $arr2 = json_decode($output2,true);
    // echo $arr2['news'][2]['news_details'][0]['created'];
    // echo $arr2['news'][1]['image_url']['url'];
?>

<?php
session_start();
    $url3 = 'https://criknowapp.herokuapp.com/get_category_news/';
    $options3 = array(
      'http' => array(
        'header'  => array(
                      'category: '.$_GET['category'],
                    ),
        'method'  => 'GET',
      ),
    );
    $context3 = stream_context_create($options3);
    $output3 = file_get_contents($url3, false,$context3);
 /*   echo $output3;*/
    $arr3 = json_decode($output3,true);
    /*echo $arr2['dealers'][0]['dealer_details']['pk'];*/
?>

<div>
<div>
        <nav class="navbar navbar-inverse" style="background-color:lightgreen;border-color:lightgreen;">
          <?php session_start(); ?>
        <h5 class="welcome" style="color:white;text-align: right;margin-right: 193px;"><b>Welcome  <?php echo $_SESSION['admin_name']; ?>,</b></h5>
        <div style="text-align: right;margin-top: -28px;margin-right: 24px;"><a href="./criknowlog.php" style="color: red;"><b>LOGOUT</b></a></div>
    </nav>
    </div>

 <h4 style="text-align:center;"><b>PLAYERS</b></h4>

    <div>
          <button onclick="window.location.href='./trialplayerdb.php'" type="button" class="btn btn-success" style="margin-left: 80%;width: 14%;">ADD PLAYER</button>
    </div>

<div style="margin-top:33px;margin-left: 75px;">
    <input type="text" class="for-control form-rounded search" name="srch-term" id='myInput' onkeyup='searchTable()' placeholder="Search" style="background: url(images/search-copy.png)no-repeat scroll 127px 7px;background-color:#fff;">

     <select name="blang" id="blang" class="form-control" style="width:15%;margin-top: -30px;
margin-left: 200px;">
            <option>Filter by Country</option>
            <option>Match Report</option>
            <option>Match Report</option>
            <option>Match Report</option>
          </select>

          <!-- <select class="form-control" style="width:15%;margin-top: -30px;margin-left: 200px;">
                 <?php for($x=0;$x<count($arr3['category_news']);$x++){ ?>
                  <option value="<?php echo $arr3['category_news'][$x]['category']; ?>"><?php echo $arr3['category_news'][$x]['category']; ?></option>
                 <?php } ?>
                </select>

 -->
          <select name="blang" id="blang" class="form-control" style="width:15%;margin-top: -34px;margin-left: 416px;">
            <option>Filter by Team</option>
            <option>Match Report</option>
            <option>Match Report</option>
            <option>Match Report</option>
          </select>

          <div style="margin-top:-27px;margin-left: 641px;">
          <label>From:</label>
    <input type="date" class="for-control form-rounded search" name="from-term" id="from-term"placeholder="DD/MM/YYYY" style="background: url(images/Forma-1.png)no-repeat scroll 118px 7px;background-color:#fff;margin-top: -34px;"></div>

    <div style="margin-top:-27px;margin-left: 841px;">
          <label>To:</label>
    <input type="date" class="for-control form-rounded search" name="from-term" id="from-term"placeholder="DD/MM/YYYY" style="background: url(images/Forma-1.png)no-repeat scroll 118px 7px;background-color:#fff;margin-top: -34px;"></div>
 <div>

  </div><br><br><br><br>
  <div class="card" style="width: 1141px;overflow-x:hidden;">
  <table class="table table-striped table-bordered" style="box-shadow: 0 0px 0px rgba(0,0,0,0.16), 0 1px 1px rgba(0,0,0,0.23);background-color: white;width:100%;">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TIME</th>
        <th>NAME</th>
        <th>ROLE</th>
        <th>COUNTRY</th>
        <th>TEAMS</th>
        <th>EDIT</th>
      </tr>
    </thead>
    
	<tbody id='myTable'>
	     <?php for($i=0;$i<count($arr2['player']);$i++){
	     	?>
	     	<?php for($j=0;$j<count($arr2['player'][$i]['player_details']);$j++){
	     	 $dateTime = new DateTime($arr2['player'][$i]['player_details'][$j]['created']);
	      	?>
	      <tr>
	        <td style="white-space: nowrap;"><?php echo $dateTime->format('d-m-Y'); ?></td>
	        <td style="white-space: nowrap;"><?php echo $dateTime->format('h:m:s'); ?></td>
	        <td><?php echo $arr2['player'][$i]['player_details'][$j]['name']; ?></td>
	        <td><?php echo $arr2['player'][$i]['player_details'][$j]['role']; ?></td>
	        <td><?php echo $arr2['player'][$i]['player_details'][$j]['country']; ?></td>
	        <td><?php echo $arr2['player'][$i]['player_details'][$j]['pteam']; ?></td>
	         <td ><button type="button" class="btn btn-success">EDIT</button></td> 
	      </tr>
	     <?php } ?>
		 <?php } ?>	     
	    </tbody> 
  </table>
  </div>

</div>
</div>

</body>
</html>