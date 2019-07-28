<?php 

// database connnection and functions file
include('inc/functions.php');

// get the list of entries
$entries = get_all_entries();

include('inc/header.php');
?>

<section>
    <div class="container">
        <div class="entry-list">

        <?php 
        if (empty($entries)) {
            echo '<h2>No Journal entries found</h2>';
            echo '<a href="new.php">Let\'s Create One!</a>';
        } else {
            foreach($entries as $entry) {

                // convert date from yyyy-mm-dd format to full word representation.
                $date = date('F j, Y', strtotime($entry['date']));

                echo '<article>';
                echo '<h2><a href="detail.php?id=' . $entry['id'] .  '">' . $entry['title'] . '</a></h2>';
                echo '<time datetime=' . $entry['date'] .  '>' . $date .  '</time>';
                echo '<form action="entry.php" method="post">';
                echo '<input type="hidden" name="id" value="' . $entry['id']. '" />';
                echo '<input type="submit" value="Delete" name="delete" class="button button-warning" />';
                echo '</form>';
                echo '</article>';
            }
        }
        ?>
        </div>
    </div>
</section>
<?php 
include('inc/footer.php');
?>