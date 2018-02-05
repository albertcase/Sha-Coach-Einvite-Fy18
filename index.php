<?php
ini_set("display_errors","on");
session_start();
require_once dirname(__FILE__) . "/Core/bootstrap.php";
Core::Response();
