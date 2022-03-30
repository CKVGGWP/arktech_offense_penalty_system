<?php

include('../models/ck_database.php');
include('../models/charise_offense.php');

$offense = new Offense();

if (isset($_POST['categorySelect1'])) {
    $data = $offense->categoryLevel("2", $_POST['category1']);
    echo $data;
} else if (isset($_POST['categorySelect2'])) {
    $data = $offense->categoryLevel("3", $_POST['category2']);
    echo $data;
}
