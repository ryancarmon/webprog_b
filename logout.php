<?php
require 'php/functions.req.php';

session_start();

ses_logout();
redirect('index.php');
?>