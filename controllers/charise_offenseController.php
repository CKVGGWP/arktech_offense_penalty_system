<?php

include('models/ck_database.php');
include('models/charise_offense.php');

session_start();

$id = isset($_SESSION['idNumber']) ? $_SESSION['idNumber'] : '';

$offense = new Offense();

$data = $offense->categoryLevel("1");

$employee = $offense->selectEmployee();

$HR = $offense->selectHR($id);

$IT = $offense->selectIT($id);

if ($HR == FALSE && $IT == FALSE) {
    header("Location: ../../index.php?title=Dashboard");
}
