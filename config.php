<?php
  // setting up session
  /* note: This is not a secure way to store oAuth tokens. You should use a secure
  *     data sore. We use this for simplicity in this example.
  */
  echo "<h4>If you see a Session warning above you need to run the command: 'chmod 777 temp' in the terminal on the code page. </h4>";

  define('OAUTH_CONSUMER_KEY', 'qyprdapfoD9c3zuZJdM414NS9lzdyp');
  define('OAUTH_CONSUMER_SECRET', 'F0ylcIrHemquJKST85KEjoMWvC43VxIjVeL6wEHc');
  
  
  if(strlen(OAUTH_CONSUMER_KEY) < 5 OR strlen(OAUTH_CONSUMER_SECRET) < 5 ){
    echo "<h3>Set the consumer key and secret in the config.php file before you run this example</h3>";
  }
  
 
?>