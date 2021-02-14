<?php
session_start();

if (isset($_SESSION['results'])) {
    extract($_SESSION['results']);
    $_SESSION['results'] = null;
}

require 'index-view.php';