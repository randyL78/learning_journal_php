<?php

// database connnection and functions file
include('inc/functions.php');

// set the head's title property
$pageTitle = 'MyJournal | Tags';

// variables for editing info
$edit = isset($_GET['edit']);
$id = isset($_GET['edit']) ? filter_input(INPUT_GET, 'edit',FILTER_SANITIZE_NUMBER_INT) : "";

// Place header before call to get_entry so that
// it displays regardless of whether entry is found
include('inc/header.php');

// if method is POST, delete update or create a tag
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // delete the post if the delete variable is set else 
  // add or update the tag
  if (isset($_POST['delete'])) {
    delete_tag(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
  } else {
    $id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
  
    if(empty($title)) {
      $error_message = 'Please fill out required title field';
    } else {
      if(!add_tag($title, $id)) {
        $error_message = 'Could not add tag';
      }
    }
  }
}

// get all of the tags
$tags = get_tags();

?>

<section>
  <div class="container">
    <div class="edit-tag">
      <h2>Tags</h2>

      <?php 
      // display error message if there is one
      if(isset($error_message)) {
        echo '<p class="error" >' . $error_message . '</p>';
      }
      echo '<ul class="tag-list">';

      // loop through tags and display each one
      foreach ($tags as $tag) {
        echo '<li><form action="tag.php" method="post" >'; 
        if ($edit && $id === $tag['id']) {
          echo '<input type="text" value="' . $tag['title'] . '" name="title" />';
          echo '<input value="Update" class="button" type="submit" />';
        } else {
          echo '<a href="index.php?tag=' . $tag['title'] . '" >' . $tag['title'] . '</a>';
          echo '<a class="button" href="tag.php?edit=' . $tag['id']  . '" >Edit</a>';
        }
        echo '<input type="hidden" name="id" value="' . $tag['id'] . '" />';
        echo '<input type="submit" class="button button-warning" name="delete" value="Delete" />';
        echo '</form></li>';
      }

      if ($edit && empty($id)) {
        echo '<li><form action="tag.php" method="post" >'; 
        echo '<input type="text" placeholder="Tag name" name="title" />';
        echo '<input value="Create" class="button button-create" type="submit" />';
        echo '</form></li>';
      }
     
      echo '</ul>';
      echo '<a class="button" href="tag.php?edit=new" >New Tag</a>';
      ?>


    </div>
  </div>
</section>

<?php
include('inc/footer.php');
?>