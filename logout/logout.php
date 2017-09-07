<?php
/**
 * Created by PhpStorm.
 * User: seanm
 * Date: 7/27/2017
 * Time: 12:50 PM
 */
session_start();
session_destroy();
header('location: ../login/index.php');