<?php 

// database connnection and functions file
include('inc/functions.php');

// Set the title in the HTML head
$pageTitle = 'MyJournal | Entry Details';

// Place header before call to get_entry so that
// it displays regardless of whether entry is found
include('inc/header.php');

// check if an id has been passed, if so get entry details
if (isset($_GET['id'])) {
    $entry = get_entry(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

    // check if entry has tags
    $tags = get_entry_tags($entry['id']);
} else {
    echo '<h2>No Journal Entry Selected</h2>';
    die();
}

if ($entry == false) {
    echo '<h2>Journal Entry Not Found</h2>';
    die();
}
?>
<section>
  <div class="container">
    <div class="entry-list single">
      <article>
        <h1><?php echo $entry['title'] ?></h1>
        <?php 
        // convert date from yyyy-mm-dd format to full word representation.
        $date = date('F j, Y', strtotime($entry['date']));

        echo '<time datetime="' . $entry['date'] . '">' . $date . '</time>';
        ?>
        
        <div class="entry">
          <h3>Time Spent: </h3>
          <p><?php echo ucwords($entry['time_spent']) ?></p>
        </div>
        <div class="entry">
          <h3>What I Learned:</h3>
          <p>
          <?php echo $entry['learned'] ?>
          </p>
        </div>

        <?php 
        // only display resource area if user saved resources
        if(!empty($entry['resources'])) {
          echo '<div class="entry">';
          echo '<h3>Resources to Remember:</h3>';
          echo '<ul>';
          
          // loop through each line of resources string
          foreach(explode(PHP_EOL, $entry['resources']) as $resource) {
            echo '<li>'; 
            $sub_items = (explode(',', $resource));

            // if user used correct format, display as link
            // otherwise just write out the whole line as text
            if(count($sub_items) > 1) {
              echo '<a href="http://' . $sub_items[0] . '" target="_blank" >' . $sub_items[1] . '</a>';
            } else {
              echo $sub_items[0];
            }
            echo '</li>';
          } 
          echo '</ul>';   
          echo '</div>';                     
        }

        // only display tags area if user saved tags
        if(!empty($tags)) {
          echo '<div class="entry">';
          echo '<h3>Tags:</h3>';
          echo '<ul class="tags">';
          foreach($tags as $tag) {
            echo '<li><a href="index.php?tag=' . $tag['title'] . '" >' . $tag['title'] . '</a></li>';
          }
          echo '</ul>';   
          echo '</div>';                     
        }
        ?>
      </article>
    </div>
  </div>
  <div class="edit">
    <p>
      <a href="entry.php?id=<?php echo $entry['id'] ?>">Edit Entry</a >
      <?php 
      echo '<form action="entry.php" method="post">';
      echo '<input type="hidden" name="id" value="' . $entry['id']. '" />';
      echo '<input type="submit" value="DELETE ENTRY" name="delete" class="link" />';
      echo '</form>'
      ?>
    </p>
  </div>
</section>
<?php 
include('inc/footer.php');
?>