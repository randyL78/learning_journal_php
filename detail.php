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
                <div class="entry">
                    <h3>Resources to Remember:</h3>
                    <ul>
                        <li><a href="">Lorem ipsum dolor sit amet</a></li>
                    </ul>
                </div>
            </article>
        </div>
    </div>
    <div class="edit">
        <p><a href="entry.php?id=<?php echo $entry['id'] ?>">Edit Entry</a></p>
    </div>
</section>
<?php 
include('inc/footer.php');
?>