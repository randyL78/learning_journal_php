# Learning Journal Php

Third project in the PHP Techdegree

## Instructions

### Before you start

- [X] Download the project files. We've supplied the SQLite Database/HTML/CSS shell files for you to connect your project.
- [X] Convert the HTML files to PHP files and pull out the header and footer to be managed in one place.
- [X] Move the journal.db file into an inc directory.

### Meets

- [X] Create a PDO connection to the SQLite (database.db) file within the inc folder.
- [X] Use prepared statements to add/edit/delete journal entries in the database.
- [X] Create "add/edit" view for the "entry" page that allows the user to add or edit journal entries with the following fields: title, date, time_spent, learned, and resources. Each journal entry should have a unique primary key.
- [X] Create "list" view for the "index" page. The list view contains a list of journal entries, which displays Title and Date of each Entry. The title should be hyperlinked to the detail page for each journal entry. Entries should be sorted by date. Include a link to add an entry.
- [X] Create "details" view with the entries displaying the journal entry with all fields: title, date, time_spent, learned, and resources. Include a link to edit the entry.
- [X] Add the ability to delete a journal entry.
- [X] Use the supplied HTML/CSS to build and style your pages.Use CSS to style headings, font colors, journal entry container colors, body colors.

### Exceeds

- [X] Add tags table and link tags to journal entries in the database. You'll want to download a SQLite Browser to modify the database.
- [X] Add tags to journal entries on the listing page and allow the tags to be links to a list of entries, filtered by specific tags.
- [X] Add tags to the details page, with link to a list of entries, filtered by specific tags
- [X] Add tags to entry page to add to created entries.