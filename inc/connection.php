<?php

// creates a PDO connection to the journal database
try {
  $db = new PDO('sqlite:' . __DIR__ . '/journal.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
} catch (Exception $ex) {
  echo $ex->get_message();
  die();
}

