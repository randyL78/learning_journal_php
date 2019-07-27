<?php

/**
 * function to get a list of all entries
 * @return mixed an associative array of entries
 */
function get_all_entries() {
  include('connection.php');

  try {
    $results = $db->query('SELECT id, title, date FROM entries ORDER BY date DESC');
  } catch(Exception $ex) {
    echo $ex->get_message();
    return false;
  }

  return $results->fetchAll(PDO::FETCH_ASSOC);
}