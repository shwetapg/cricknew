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
<body>
<?php
    $url2 = 'https://criknowapp.herokuapp.com/get_news_categories/';
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
    $url2 = 'https://criknowapp.herokuapp.com/get_news_topics/';
    $options2 = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',
      ),
    );
    $context2 = stream_context_create($options2);
    $output2 = file_get_contents($url2, false,$context2);
    /*echo $output2;*/
    $arr3 = json_decode($output2,true);
    /*echo $arr2['dealers'][0]['dealer_details']['pk'];*/
?>
<?php  
    session_start();
    if(isset($_POST['submit']))
    {
      
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $names=array();
            $names[0]= $randomString.rand(0, 9999).".jpg";
            // $names[0]= "1234.jpg";


            $url = 'https://criknowapp.herokuapp.com/get_signed_url/';
            $data = array('image_list' => [$names[0]]);

            $options = array(
              'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'PUT',
                'content' => json_encode($data),
              ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $arr = json_decode($result,true);

            
            $type=["logo"];

            $a=0;
            
            
              
              if ($_FILES[$type[0]]['size'] != 0)
              {
                $url_upload = $arr[0]['url'];
                $filename = $_FILES[$type[0]]["tmp_name"];
                $file = fopen($filename, "rb");
                $data = fread($file, filesize($filename));

                $options_upload = array(
                  'http' => array(
                    'header'  => "Content-type: \r\n",
                    'method'  => 'PUT',
                    'content' => $data,
                  ),
                );
                $context_upload  = stream_context_create($options_upload);
                $result_upload = file_get_contents($url_upload, false, $context_upload);
                $arr_upload = json_decode($result_upload,true);
                

                $url_update_doc_tab = 'https://criknowapp.herokuapp.com/upload_image/';
                $data_update_doc_tab = array('name' => $names[0],'link' => $arr[0]['url']);

                $options_update_doc_tab = array(
                  'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data_update_doc_tab),
                  ),
                );
                $context_update_doc_tab  = stream_context_create($options_update_doc_tab);
                $result_update_doc_tab = file_get_contents($url_update_doc_tab, false, $context_update_doc_tab);
                $arr_update_doc_tab = json_decode($result_update_doc_tab,true);
                // print_r($arr_update_doc_tab);
                if($arr_update_doc_tab['pk'] == null){
                  $var1=0;
                }else{
                  $var1=$arr_update_doc_tab['pk'];
                }
                array_push($a,$var1);
              }else{
                array_push($a,0); 
              }



        $url = 'https://criknowapp.herokuapp.com/players/';
        $data = array(
                     'profile_id' => $arr_update_doc_tab['pk'],
                    'name' => $_POST['name'],
                    'dob' => $_POST['dob'],
                    'country' => $_POST['country'],
                    'birthplace'=>$_POST['birthplace'],
                    'height'=>$_POST['height'],
                    'role' => $_POST['role'],
                    'batting_style'=>$_POST['batting_style'],
                    'bowling_style'=>$_POST['bowling_style'],
                    'about' => $_POST['about'],
                    'url'=>"",   
                    'pteam'=>$_POST['pteam'],     
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);
          $va=$arr['pk'];
          print_r($va);
           print_r($arr);


          // test_ranking
        $url = 'https://criknowapp.herokuapp.com/test_ranking/';
        $data = array(
                     'pname'=> $va,
                     'bat'=>$_POST['bat1'],
                     'bowl'=> $_POST['bowl1'],
                     'allround'=> $_POST['allround1'],    
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);
          

           // odi_ranking
           $url = 'https://criknowapp.herokuapp.com/odi_ranking/';
        $data = array(
                     'pname'=> $va,
                     'bat'=>$_POST['bat2'],
                     'bowl'=> $_POST['bowl2'],
                     'allround'=> $_POST['allround2'],    
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);  


           // ttwenty_ranking
        $url = 'https://criknowapp.herokuapp.com/ttwenty_ranking/';
        $data = array(
                     'pname'=> $va,
                     'bat'=>$_POST['bat3'],
                     'bowl'=> $_POST['bowl3'],
                     'allround'=> $_POST['allround3'],    
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


           // batting_test
            $url = 'https://criknowapp.herokuapp.com/batting_test/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches1'],
                     'innings'=>$_POST['innings1'],
                    'runs'=>$_POST['runs1'],
                     'balls'=>$_POST['balls1'],
                     'highest'=>$_POST['highest1'],
                     'average'=>$_POST['average1'],
                     'sr'=>$_POST['sr1'],
                     'not_out'=>$_POST['not_out1'],
                     'fours'=>$_POST['fours1'],
                     'sixes'=>$_POST['sixes1'],
                     'ducks'=>$_POST['ducks1'],
                     'fiftys'=>$_POST['fiftys1'],
                     'hundreds'=>$_POST['hundreds1'],
                     'twohundreds'=>$_POST['twohundreds1'],
                     'threethundreds'=>$_POST['threethundreds1'],
                     'fourhundreds'=>$_POST['fourhundreds1'],    
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


            // batting_odi
            $url = 'https://criknowapp.herokuapp.com/batting_odi/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches2'],
                     'innings'=>$_POST['innings2'],
                    'runs'=>$_POST['runs2'],
                     'balls'=>$_POST['balls2'],
                     'highest'=>$_POST['highest2'],
                     'average'=>$_POST['average2'],
                     'sr'=>$_POST['sr2'],
                     'not_out'=>$_POST['not_out2'],
                     'fours'=>$_POST['fours2'],
                     'sixes'=>$_POST['sixes2'],
                     'ducks'=>$_POST['ducks2'],
                     'fiftys'=>$_POST['fiftys2'],
                     'hundreds'=>$_POST['hundreds2'],
                     'twohundreds'=>$_POST['twohundreds2'],
                     'threethundreds'=>$_POST['threethundreds2'],
                     'fourhundreds'=>$_POST['fourhundreds2'],     
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


            // batting_ipl
            $url = 'https://criknowapp.herokuapp.com/batting_ipl/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches3'],
                     'innings'=>$_POST['innings3'],
                    'runs'=>$_POST['runs3'],
                     'balls'=>$_POST['balls3'],
                     'highest'=>$_POST['highest3'],
                     'average'=>$_POST['average3'],
                     'sr'=>$_POST['sr3'],
                     'not_out'=>$_POST['not_out3'],
                     'fours'=>$_POST['fours3'],
                     'sixes'=>$_POST['sixes3'],
                     'ducks'=>$_POST['ducks3'],
                     'fiftys'=>$_POST['fiftys3'],
                     'hundreds'=>$_POST['hundreds3'],
                     'twohundreds'=>$_POST['twohundreds3'],
                     'threethundreds'=>$_POST['threethundreds3'],
                     'fourhundreds'=>$_POST['fourhundreds3'],    
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           // print_r($arr);


            // batting_t20
            $url = 'https://criknowapp.herokuapp.com/batting_ttwenty/';
        $data = array(
                    'pname'=> $va,
                     'matches'=>$_POST['matches4'],
                     'innings'=>$_POST['innings4'],
                    'runs'=>$_POST['runs4'],
                     'balls'=>$_POST['balls4'],
                     'highest'=>$_POST['highest4'],
                     'average'=>$_POST['average4'],
                     'sr'=>$_POST['sr4'],
                     'not_out'=>$_POST['not_out4'],
                     'fours'=>$_POST['fours4'],
                     'sixes'=>$_POST['sixes4'],
                     'ducks'=>$_POST['ducks4'],
                     'fiftys'=>$_POST['fiftys4'],
                     'hundreds'=>$_POST['hundreds4'],
                     'twohundreds'=>$_POST['twohundreds4'],
                     'threethundreds'=>$_POST['threethundreds4'],
                     'fourhundreds'=>$_POST['fourhundreds4'],     
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);




             // bowling_test
            $url = 'https://criknowapp.herokuapp.com/bowling_test/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches01'],
                     'innings'=>$_POST['innings01'],
                    'runs'=>$_POST['runs01'],
                     'balls'=>$_POST['balls01'],
                     'maidens'=>$_POST['maidens01'],
                     'average'=>$_POST['average01'],
                     'wickets'=>$_POST['wickets01'],
                     'eco'=>$_POST['eco01'],
                     'sr'=>$_POST['sr01'],
                     'bbi'=>$_POST['bbi01'],
                     'bbm'=>$_POST['bbm01'],
                     'four_w'=>$_POST['four_w01'],
                     'five_w'=>$_POST['five_w01'],
                     'ten_w'=>$_POST['ten_w01'],   
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


            // bowling_odi
            $url = 'https://criknowapp.herokuapp.com/bowling_odi/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches02'],
                     'innings'=>$_POST['innings02'],
                    'runs'=>$_POST['runs02'],
                     'balls'=>$_POST['balls02'],
                     'maidens'=>$_POST['maidens02'],
                     'average'=>$_POST['average02'],
                     'wickets'=>$_POST['wickets02'],
                     'eco'=>$_POST['eco02'],
                     'sr'=>$_POST['sr02'],
                     'bbi'=>$_POST['bbi02'],
                     'bbm'=>$_POST['bbm02'],
                     'four_w'=>$_POST['four_w02'],
                     'five_w'=>$_POST['five_w02'],
                     'ten_w'=>$_POST['ten_w02'],      
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


            // bowling_ipl
            $url = 'https://criknowapp.herokuapp.com/bowling_ipl/';
        $data = array(
                     'pname'=> $va,
                     'matches'=>$_POST['matches03'],
                     'innings'=>$_POST['innings03'],
                    'runs'=>$_POST['runs03'],
                     'balls'=>$_POST['balls03'],
                     'maidens'=>$_POST['maidens03'],
                     'average'=>$_POST['average03'],
                     'wickets'=>$_POST['wickets03'],
                     'eco'=>$_POST['eco03'],
                     'sr'=>$_POST['sr03'],
                     'bbi'=>$_POST['bbi03'],
                     'bbm'=>$_POST['bbm03'],
                     'four_w'=>$_POST['four_w03'],
                     'five_w'=>$_POST['five_w03'],
                     'ten_w'=>$_POST['ten_w03'],     
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);


            // bowling_t20
            $url = 'https://criknowapp.herokuapp.com/bowling_ttwenty/';
        $data = array(
                    'pname'=> $va,
                     'matches'=>$_POST['matches04'],
                     'innings'=>$_POST['innings04'],
                    'runs'=>$_POST['runs04'],
                     'balls'=>$_POST['balls04'],
                     'maidens'=>$_POST['maidens04'],
                     'average'=>$_POST['average04'],
                     'wickets'=>$_POST['wickets04'],
                     'eco'=>$_POST['eco04'],
                     'sr'=>$_POST['sr04'],
                     'bbi'=>$_POST['bbi04'],
                     'bbm'=>$_POST['bbm04'],
                     'four_w'=>$_POST['four_w04'],
                     'five_w'=>$_POST['five_w04'],
                     'ten_w'=>$_POST['ten_w04'],      
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
           print_r($arr);







    }
  ?>
