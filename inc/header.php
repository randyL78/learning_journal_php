<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <?php 
            if (!isset($pageTitle)) {
                $pageTitle = 'MyJournal';
            }
            echo '<title>' . $pageTitle . '</title>';
        ?>
        <link href="https://fonts.googleapis.com/css?family=Cousine:400" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/site.css">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="entry.php"><span>New Entry</span> <i class="material-icons">add</i></a>
                    <a class="button icon-right button-secondary" href="tag.php"><span>New Tag</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>