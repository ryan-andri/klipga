<?php
require_once('configs/config.php');
session_start();
session_destroy();
header('location:' . BASE_URL);