<!-- <script>
$(function(){
   $("#buttoncheck").click(function(){
        if($('[type="checkbox"]').is(":checked")){
            $('.checkboxStatus').html("Yes");
        }else{
            $('.checkboxStatus').html("NO");
         }
         return false;
   })
    
});
</script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('#myImg').attr('src', e.target.result);
};
</script>

<div>
        <nav class="navbar navbar-inverse" style="background-color:#163739;border-color:#163739;;">
          <?php session_start(); ?>
        <h5 class="welcome" style="color:white;text-align: right;margin-right: 193px;"><b>Welcome   <?php echo $_SESSION['admin_name']; ?>,</b></h5>
        <div style="text-align: right;margin-top: -28px;margin-right: 24px;"><a href="./criknowlog.php" style="color: red;"><b>LOGOUT</b></a></div>
    </nav>
    
    <h4 style="text-align:center;"><b>Players</b></h4><br/><br/>
    <form enctype="multipart/form-data" action="./trialplayerdb.php" name="Form" method="post" style="" id"myForm">
         <div>
        
          <!-- <label for="profile_id" style="margin-left:30%;">profile_id:</label>
          <input type="file" name="logo" id="profile_id"  class="form-control" style="height:125px;width:25%;margin-left:37%;margin-top:-2%;">

          <label for="name" style="margin-left:30%;">name:</label>
          <input  name="name" id="name"  class="form-control" style="height:125px;width:25%;margin-left:37%;margin-top:-2%;">

          <label for="dob" style="margin-left:30%;">dob:</label>
          <input  type="date" name="dob" id="dob"  class="form-control" style="height:125px;width:25%;margin-left:37%;margin-top:-2%;">
         
           <label for="country" style="margin-left:30%;">Country</label>
                <select name="country" id="country" class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;">
                 <option>India</option>
                </select><br/>

                <label for="birthplace" style="margin-left:30%;">birthplace:</label>
          <input  name="birthplace" id="birthplace"  class="form-control" style="height:125px;width:25%;margin-left:37%;margin-top:-2%;">

          <label for="height" style="margin-left:30%;">height:</label>
          <input  name="height" id="height"  class="form-control" style="height:125px;width:25%;margin-left:37%;margin-top:-2%;">

        
          <label for="role" style="margin-left:30%;">role</label>
                <select name="role" id="role" class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;">
                 <option>Batsman</option>
                </select><br/>

                <label for="batting_style" style="margin-left:30%;">batting style</label>
                <select name="batting_style" id="batting_style" class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;">
                 <option>Right hand batsman</option>
                </select><br/>

                <label for="bowling_style" style="margin-left:30%;">bowling style</label>
                <select name="bowling_style" id="bowling_style" class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;">
                 <option>Right hand bowler</option>
                </select><br/>

                <label for="about" style="margin-left:30%;">About:</label>
          <input type="text" name="about" id="about"  class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;"><br/>

           <label for="pteam" style="margin-left:30%;">pteam:</label>
          <input type="text" name="pteam" id="pteam"  class="form-control" style="margin-left:37%;margin-top:-2%;width:25%;"><br/>
 -->

  <div style="margin-left: 23%;"><b>Personal Info</b></div>
          <label for="name" style="margin-left:380px;margin-top:22px;">Title:</label>
          <input name="name" id="name" placeholder="Enter Full Name" class="form-control" style="width:25%;margin-left:38%;margin-top:-2%;"><br/>

          <div style="width: 155px;margin-left: 80%;margin-top: -50px;">
          <label>Pic</label>
          <img id="myImg" src="profile.png"  width="100" height="100" style="margin-left:10px;"/>
          <input type="file" name="logo" style="margin-left: 45px;margin-top: 20px;">
          </div>

          <div style="margin-top: -100px;">
          <label for="country" style="margin-left:380px;">Country:</label>
            <input name="country" id="country" placeholder="Enter Country Name" class="form-control" style="width:25%;margin-left:38%;margin-top:-2%;"><br/>
            </div><br/>

            <div style="margin-top:-15px;">
              <label for="dob" style="margin-left:380px;">Birth Date:</label>
              <input type="date" name="dob" id="dob" class="for-control" placeholder="DD/MM/YYYY" style="width:25%;margin-left:35px;margin-top:-2%;">
            </div><br/>

            <label for="birthplace" style="margin-left:380px;">Birth Place:</label>
          <input name="birthplace" id="birthplace" placeholder="Enter Birth Place" class="form-control" style="width:25%;margin-left:38%;margin-top:-2%;"><br/>

          <label for="height" style="margin-left:380px;">Height:</label>
          <input name="height" id="height" placeholder="Enter Birth Height" class="form-control" style="width:25%;margin-left:38%;margin-top:-2%;"><br/>

          <label for="role" style="margin-left:380px;">Role:</label>
                <select name="role" id="role" class="form-control" style="margin-left:38%;margin-top:-2%;width:25%;">
                 <option>Select Role</option>
                 <option>Batsman</option>
                 <option>Bowler</option>
                 <option>Fielder</option>
                 <option>Wicket-keeper</option>
                </select><br/>

                <div style="margin-left: 65%;margin-top: -55px;">
                  <button>Add New Role</button>
                </div>

                <div style="margin-top:2%">
                 <label for="batting_style" style="margin-left:380px;">Batting Style:</label>
                <select name="batting_style" id="batting_style" class="form-control" style="margin-left:38%;margin-top:-2%;width:25%;">
                 <option>Select Batting Style</option>
                 <option>Right Handed</option>
                 <option>Left Handed</option>
                </select>
                </div><br/>

                <div style="margin-left: 65%;margin-top: -55px;">
                <button>Add New Style</button>
                </div>

                <div style="margin-top:2%">
                 <label for="bowling_style" style="margin-left:29%;">Bowling Style:</label>
                <select name="bowling_style" id="bowling_style" class="form-control" style="margin-left:38%;margin-top:-2%;width:25%;">
                 <option>Select Bowling Style</option>
                 <option>Right-arm fast</option>
                  <option>Right-arm fast medium </option>
                   <option>Right-arm medium fast </option>
                    <option>Right-arm medium </option>
                     <option>Left-arm fast </option>
                      <option>Left-arm fast medium </option>
                       <option>Left-arm medium fast </option>
                       <option>Left-arm medium </option>
                       <option>Off break (right-arm) </option>
                       <option>Leg break (right-arm) </option>
                       <option>Slow left-arm orthodox</option>
                       <option>Slow left-arm chinaman</option>
                </select>
                </div><br/>

                <div style="margin-left: 65%;margin-top: -55px;">
                <button>Add New Style</button>
                </div>

                <div style="margin-top:2%">
                <label for="pteam" style="margin-left:380px;">Teams:</label>
          <textarea name="pteam" id="pteam" placeholder="Enter Teams" class="form-control" style="height:125px;width:25%;margin-left:38%;margin-top:-2%;"></textarea>
          </div><br/>

          <label for="about" style="margin-left:380px;">About:</label>
          <textarea name="about" id="about" placeholder="Enter Player Info" class="form-control" style="height:125px;width:25%;margin-left:38%;margin-top:-2%;"></textarea><br/>

            <div class="row">
    <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <div style="margin-left:-140px"><b>ICC Ranking</b></div>
          <div class="row">
            <div class="col-sm-4">
            <!-- ranking_test -->
             <div style="margin-left: 52px;"><b>TEST</b></div>
                <div style="margin-left: -50px;margin-top: 14px;"><b>Batting:</b></div>
                 <div style="margin-left: -56px;margin-top: 24px;"><b>Bowling:</b></div>
                 <div style="margin-left: -80px;margin-top: 24px;"><b>All Rounder:</b></div>

                  <div style="margin-top: -110px;margin-left: 75px;">
                    <div style="margin-left:-97%;">
                      <input type="text" name="bat1" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: 240%;margin-top: -32px;">
                      <input type="text" name="bat2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:-32px;">
                      <input type="text" name="bat3" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
               
               <!-- ranking_odi -->
            <div class="col-sm-4">
             <div style="margin-left: 52px;"><b>ODI</b></div>

                <div style="margin-top:55px;">
                  <div style="margin-left:-113px;">
                    <input type="text" name="bowl1" class="form-control-inline" style="width: 80px;">
                  </div>
                  <div style="margin-left:25%;margin-top:-27%;">
                   <input type="text" name="bowl2"  class="form-control-inline" style="width: 80px;">
                  </div>
                  <div style="margin-left:150%;margin-top:-27%;">
                    <input type="text" name="bowl3" class="form-control-inline" style="width: 80px;">
                  </div>
                </div>
            </div>

            <!-- ranking_t20 -->
             <div class="col-sm-4">
              <div style="margin-left: 52px;"><b>T20</b></div>
                <div style="margin-top:100px;">
                  <div style="margin-left:-260px;">
                    <input type="text" name="allround1" class="form-control-inline" style="width: 80px;">
                  </div>
                  <div style="margin-left: -100%;margin-top:-28%;">
                   <input type="text" name="allround2" class="form-control-inline" style="width: 80px;">
                  </div>
                  <div style="margin-left: 26%;margin-top:-28%;">
                    <input type="text" name="allround3" class="form-control-inline" style="width: 80px;">
                  </div>
                </div>
              </div> <!--col-sm-4-->
              </div><!--row-->
            </div><!--main col-sm-4-->
            <div class="col-sm-4"></div>
          </div>


