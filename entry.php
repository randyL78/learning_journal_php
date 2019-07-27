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

// check if an entry id was passed to the page
if(isset($_GET['id'])) {
  list($id, $title, $date, $time_spent, $learned, $resources) = 
    get_entry(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

}

// if the method is POST, update or create an entry
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
  $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
  $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
  $time_spent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
  $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
  $resources = trim(filter_input(INPUT_POST, 'resourcesToRemember', FILTER_SANITIZE_STRING));

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
    if(add_entry($title, $date, $time_spent, $learned, $resources, $id)) {
      header('Location: index.php');
    } else {
      $error_message = 'Could not add journal entry';
    }
  }
}


include('inc/header.php');
?>
<section>
    <div class="container">
        <div class="edit-entry">
            <h2>Edit Entry</h2>
            <?php 
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
                <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo $resources; ?></textarea>
                <?php
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
            </form>
        </div>
    </div>
</section>
<?php 
include('inc/footer.php');
?>