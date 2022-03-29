<?php

include('models/ck_database.php');
include('models/charise_offense.php');

$offense = new Offense();

$data = $offense->categoryLevel("1");

$employee = $offense->selectEmployee();
