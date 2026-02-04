<?php
function getDB() {
    return new SQLite3(__DIR__ . '/data.sqlite');
}
?>