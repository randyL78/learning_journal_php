-- SQLite

-- Select all information from all entries
SELECT * FROM entries;

-- Select title, id, and date from all entries sorted by date
SELECT id, title, date FROM entries ORDER BY date DESC;

-- Update the title of the second entry
-- UPDATE entries SET title = 'The Worst Day I Ever Had' WHERE id = 2;

-- Select all information from updated entry
-- SELECT * FROM entries WHERE id = 2;

-- Update the title of the second entry back to original
-- UPDATE entries SET title = 'The worst day I ever had' WHERE id = 2;

-- Delete a single entry by id (in this case id of 5)
-- DELETE FROM entries WHERE id = 5;

-- Add an item to the tags table
-- INSERT INTO tags (title) VALUES ('goals');

-- Select all items from the tags table
-- SELECT * FROM tags;

-- Add a link between entries and tags to the entries_tags table
-- INSERT INTO entries_tags(entry_id, tag_id) VALUES (4, 2);

-- Select all items from entries_tags table
SELECT * FROM entries_tags;

-- Select title, id, and date from all entries making entry_id an alias for id
SELECT entries.id, title, date 
FROM entries
LEFT JOIN entries_tags
ON entries.id = entries_tags.entry_id;

-- Select tags for a specific entry 
SELECT tags.id, title 
FROM entries_tags
LEFT JOIN tags
ON tag_id = tags.id
WHERE entry_id = 1;

--- Select entries based on tag
SELECT entries.id, entries.title, date 
FROM entries 
LEFT JOIN entries_tags
ON entries.id = entry_id
LEFT JOIN tags
ON tag_id = tags.id
WHERE tags.title = 'goals'
ORDER BY date DESC;

-- Select all tags
SELECT * FROM tags;

