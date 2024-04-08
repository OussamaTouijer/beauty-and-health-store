<?php
session_start();
session_unset();//supretion les varible des session
session_destroy();//supretion des session

header('location :index.php');

?>