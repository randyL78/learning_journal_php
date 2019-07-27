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

/**
 * function to get the details of a single journal entry
 * @param id an integer based database id
 * @return mixed an associative array of joournal details
 */
function get_entry($id) {
  include('connection.php');

  $sql = 'SELECT * FROM entries WHERE id = ?';
  
  try {

    $results = $db->prepare($sql);
    $results->bindValue(1, $id, PDO::PARAM_INT);
    $results->execute();

    return $results->fetch(PDO::FETCH_ASSOC);

  } catch(Exception $ex) {
    echo $ex->get_message();
    return false;
  }
}