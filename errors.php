<?php
function throw400() {
    http_response_code(400);
    throwError("400 - Bad request!<br> <a href='index.html'>Zpět na index</a>");
    die();
}

function throw404() {
    http_response_code(404);
    throwError("404 - Not found!<br> <a href='index.html'>Zpět na index</a>");
    die();
}


function throwError($error) {
    echo '
    
    <!DOCTYPE html>
<html>
<head>
    <title>' . $error . '</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
        <h1>' . $error . '</h1>
</body>
</html>
    
    
    
    ';
}
