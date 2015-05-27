<?php

error_reporting(E_ALL);

require_once("lib/Sky.php");
require_once("application/config.php");
require_once("application/routes.php");

Sky::instance()->start();
