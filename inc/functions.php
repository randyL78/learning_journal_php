<?php


/* ==========================================================
 *        entries table functions
 * ========================================================== */
/**
 * function to add or update a journal entry
 * @param string $title The journal title
 * @param string $date Date the event happened in yyyy-mm-dd 
 * @param int $time_spent How long the event tool
 * @param string $learned What the user learned from event
 * @param string $resources optional Links that help explain event
 * @param int $id optional for updating entry
 * @return bool Entry was successfully created or updated
 */
function add_entry($title, $date, $time_spent, $learned, $resources = null, $id = null) {
  include('connection.php');
  var_dump($learned);
  if ($id) {
    
    $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?';
  } else {
    $sql = 'INSERT INTO entries(title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?)';
  }

  try {
    $results = $db->prepare($sql);
    $results->bindValue(1, $title, PDO::PARAM_STR);
    $results->bindValue(2, $date, PDO::PARAM_STR);
    $results->bindValue(3, $time_spent, PDO::PARAM_STR);
    $results->bindValue(4, $learned, PDO::PARAM_STR);
    $results->bindValue(5, $resources, PDO::PARAM_STR);

    if ($id) {
      $results->bindValue(6, $id, PDO::PARAM_INT);
    }

    $results->execute();
    
  } catch(Exception $ex) {
    echo $ex->getMessage();
    return false;
  }

  return true;
}

/**
 * function to delete an entry
 * @param $id Integer representing the entry's id
 * @return bool Successfully deleted entry
 */
function delete_entry($id) {
  include('connection.php');
  $sql = 'DELETE FROM entries WHERE id = ?';

  try {
    $results = $db->prepare($sql);
    $results->bindValue(1, $id, PDO::PARAM_INT);
    $results->execute();
  } catch(Exception $ex) {
    return false;
  }
  return true;
}

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
 * @return mixed an associative and indexed arrays of joournal details
 */
function get_entry($id) {
  include('connection.php');

  $sql = 'SELECT * FROM entries WHERE id = ?';
  
  try {

    $results = $db->prepare($sql);
    $results->bindValue(1, $id, PDO::PARAM_INT);
    $results->execute();

    // don't specify PDO type in fetch so that it works for both 
    // details page which uses assoc and entry page which uses index
    return $results->fetch();

  } catch(Exception $ex) {
    echo $ex->get_message();
    return false;
  }
}

/* ==========================================================
 *        tags table functions
 * ========================================================== */
/**
 * function to get all tags from a specific journal entry
 * @param int $entry_id The id of the journal entry
 * @return array mixed Associative array of tags
 */
function get_entry_tags($entry_id) {

  include('connection.php');

  $sql = 'SELECT tags.id, title 
          FROM entries_tags 
          LEFT JOIN tags
          ON tag_id = tags.id
          WHERE entry_id = ?;';
  
  try {

    $results = $db->prepare($sql);
    $results->bindValue(1, $entry_id, PDO::PARAM_INT);
    $results->execute();

    return $results->fetchAll(PDO::FETCH_ASSOC);

  } catch(Exceptoin $ex) {
    echo $ex->get_message();
    return false;
  }
}

/**
 * function to get a filtered list of entries based
 * on a tag id
 * @param int $tag_id The id of the tag
 * @return mixed an associative array of filtered entries
 */
function get_entries_by_tag($tag_title) {
  include('connection.php');

  $sql = 'SELECT entries.id, entries.title, date 
          FROM entries 
          LEFT JOIN entries_tags
          ON entries.id = entry_id
          LEFT JOIN tags
          ON tag_id = tags.id
          WHERE tags.title = ?
          ORDER BY date DESC;';
  try {

    $results = $db->prepare($sql);
    $results->bindValue(1, $tag_title, PDO::PARAM_STR);
    $results->execute();

    return $results->fetchAll(PDO::FETCH_ASSOC);

  } catch(Exceptoin $ex) {
    echo $ex->get_message();
    return false;
  }
}