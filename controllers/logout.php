<?php
  session_abort();
  $_SESSION=array();

  if(isset($_COKKIE[session_name])==true){
    setcookie(session_name(), '', time()-42000, '/');
  };

  session_destroy();
  header('Location: ../');
?>
