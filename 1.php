<?php


include "kastuls/fsoup-php.php";

print_r(fsoup::parse_file(""));

echo fsoup::$last_error;
print_r(fsoup::$errors);