<?php
// 세션 바로 실행.
  session_start();
  
  $_SESSION['id'] = 'test';

 
  Header("Location:select_schedule.php");
?>