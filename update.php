<?php
// File path to the live text file
$filePath = 'text/index.html';

// Check if the file exists, if not, create it
if (!file_exists($filePath)) {
    file_put_contents($filePath, '');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Read the content of the file and return it
    $content = file_get_contents($filePath);
    echo $content;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Acquire an exclusive lock on the file before updating
    $file = fopen($filePath, 'c+');
    if (flock($file, LOCK_EX)) {
        $content = $_POST['content'];

        // Clear the file content and write the new content
        ftruncate($file, 0);
        fwrite($file, $content);

        // Release the lock and close the file
        flock($file, LOCK_UN);
    }
    fclose($file);
}
?>
