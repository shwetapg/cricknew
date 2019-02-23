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
<body style="background-color:#e4d9d966;">
<?php
    $url2 = 'https://criknowapp.herokuapp.com/get_video_list/';
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
    /*echo $arr2['dealers'][0]['dealer_details']['pk'];*/
?>
<?php
session_start();
    $url3 = 'https://criknowapp.herokuapp.com/get_category_videos/';
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
<div >
<div>
        <nav class="navbar navbar-inverse" style="background-color:lightgreen;border-color:lightgreen;">
          <?php session_start(); ?>
        <h5 class="welcome" style="color:white;text-align: right;margin-right: 193px;"><b>Welcome  <?php echo $_SESSION['admin_name']; ?>,</b></h5>
        <div style="text-align: right;margin-top: -28px;margin-right: 24px;"><a href="./criknowlog.php" style="color: red;"><b>LOGOUT</b></a></div>
    </nav>
    </div>

 <h4 style="text-align:center;"><b>VIDEOS</b></h4>

    <div>
          <button onclick="window.location.href='./criknowaddvideos.php'" type="button" class="btn btn-success" style="margin-left: 80%;width: 14%;">ADD VIDEO</button>
    </div>

<div style="margin-top:33px;margin-left: 75px;">
    <input type="text" class="for-control form-rounded search" name="srch-term" id='myInput' onkeyup='searchTable()' placeholder="Search" style="background: url(images/search-copy.png)no-repeat scroll 127px 7px;background-color:#fff;">

          <select class="form-control" id='filterText' onchange='filterText()' style="width:15%;margin-top: -30px;margin-left: 200px;">
                 <option>Filter by Category</option>
                </select>


          <select name="blang" id='filterText' onchange='filterText()' class="form-control" style="width:15%;margin-top: -34px;margin-left: 416px;">
            <option>Filter by topic</option>
            <option></option>
            <option></option>
            <option></option>
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
        <th>TITLE</th>
        <th>CATEGORY</th>
        <th>TOPIC</th>
        <th>MEDIA</th>
        <th>THUMBNAIL</th>
        <th>FEATURED</th>
        <th>EDIT</th>
      </tr>
    </thead>
    <tbody id='myTable'>
       <?php for($i=0;$i<count($arr2['video']);$i++){
        ?>
        <?php for($j=0;$j<count($arr2['video'][$i]['video_details']);$j++){
         $dateTime = new DateTime($arr2['video'][$i]['video_details'][$j]['created']);
          ?>
        <tr>
          <td style="white-space: nowrap;"><?php echo $dateTime->format('d-m-Y'); ?></td>
          <td style="white-space: nowrap;"><?php echo $dateTime->format('h:m:s'); ?></td>
          <td><?php echo $arr2['video'][$i]['video_details'][$j]['title']; ?></td>
          <td><?php echo $arr2['video'][$i]['video_details'][$j]['category']; ?></td>
          <td><?php echo $arr2['video'][$i]['video_details'][$j]['topic']; ?></td>
          <td><?php echo $arr2['video'][$i]['video_details'][$j]['link']; ?></td>
          <td style="width:95px;">
              <?php if($arr2['video'][$i]['video_details'][$j]['url'] == ""){ ?>
                <img style="max-width:55%;max-height:10%;" src="profile.png"></img><br>
                <?php }else{ ?>  
                <img style="max-width:55%;max-height:10%;" src="<?php echo $arr2['video'][$i]['video_details'][$j]['url']; ?>"></img>
              <?php } ?>
            </td> 
          <td><?php echo $arr2['video'][$i]['video_details'][$j]['featured']; ?></td>
           <td ><button type="button" class="btn btn-success">EDIT</button></td> 
        </tr>
       <?php } ?>
     <?php } ?>      
      </tbody> 
  </table>
  </div>

</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
function filterText()
  {  
    var rex = new RegExp($('#filterText').val());
    if(rex =="/all/"){clearFilter()}else{
      $('.content').hide();
      $('.content').filter(function() {
      return rex.test($(this).text());
      }).show();
  }
  }
  
function clearFilter()
  {
    $('.filterText').val('');
    $('.content').show();
  }
</script>

<script>
      $(document).ready(function(){
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    </script>
</body>
</html>