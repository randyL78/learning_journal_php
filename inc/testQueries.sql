-- SQLite

-- Select all information from all entries
SELECT * FROM entries;

-- Select title, id, and date from all entries
SELECT id, title, date FROM entries ORDER BY date DESC;

-- Update the title of the second entry
UPDATE entries SET title = 'The Worst Day I Ever Had' WHERE id = 2;

-- Select all information from updated entry
SELECT * FROM entries WHERE id = 2;

-- Update the title of the second entry back to original
UPDATE entries SET title = 'The worst day I ever had' WHERE id = 2;

-- Select all information from updated entry
SELECT * FROM entries WHERE id = 2;