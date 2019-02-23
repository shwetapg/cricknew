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
    $url2 = 'https://criknowapp.herokuapp.com/get_video_categories/';
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
    $url2 = 'https://criknowapp.herokuapp.com/get_video_topics/';
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
    // session_start();
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




        $url = 'https://criknowapp.herokuapp.com/videos/';
        $data = array(
                    
                    'title' => $_POST['title'],
                    'category' => $_POST['category'],
                    'topic' => $_POST['topic'],
                    'link'=>$_POST['link'],
                    'url' => "",
                    'thumbnail'=> $arr_update_doc_tab['pk'],
                    'featured' => $_POST['featured'],               
                  );

          $options = array(
            'http' => array(
              'header'  => "Content-Type: application/json\r\n" .
                           "Accept: application/json\r\n",
              'method'  => 'POST',
              'content' => json_encode( $data ),
            ),
          );
          $ss = json_encode($data);
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $arr = json_decode($result,true);
          // print_r($arr);
          $va=$arr['pk'];
          // print_r($va);
          //  var_dump($ss);

    }
  ?>
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
        <nav class="navbar navbar-inverse" style="background-color:lightgreen;;border-color:lightgreen;">
          <?php session_start(); ?>
        <h5 class="welcome" style="color:white;text-align: right;margin-right: 193px;"><b>Welcome   <?php echo $_SESSION['admin_name']; ?>,</b></h5>
        <div style="text-align: right;margin-top: -28px;margin-right: 24px;"><a href="./criknowlog.php" style="color: red;"><b>LOGOUT</b></a></div>
    </nav>
    
    <h4 style="text-align:center;"><b>ADD VIDEO</b></h4><br/><br/>
    <form enctype="multipart/form-data" action="./criknowaddvideos.php" method="post" style="" id"myForm">
         <div>
         <div style="margin-left: 63%;margin-bottom: -25px;">
          <input type="checkbox" name="featured" id="featured" value="YES"><span>Featured Videos</span>
         </div>
          <label for="headline" style="margin-left:31%;">Title:</label>
          <textarea name="title" id="title" placeholder="Enter Title" class="form-control" style="height:125px;width:25%;margin-left:36%;margin-top:-2%;"></textarea>

          
           <div style="margin-top: 25px;">
           <label for="category" style="margin-left:372px;">Category:</label>
                <select name="category" id="category" class="form-control" style="margin-left:36%;margin-top:-2%;width:25%;">
                 <?php for($x=0;$x<count($arr2['video_categories']);$x++){ ?>
                  <option value="<?php echo $arr2['video_categories'][$x]['category']; ?>"><?php echo $arr2['video_categories'][$x]['category']; ?></option>
                 <?php } ?>
                </select></div><br/>

                <div style="margin-top: -52px;margin-left: -140px;">
          <button style="margin-left:67%;">add category</button>
          </div>
         
         <div style="margin-top: 25px;">
          <label for="topic" style="margin-left:395px;">Topic:</label>
                <select name="topic" id="topic" class="form-control" style="margin-left:36%;margin-top:-2%;width:25%;">
                 <?php for($x=0;$x<count($arr3['video_topics']);$x++){ ?>
                  <option value="<?php echo $arr3['video_topics'][$x]['topic']; ?>"><?php echo $arr3['video_topics'][$x]['topic']; ?></option>
                 <?php } ?>
                </select></div><br/>


                 <div style="margin-top: -54px;margin-left: -140px;">
          <button style="margin-left: 67%;width: 110px;">add topic</button>
          </div>

              <div style="margin-top: 25px;">
                <label for="link" style="margin-left:28%;">Video URL:</label>
          <input name="link" id="link" placeholder="http://" class="form-control" style="width:25%;margin-left:36%;margin-top:-2%;"></div><br/>

           <label for="media_id" style="margin-left: 28%;">Thumbnail:</label>
             <img id="myImg" src="profile.png"  width="100" height="100" style="margin-left:40px;"/>
          <input type="file" name="logo" style="margin-left: 37%;margin-top: 5px;">
            <br/><br/>


           <button type="submit" id="submit" name="submit" style="margin-left:36%;background-color:lightgreen;">PUBLISH VIDEOS</button>
           <button style="margin-left:10%;background-color:lightgreen;" onclick="window.location.href='./criknowvideos.php'">CANCEL</button><br/><br/>

         <!--  <button type="submit" name="send_message" id="send_message"  class="btn send_msg" style="">SEND MESSAGE</button> -->
        
        </div>

    </div>
    </form>
</body>
</html>


