<?php
session_start();
session_destroy();
header('Location: http://veskrna-roman.4fan.cz/casopis/index.php');
?>