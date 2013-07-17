<!DOCTYPE html>
<?php

echo("<pre>");
print_r($_SESSION);
echo("</pre>");

?>

<html>
<head>

    <title>ADMIN AREA</title>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!--[if IE 7]>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body data-spy="scroll" data-target=".navbar">

<p class="alert alert-info text-right text-info">
    <i class="icon-map-marker"></i> <span id="my_location">...</span>
    <i class="icon-signal"></i> <span id="my_accuracy">...</span>
</p>

<div class="container">

