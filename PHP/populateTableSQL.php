<?php
//This file puts the data from a given csv file into a database

$pdo = new PDO('mysql:host=info344ass1db.cddyfslrrxki.us-west-2.rds.amazonaws.com;dbname=nbastats', 'wsmay1', 'madbull46', array(PDO::MYSQL_ATTR_LOCAL_INFILE => TRUE));
$pdo->exec("
    LOAD DATA LOCAL INFILE ".$pdo->quote("2012-2013.nba.stats.csv")." INTO TABLE `Players`
      FIELDS TERMINATED BY ".$pdo->quote(",")."
      LINES TERMINATED BY ".$pdo->quote("\n"));