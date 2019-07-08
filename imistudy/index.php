<?php
  session_start();
  
  $_SESSION['id'] = 'test';

 
  Header("Location:select_schedule.php");
?>