<?php

set_time_limit(0);

if(isset($_GET)){

  if(isset($_GET['key'])){


    if(strcmp("dfvm9348tjfsdogifq0234itj", $_GET['key'])==0){

      if(strcmp(".jpg", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".JPG", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".jpeg", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".JPEG", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".png", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".PNG", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".pdf", substr(urldecode($_GET['url']), -4))==0 ||
        strcmp(".PDF", substr(urldecode($_GET['url']), -4))==0


        ){


        $data = file_get_contents(urldecode($_GET['url']));

        print($data);
      
      }

    }

  }
}

?>
