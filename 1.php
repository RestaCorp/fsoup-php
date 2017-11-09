<?php


include "fsoup-php.php";

print_r(fsoup::parse_file("os.fsoup"));

echo fsoup::$last_error;
print_r(fsoup::$errors);
