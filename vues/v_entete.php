<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cssBandeau.css">
    <link rel="stylesheet" href="./css/cssGeneral.css">
    <link rel="stylesheet" href="./css/cssRecherche.css">
    <link rel="stylesheet" href="./css/cssSpecialite.css">
    <link rel="shortcut icon" href="./images/lbc_logo_carre.png">
    <title><?php if (isset($title)) echo $title ?></title>
    <?php 
        if (isset($entete)) echo $entete;
    ?>
</head>
<body class="onload">
    
