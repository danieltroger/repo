<?php
header("Content-type: text/plain");
print_r(json_decode(file_get_contents("visits.json")));