<?php
  session_start();
  //session_destroy();
  require_once 'config.php';
  require 'TwitterOAuth/autoload.php';
  use Abraham\TwitterOAuth\TwitterOAuth;
  if(!isset($_SESSION['access_token']))
  {
    header("Location: getConnection.php");
  }
  else
  {
    if(!isset($_SESSION['tweets']) && !isset($_SESSION['followers']))
    {
      header("Location:getData.php");
    }
    if(isset($_SESSION['tweets_follower']))
    {
      $tweets = json_decode(json_encode($_SESSION['tweets_follower']), True);
    }
    else if(isset($_SESSION['tweets'])) 
    {
      $tweets = json_decode(json_encode($_SESSION['tweets']), True);
    }
    $followers = json_decode(json_encode( $_SESSION['followers'] ), True);
 //   echo $followers['users'][0]['followers_count'];
    $count_tweets = count($tweets);
    $count_followers = count($followers['users']);
  }
  
?>


<html>
  <head>
    <title>Tweet Viewer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  
    

  </head>
  <body>

   
    <div class="container">


      <h2>Tweet List: <button class="btn btn-link" > <a href="refresh.php"><i class="fas fa-sync"></i></button></a> </h2>

            <div class="row">
                
                <div id="carouselExampleControls" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner">
                      <?php for($key = 0; $key<$count_tweets; $key += 2) { ?>
                        <div class="carousel-item <?php if($key == 0) { echo "active"; } ?>">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-12 border w-50">
                                    <h3 id="<?php echo $key;?>nm"><?php echo $tweets[$key]['user']['screen_name'];?></h3>
                                    <p id="<?php echo $key;?>tw"><?php echo $tweets[$key]['text']?></p>
                                </div>  
                                 <div class="col-md-6 col-sm-12 col-12 border w-50">
                                    <h3 id="<?php echo $key+1;?>nm"><?php echo $tweets[$key+1]['user']['screen_name'];?></h3>
                                    <p id="<?php echo $key+1;?>tw"><?php echo $tweets[$key+1]['text']?></p>
                                </div>    
                            </div>
                        </div>
                      <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>   

            <br/>


            <h2 style="display: inline; float: left; margin-left: 2rem; margin-right: 2rem">Follower List:</h2>

            <div class="input-group" style=" float:right; width:30%;">
                  <select class="custom-select" id="format">
                    <option selected value="PDF">PDF</option>
                    <option value="XML">XML</option>
                  </select>
            </div>

            <form class="form-inline md-form form-sm my-1" style=" float:left; width: 20%">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input class="form-control form-control-sm ml-3 w-75" id="searchbar" placeholder="Search" aria-label="Search">
            </form>


              <br/>
              <br/>

                <div id="carouselFollower" class="carousel slide p-4" data-ride="carousel" >
                    <div class="carousel-inner">
                       <?php for($key = 0; $key<$count_followers;$key += 2) { ?>
                         <div class="carousel-item <?php if($key==0) { echo "active"; }?>">
                            <div class="row">
                               <div class="col-md-6 col-sm-6 col-12">
                                   <div class="card P-3">
                                      <img class="rounded mx-auto d-block" src="<?php echo $followers['users'][$key]['profile_image_url']; ?>" alt="<?php echo $followers['users'][$key]['name']; ?>">
                                      <div class="card-body">
                                        <h5 class="card-title text-center user-name"><?php echo $followers['users'][$key]['name']; ?></h5>
                                        <a href="<?php echo $followers['users'][$key]['screen_name']; ?>" class="btn btn-primary mx-auto d-block viewTweets">View Tweets</a>
                                        <a href="<?php echo $followers['users'][$key]['screen_name']; ?>" count="<?php echo $followers['users'][$key]['followers_count']; ?>" class="btn btn-primary mx-auto d-block downloadFollower my-1">Download Followers</a>
                                      </div>
                                    </div>
                                </div>    
                                <div class="col-md-6 col-sm-6 col-12">
                                     <div class="card P-3">
                                      <img class="rounded mx-auto d-block" src="<?php echo $followers['users'][$key+1]['profile_image_url']; ?>" alt="<?php echo $followers['users'][$key+1]['name']; ?>">
                                      <div class="card-body">
                                        <h5 class="card-title text-center user-name"><?php echo $followers['users'][$key+1]['name']; ?></h5>
                                       <!--<p class="card-text">Bio</p>-->
                                        <a href="<?php echo $followers['users'][$key+1]['screen_name']; ?>" class="btn btn-primary mx-auto d-block viewTweets">View Tweets</a>
                                        <a href="<?php echo $followers['users'][$key+1]['screen_name']; ?>" count="<?php echo $followers['users'][$key+1]['followers_count']; ?>" class="btn btn-primary mx-auto d-block downloadFollower my-1">Download Followers</a>
                                      </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselFollower" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselFollower" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>    
        </div>

        <script>
            $('.viewTweets').click(function(event){
                event.preventDefault();
                var screenNm = $(this).attr('href');
                $.ajax
                ({ 
                    url: 'getFollowerData.php',
                    data : {'screenNm' : screenNm},
                    type: 'GET',
                    dataType: 'json',
                    success: function(tweets)
                    {

                       // alert(tweets);
                        for (var i = 0; i < 10; i++) {
                         // document.getElementById(i+"nm").innerText = 
                         $('#'+i+'nm').text(tweets[i].user.screen_name);
                          //document.getElementById(i+"tw").innerText = 
                        $('#'+i+'tw').text(tweets[i].text);
                         // alert(i);
                        }
                    },
                    error: function(xhr, status, error) {
                      alert("here");
                    }
                });
            });

        </script>

        <script type="text/javascript">
          
           $('.downloadFollower').click(function(){
                var format = $( "#format" ).val();
                var screenNm = $(this).attr('href');
                var count = $(this).attr('count');
                var url = 'downloadFollower.php?format='+format+'&screenNm='+screenNm+'&count='+count;
                window.open(url, '_blank');
            });

        </script>

        <script type="text/javascript">
          $(function() {
            var suggestions = new Array();
            var i=0;
            $('.user-name').each(function(){
              suggestions[i] = ""+$(this).text();
              alert(suggestions[i]); 
            });

            $('#searchbar').autocomplete({
              source: suggestions
            });
          });
        </script>
  </body>
</html>




