<?php ini_set('max_execution_time', '0'); ?>
<?php

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Ebay Pricing </title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="login-page">
  <div class="form">
    <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <!-- <p class="message">Already registered? <a href="#">Sign In</a></p> -->
    </form>
    <form class="login-form" method="POST" action="">
      <input type="text" name="sk" placeholder="Search Keyword"/>
      <!-- <input type="password" placeholder="password"/> -->
      <button>Pricing</button>
      <!-- <p class="message">Not registered? <a href="#">Create an account</a></p> -->
    </form>
    <?php
      if(isset( $_POST['sk'] ))
      {
        $princing = array();
        $edata = file_get_contents('https://www.ebay.de/sch/i.html?_ipg=200&rt=nc&_nkw=' . str_replace(" ", "+", $_POST['sk'] ));
        // print('https://www.ebay.de/sch/i.html?_ipg=200&rt=nc&_nkw=' . str_replace(" ", "+", $_POST['sk'] ));
        // li.lvprice.prc .bold
        // simple_html_dom.php
        require('simple_html_dom.php');
        $html = new simple_html_dom();
        $html->load($edata);
        $avg = 0;
        foreach($html->find('li[class=lvprice prc] span[class=bold]') as $element)
        {
          $temp_price =  $element->plaintext ;
          $temp_price = str_replace("EUR","", $temp_price);
          $temp_price = str_replace(" ","", $temp_price);
          $temp_price = str_replace(",",".", $temp_price);

          if(strpos($temp_price, "bis") !== false){
              $princing = array_merge($princing,  (explode("bis",$temp_price))) ;
          } else{
              array_push($princing, $temp_price);
          }
          
        }
        foreach($html->find('span[class=s-item__price]') as $element)
        {
          $temp_price =  $element->plaintext ;
          $temp_price = str_replace("EUR","", $temp_price);
          $temp_price = str_replace(" ","", $temp_price);
          $temp_price = str_replace(",",".", $temp_price);

          if(strpos($temp_price, "bis") !== false){
              $princing = array_merge($princing,  (explode("bis",$temp_price))) ;
          } else{
              array_push($princing, $temp_price);
          }
          
        }
        
        $edata = file_get_contents('https://www.ebay.de/sch/i.html?_ipg=200&rt=nc&_pgn=2&_nkw=' . str_replace(" ", "+", $_POST['sk'] ));
        $html->load($edata);

        foreach($html->find('li[class=lvprice prc] span[class=bold]') as $element)
        {
          $temp_price =  $element->plaintext ;
          $temp_price = str_replace("EUR","", $temp_price);
          $temp_price = str_replace(" ","", $temp_price);
          $temp_price = str_replace(",",".", $temp_price);

          if(strpos($temp_price, "bis") !== false){
              $princing = array_merge($princing,  (explode("bis",$temp_price))) ;
          } else{
              array_push($princing, $temp_price);
          }
          
        }
        foreach($html->find('span[class=s-item__price]') as $element)
        {
          $temp_price =  $element->plaintext ;
          $temp_price = str_replace("EUR","", $temp_price);
          $temp_price = str_replace(" ","", $temp_price);
          $temp_price = str_replace(",",".", $temp_price);

          if(strpos($temp_price, "bis") !== false){
              $princing = array_merge($princing,  (explode("bis",$temp_price))) ;
          } else{
              array_push($princing, $temp_price);
          }
          
        }
        $princing = array_map('floatval', $princing);
        $average = array_sum($princing)/count($princing);

        ?> <h3>Result from: ebay-kleinanzeigen.de </h3> <h4>Term: <?php echo $_POST['sk']; ?> AvgPrice: <?php echo $average; ?> </h4> <?php
        $link_tar = 'https://www.ebay-kleinanzeigen.de/s-preis::'. strval((int)$average) .'/'.str_replace(" ", "+", $_POST["sk"]).'/k0';
        ini_set('user_agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36');
        $edata = file_get_contents($link_tar);
        $html->load($edata);
        foreach($html->find('article') as $element)
        {
          echo $element;
        }

        

      }

    ?>
  </div>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <!-- <script  src="./script.js"></script> -->

</body>
</html>
