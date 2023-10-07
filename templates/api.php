<?php

header("Content-Type: application/json");
if(isset($data['status']))
    http_response_code($data['status']);
else
    http_response_code(200);

echo json_encode($data, JSON_UNESCAPED_UNICODE);