<!-- batting_test -->
  <div class="row">
    <div class="col-sm-3"></div>
      <div class="col-sm-3">
        <div style="margin-left: -30px;margin-top: 35px;"><b>Batting Career</b></div>
          <div class="row">
            <div class="col-sm-3">
             <div style="margin-left: 162px;"><b>TEST</b></div>
                <div style="margin-left: 53px;margin-top: 14px;"><b>Matches:</b></div>
                 <div style="margin-left: 59px;margin-top: 24px;"><b>Innings:</b></div>
                 <div style="margin-left: 74px;margin-top: 24px;"><b>Runs:</b></div>
                 <div style="margin-left: 77px;margin-top: 24px;"><b>Balls:</b></div>
                 <div style="margin-left: 58px;margin-top: 24px;"><b>Highest:</b></div>
                 <div style="margin-left: 55px;margin-top: 24px;"><b>Average:</b></div>
                 <div style="margin-left: 92px;margin-top: 24px;"><b>SR:</b></div>
                 <div style="margin-left: 62px;margin-top: 24px;"><b>NotOut:</b></div>
                 <div style="margin-left: 71px;margin-top: 24px;"><b>Fours:</b></div>
                 <div style="margin-left: 74px;margin-top: 24px;"><b>Sixes:</b></div>
                 <div style="margin-left: 67px;margin-top: 24px;"><b>Ducks:</b></div>
                  <div style="margin-left: 83px;margin-top: 24px;"><b>50's:</b></div>
                   <div style="margin-left: 74px;margin-top: 24px;"><b>100's:</b></div>
                    <div style="margin-left: 74px;margin-top: 24px;"><b>200's:</b></div>
                     <div style="margin-left: 75px;margin-top: 24px;"><b>300's:</b></div>
                      <div style="margin-left: 74px;margin-top: 24px;"><b>400's:</b></div>

                  <div style="margin-top: -695px;margin-left: 145px;">
                    <div style="margin-left:-97%;">
                      <input type="text" name="matches1" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: 240%;margin-top:14px;">
                     <input type="text" name="innings1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="runs1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="balls1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="highest1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="average1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="sr1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="not_out1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fours1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="sixes1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="ducks1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fiftys1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="hundreds1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="twohundreds1" name="matches1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="threehundreds1" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="fourhundreds1" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
               

               <!-- batting_odi -->
            <div class="col-sm-3">
             <div style="margin-left: 227px;"><b>ODI</b></div>

                <div style="margin-top: 6px;margin-left: 205px;">
                    <div style="margin-left:-97%;">
                      <input type="text" name="matches2" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: 240%;margin-top:14px;">
                     <input type="text" name="innings2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="runs2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="balls2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="highest2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="average2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="sr2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="not_out2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fours2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="sixes2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="ducks2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fiftys2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="hundreds2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="twohundreds2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="threethundreds2" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="fourhundreds2" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
            </div>

            <!-- batting_t20 -->
             <div class="col-sm-3">
              <div style="margin-left: 441px;margin-top: -725px;"><b>T20</b></div>
                 <div style="margin-top: 7px;margin-left:420px;">
                    <div style="margin-left:-97%;">
                      <input type="text" name="matches3" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: 240%;margin-top:14px;">
                     <input type="text" name="innings3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="runs3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="balls3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="highest3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="average3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="sr3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="not_out3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fours3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="sixes3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="ducks3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="fiftys3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="hundreds3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="twohundreds3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:14px;">
                      <input type="text" name="threethundreds3" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: 590%;margin-top:10px;">
                      <input type="text" name="fourhundreds3" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
              </div> <!--col-sm-3-->


              <!-- batting_ipl -->
               <div class="col-sm-3">
              <div style="margin-left: 270px;margin-top:55px"><b>IPL</b></div>
                <div style="margin-top: 7px;margin-left:275px;">
                    <div style="margin-left:-97%;">
                      <input type="text" name="matches4" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: -100%;margin-top:14px;">
                     <input type="text" name="innings4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="runs4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="balls4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="highest4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="average4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left:-100%;margin-top:14px;">
                      <input type="text" name="sr4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="not_out4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="fours4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="sixes4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="ducks4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="fiftys4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="hundreds4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="twohundreds4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:14px;">
                      <input type="text" name="threethundreds4" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -100%;margin-top:10px;">
                      <input type="text" name="fourhundreds4" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
              </div> <!--col-sm-3-->
              </div><!--row-->
            </div><!--main col-sm-3-->
            <div class="col-sm-3"></div>
          </div>



          <!-- bowling_test -->
           <div class="row">
    <div class="col-sm-3"></div>
      <div class="col-sm-3">
        <div style="margin-left: -365px;margin-top: 35px;"><b>Bowling Status</b></div>
          <div class="row">
            <div class="col-sm-3">
             <div style="margin-left: -170px;"><b>TEST</b></div>
                <div style="margin-left: -545%;margin-top: 14px;"><b>Matches:</b></div>
                 <div style="margin-left: -535%;margin-top: 24px;"><b>Innings:</b></div>
                 <div style="margin-left: -502%;margin-top: 24px;"><b>Runs:</b></div>
                 <div style="margin-left: -500%;margin-top: 24px;"><b>Balls:</b></div>
                 <div style="margin-left: -545%;margin-top: 24px;"><b>Maidens:</b></div>
                 <div style="margin-left: -522%;margin-top: 24px;"><b>Wicket:</b></div>
                 <div style="margin-left: -540%;margin-top: 24px;"><b>Average:</b></div>
                 <div style="margin-left: -493%;margin-top: 24px;"><b>Eco:</b></div>
                 <div style="margin-left: -483%;margin-top: 24px;"><b>SR:</b></div>
                 <div style="margin-left: -493%;margin-top: 24px;"><b>BBI:</b></div>
                 <div style="margin-left: -508%;margin-top: 24px;"><b>BBM:</b></div>
                  <div style="margin-left: -490%;margin-top: 24px;"><b>4W:</b></div>
                   <div style="margin-left: -490%;margin-top: 24px;"><b>5W:</b></div>
                    <div style="margin-left: -505%;margin-top: 24px;"><b>10W:</b></div>

                  <div style="margin-top: -603px;margin-left: -114px;">
                    <div style="margin-left:-48%;">
                      <input type="text" name="matches01" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: -48%;margin-top:14px;">
                     <input type="text" name="innings01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="runs01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="balls01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="maidens01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="average01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="wickets01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="eco01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="sr01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="bbi01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="bbm01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="four_w01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="five_w01" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="ten_w01" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>
               

               <!-- bowling_odi -->
            <div class="col-sm-3">
             <div style="margin-left: -110px;"><b>ODI</b></div>

               <div style="margin-top: -603px;margin-left: -73px;">
                    <div style="margin-left:-48%;margin-top: 613px;">
                      <input type="text" name="matches02" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: -48%;margin-top:14px;">
                     <input type="text" name="innings02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="runs02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="balls02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="maidens02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="average02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="wickets02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="eco02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="sr02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="bbi02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="bbm02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="four_w02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="five_w02" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="ten_w02" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
            </div>


            <!-- bowling_t20 -->
             <div class="col-sm-3">
              <div style="margin-left: -45px;"><b>T20</b></div>
                <div style="margin-top: -603px;margin-left: -28px;">
                    <div style="margin-left:-48%;margin-top: 613px;">
                      <input type="text" name="matches03" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: -48%;margin-top:14px;">
                     <input type="text" name="innings03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="runs03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="balls03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="maidens03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="average03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="wickets03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="eco03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="sr03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="bbi03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="bbm03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="four_w03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="five_w03" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="ten_w03" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
              </div> <!--col-sm-3-->


              <!-- bowling_ipl -->
               <div class="col-sm-3">
              <div style="margin-left: 25px;"><b>IPL</b></div>
                <div style="margin-top: -603px;margin-left: 15px;">
                    <div style="margin-left:-48%;margin-top: 613px;">
                      <input type="text" name="matches04" class="form-control-inline" style="width: 80px;">
                    </div>
                    <div style="margin-left: -48%;margin-top:14px;">
                     <input type="text" name="innings04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="runs04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="balls04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="maidens04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="average04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="wickets04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="eco04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="sr04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="bbi04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="bbm04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="four_w04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:14px;">
                      <input type="text" name="five_w04" class="form-control-inline" style="width: 80px;">
                     </div>
                     <div style="margin-left: -48%;margin-top:10px;">
                      <input type="text" name="ten_w04" class="form-control-inline" style="width: 80px;">
                     </div>
                  </div>
              </div> <!--col-sm-3-->
              </div><!--row-->
            </div><!--main col-sm-3-->
            <div class="col-sm-3"></div>
          </div>



          

           <button type="submit" id="buttoncheck" name="submit" style="margin-left:36%;background-color:lightgreen;">PUBLISH Player</button>
           <button style="margin-left:10%;background-color:red;">CANCEL</button>

         <!--  <button type="submit" name="send_message" id="send_message"  class="btn send_msg" style="">SEND MESSAGE</button> -->
       <!--  <script>
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
        </script> -->
        </div>

    </div>
    </form>
    <script>
          function validateForm()
          {
            var a=document.forms["Form"]["name"].value;
            var b=document.forms["Form"]["logo"].value;
            var c=document.forms["Form"]["dob"].value;
            var d=document.forms["Form"]["birthplace"].value;
            var e=document.forms["Form"]["country"].value;
            var f=document.forms["Form"]["height"].value;
            var g=document.forms["Form"]["role"].value;
            var h=document.forms["Form"]["batting_style"].value;
            var i=document.forms["Form"]["bowling_style"].value;
            var j=document.forms["Form"]["pteam"].value;
            var k=document.forms["Form"]["about"].value;

            var l=document.forms["Form"]["bat1"].value;
             var m=document.forms["Form"]["bat2"].value;
              var n=document.forms["Form"]["bat3"].value;
               var o=document.forms["Form"]["ball1"].value;
               var p=document.forms["Form"]["ball2"].value;
             var q=document.forms["Form"]["ball3"].value;
              var r=document.forms["Form"]["allround1"].value;
               var s=document.forms["Form"]["allround2"].value;
               var t=document.forms["Form"]["allround3"].value;

             var u=document.forms["Form"]["matches1"].value;
              var v=document.forms["Form"]["matches2"].value;
               var w=document.forms["Form"]["matches3"].value;
               var x=document.forms["Form"]["matches4"].value;

             var y=document.forms["Form"]["innings1"].value;
              var z=document.forms["Form"]["innings2"].value;
               var a1=document.forms["Form"]["innings3"].value;
               var a2=document.forms["Form"]["innings4"].value;

                var a3=document.forms["Form"]["runs1"].value;
              var a4=document.forms["Form"]["runs2"].value;
               var a5=document.forms["Form"]["runs3"].value;
               var a6=document.forms["Form"]["runs4"].value;

                var a7=document.forms["Form"]["balls1"].value;
              var a8=document.forms["Form"]["balls2"].value;
               var a9=document.forms["Form"]["balls3"].value;
               var a10=document.forms["Form"]["balls4"].value;

                var a11=document.forms["Form"]["highest1"].value;
              var a12=document.forms["Form"]["highest2"].value;
               var a13=document.forms["Form"]["highest3"].value;
               var a14=document.forms["Form"]["highest4"].value;

                var a15=document.forms["Form"]["average1"].value;
              var a16=document.forms["Form"]["average2"].value;
               var a17=document.forms["Form"]["average3"].value;
               var a18=document.forms["Form"]["average4"].value;

                var a19=document.forms["Form"]["not_out1"].value;
              var a20=document.forms["Form"]["not_out2"].value;
               var a21=document.forms["Form"]["not_out3"].value;
               var a22=document.forms["Form"]["not_out4"].value;

                var a23=document.forms["Form"]["sr1"].value;
              var a24=document.forms["Form"]["sr2"].value;
               var a25=document.forms["Form"]["sr3"].value;
               var a26=document.forms["Form"]["sr4"].value;

               var a27=document.forms["Form"]["fours1"].value;
              var a28=document.forms["Form"]["fours2"].value;
               var a29=document.forms["Form"]["fours3"].value;
               var a30=document.forms["Form"]["fours4"].value;

               var a31=document.forms["Form"]["sixes1"].value;
              var a32=document.forms["Form"]["sixes2"].value;
               var a33=document.forms["Form"]["sixes3"].value;
               var a34=document.forms["Form"]["sixes4"].value;

               var a35=document.forms["Form"]["ducks1"].value;
              var a36=document.forms["Form"]["ducks2"].value;
               var a37=document.forms["Form"]["ducks3"].value;
               var a38=document.forms["Form"]["ducks4"].value;

               var a39=document.forms["Form"]["fiftys1"].value;
              var a40=document.forms["Form"]["fiftys2"].value;
               var a41=document.forms["Form"]["fiftys3"].value;
               var a42=document.forms["Form"]["fiftys4"].value;

               var a43=document.forms["Form"]["hundreds1"].value;
              var a44=document.forms["Form"]["hundreds2"].value;
               var a45=document.forms["Form"]["hundreds3"].value;
               var a46=document.forms["Form"]["hundreds4"].value;

               var a47=document.forms["Form"]["twohundreds1"].value;
              var a48=document.forms["Form"]["twohundreds2"].value;
               var a49=document.forms["Form"]["twohundreds3"].value;
               var a50=document.forms["Form"]["twohundreds4"].value;

               var a51=document.forms["Form"]["threehundreds1"].value;
              var a52=document.forms["Form"]["threehundreds2"].value;
               var a53=document.forms["Form"]["threehundreds3"].value;
               var a54=document.forms["Form"]["threehundreds4"].value;

               var a55=document.forms["Form"]["fourhundreds1"].value;
              var a56=document.forms["Form"]["fourhundreds2"].value;
               var a57=document.forms["Form"]["fourhundreds3"].value;
               var a58=document.forms["Form"]["fourhundreds4"].value;

               // bowling_style

                var a59=document.forms["Form"]["matches01"].value;
              var a60=document.forms["Form"]["matches02"].value;
               var a61=document.forms["Form"]["matches03"].value;
               var a62=document.forms["Form"]["matches04"].value;

             var a63=document.forms["Form"]["innings01"].value;
              var a64=document.forms["Form"]["innings02"].value;
               var a65=document.forms["Form"]["innings03"].value;
               var a66=document.forms["Form"]["innings04"].value;

                var a67=document.forms["Form"]["runs01"].value;
              var a68=document.forms["Form"]["runs02"].value;
               var a69=document.forms["Form"]["runs03"].value;
               var a70=document.forms["Form"]["runs04"].value;

                var a71=document.forms["Form"]["balls01"].value;
              var a72=document.forms["Form"]["balls02"].value;
               var a73=document.forms["Form"]["balls03"].value;
               var a74=document.forms["Form"]["balls04"].value;

               var a75=document.forms["Form"]["average01"].value;
              var a76=document.forms["Form"]["average02"].value;
               var a77=document.forms["Form"]["average03"].value;
               var a78=document.forms["Form"]["average04"].value;

               var a79=document.forms["Form"]["maidens01"].value;
              var a80=document.forms["Form"]["maidens02"].value;
               var a81=document.forms["Form"]["maidens03"].value;
               var a82=document.forms["Form"]["maidens04"].value;

                var a83=document.forms["Form"]["wickets01"].value;
              var a84=document.forms["Form"]["wickets02"].value;
               var a85=document.forms["Form"]["wickets03"].value;
               var a86=document.forms["Form"]["wickets04"].value;

                var a87=document.forms["Form"]["eco01"].value;
              var a88=document.forms["Form"]["eco02"].value;
               var a89=document.forms["Form"]["eco03"].value;
               var a90=document.forms["Form"]["eco04"].value;

               var a91=document.forms["Form"]["sr01"].value;
              var a92=document.forms["Form"]["sr02"].value;
               var a93=document.forms["Form"]["sr03"].value;
               var a94=document.forms["Form"]["sr04"].value;

                 var a95=document.forms["Form"]["bbi01"].value;
              var a96=document.forms["Form"]["bbi02"].value;
               var a97=document.forms["Form"]["bbi03"].value;
               var a98=document.forms["Form"]["bbi04"].value;

                 var a99=document.forms["Form"]["bbm01"].value;
              var a100=document.forms["Form"]["bbm02"].value;
               var a101=document.forms["Form"]["bbm03"].value;
               var a102=document.forms["Form"]["bbm04"].value;

                 var a103=document.forms["Form"]["four_w01"].value;
              var a104=document.forms["Form"]["four_w02"].value;
               var a105=document.forms["Form"]["four_w03"].value;
               var a106=document.forms["Form"]["four_w04"].value;

                 var a107=document.forms["Form"]["five_w01"].value;
              var a108=document.forms["Form"]["five_w02"].value;
               var a109=document.forms["Form"]["five_w03"].value;
               var a110=document.forms["Form"]["five_w04"].value;

                 var a111=document.forms["Form"]["ten_w01"].value;
              var a112=document.forms["Form"]["ten_w02"].value;
               var a113=document.forms["Form"]["ten_w03"].value;
               var a114=document.forms["Form"]["ten_w04"].value;



            if(a==null || a=="", b==null ||b=="", c==null || c=="", d==null || d=="",e==null || e=="",f==null || f=="",g==null || g=="",h==null || h=="",i==null || i=="",j==null || j=="",k==null || k=="",  l==null || l=="", m==null ||m=="", n==null || n=="", o==null || o=="",p==null || p=="",q==null || q=="",r==null || r=="",s==null || s=="",t==null || t=="",u==null || u=="",v==null || v=="",w==null || w=="", x==null ||x=="", y==null || y=="", z==null || z=="",

              a1==null || a1=="",a2==null || a2=="",a3==null || a3=="",a4==null || a4=="",a5==null || a5=="",
              a6==null || a6=="",a7==null || a7=="",a8==null || a8=="",a9==null || a9=="",a10==null || a10=="",
   a11==null || a11=="",a12==null || a12=="",a13==null || a13=="",a14==null || a14=="",a15==null || a15=="",
              a16==null || a16=="",a17==null || a17=="",a18==null || a18=="",a19==null || a19=="",a20==null || a20=="",
   a21==null || a21=="",a22==null || a22=="",a23==null || a23=="",a24==null || a24=="",a25==null || a25=="",
              a26==null || a26=="",a27==null || a27=="",a28==null || a28=="",a29==null || a29=="",a30==null || a30=="",
 a31==null || a31=="",a32==null || a32=="",a33==null || a33=="",a34==null || a34=="",a35==null || a35=="",
              a36==null || a36=="",a37==null || a37=="",a38==null || a38=="",a39==null || a39=="",a40==null || a40=="",
   a41==null || a41=="",a42==null || a42=="",a43==null || a43=="",a44==null || a44=="",a45==null || a45=="",
              a46==null || a46=="",a47==null || a47=="",a48==null || a48=="",a49==null || a49=="",a50==null || a50=="",
   a51==null || a51=="",a52==null || a52=="",a53==null || a53=="",a54==null || a54=="",a55==null || a55=="",
              a56==null || a56=="",a57==null || a57=="",a58==null || a58=="",a59==null || a59=="",a60==null || a60=="",
 a61==null || a61=="",a62==null || a62=="",a63==null || a63=="",a64==null || a64=="",a65==null || a65=="",
              a66==null || a66=="",a67==null || a67=="",a68==null || a68=="",a69==null || a69=="",a70==null || a70=="",
   a71==null || a71=="",a72==null || a72=="",a73==null || a73=="",a74==null || a74=="",a75==null || a75=="",
              a76==null || a76=="",a77==null || a77=="",a78==null || a78=="",a79==null || a79=="",a80==null || a80=="",
   a81==null || a81=="",a82==null || a82=="",a83==null || a83=="",a84==null || a84=="",a85==null || a85=="",
              a86==null || a86=="",a87==null || a87=="",a88==null || a88=="",a89==null || a89=="",a90==null || a90=="",
a91==null || a91=="",a92==null || a92=="",a93==null || a93=="",a94==null || a94=="",a95==null || a95=="",
              a96==null || a96=="",a97==null || a97=="",a98==null || a98=="",a99==null || a99=="",a100==null || a100=="",a101==null || a101=="",a102==null || a102=="",a103==null || a103=="",a104==null || a104=="",a105==null || a105=="",a106==null || a106=="",a107==null || a107=="",a108==null || a108=="",a109==null || a109=="",a110==null || a110=="",a111==null || a111=="",a112==null || a112=="",a113==null || a113=="",a114==null || a114=="",


              )
            {
              alert("Please Fill All Field");
              return false;
            }
            else
            {
              alert("You have submitted order successfully");
              return true;
            }
            } 
        </script>
</body>
</html>


