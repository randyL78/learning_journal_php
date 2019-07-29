<?php 
// database connnection and functions file
include('inc/functions.php');

// Set the title in the HTML head
$pageTitle = 'MyJournal | New Entry';

// Declare variables to store input information
$id = "";
$title = "";
$date = "";
$time_spent = "";
$learned = "";
$resources = "";
$entry_tags = [];

// check if an entry id was passed to the page
if(isset($_GET['id'])) {
  list($id, $title, $date, $time_spent, $learned, $resources) = 
    get_entry(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
  $pageTitle = 'MyJournal | Edit Entry';
  $entry_tags = get_entry_tags($id);
}

// go ahead and add in the header in case there are errors later,
// the user can still navigate
include('inc/header.php');

// delete the post if the delete variable is set
if (isset($_POST['delete'])) {
  if (delete_entry(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT))) {
    header('Location: index.php');
    exit();
  }
  echo '<p class="error" >' . $error_message . '</p>';
  die();
}

// if the method is POST, update or create an entry
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
  $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
  $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
  $time_spent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
  $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
  $resources = trim(filter_input(INPUT_POST, 'resourcesToRemember', FILTER_SANITIZE_STRING));
  $updated_tags="";
  if (isset($_POST['tags'])) {
    $updated_tags = $_POST['tags'];
  }
  


  // validating date only for if the input type changes later. 
  // Date type inputs automatically have consistent date properties.
  $isDate = explode('-', $date);

  // validation
  if(empty($title) || empty($time_spent) || empty($learned)) {
    $error_message = 'Please fill in the required fields: Title, Time Spent, What I Learned'; 
  } elseif(count($isDate) != 3
  || strlen($isDate[0]) != 4
  || strlen($isDate[1]) != 2
  || strlen($isDate[2]) != 2
  || !checkdate($isDate[1], $isDate[2], $isDate[0])        
      ) {
      $error_message = 'Invalid Date';
  } else { 
    if(add_entry($title, $date, $time_spent, $learned, $resources, $updated_tags, $id)) {
      header('Location: index.php');
      exit();
    } else {
      $error_message = 'Could not add journal entry';
    }
  }
}

// get all available tags
$tags = get_tags();



?>
<section>
  <div class="container">
    <div class="edit-entry">
      <?php 
      if(empty($id)) {
        echo '<h2>New Entry</h2>';
      } else {
        echo '<h2>Edit Entry</h2>';
      }
 
      if(isset($error_message)) {
        echo '<p class="error" >' . $error_message . '</p>';
      }
      ?>
      <form action="entry.php" method="post">
        <label for="title"> Title</label>
        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title) ?>"><br>
        <label for="date">Date</label>
        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date) ?>"><br>
        <label for="time-spent"> Time Spent</label>
        <input id="time-spent" type="text" name="timeSpent" value="<?php echo htmlspecialchars($time_spent) ?>"><br>
        <label for="what-i-learned">What I Learned</label>
        <textarea id="what-i-learned" rows="5" name="whatILearned" ><?php echo $learned ?></textarea>
        <?php 
        ?>
        <label for="resources-to-remember">Resources to Remember</label>
        <textarea id="resources-to-remember" rows="5" placeholder="Please use format:&#13;&#10;www.web.link1, web site name 1&#13;&#10;www.web.link2, web site name 2" name="resourcesToRemember"><?php echo $resources; ?></textarea>
        <label>Tags</label>
        <?php
        // loop through the available tags and make them checkboxes
        foreach($tags as $tag) {
          echo '<label><input type="checkbox" ';
          echo in_array($tag, $entry_tags) ? "checked" : null;
          echo ' name="tags[]" value="' . $tag['id'] . '" />' . $tag['title'] . '</label>';
        }
        // store the id in a hidden field in edit mode
        if(!empty($id)) {
          echo '<input type="hidden" name="id" value="' . $id . '" />';
        }
        ?>
        <input type="submit" value="Publish Entry" class="button">
        <a href="entry.php<?php 
          if(!empty($id)) {
            echo '?id=' . $id;
          }
        ?>" class="button button-secondary">Cancel</a>
        <?php 
          if(!empty($id)) {
            echo '<input type="submit" value="Delete" name="delete" class="button button-warning" />';
          }
        ?>
      </form>
    </div>
  </div>
</section>
<?php 
include('inc/footer.php');
?>