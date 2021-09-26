<?php

const DIRECTORY = '//files/';
$message = '';

function Upload(array $data) : bool
{
    if (!empty($data)) {
        if ($data['file']['size'] > (512 * 1024)) return false;
        if (move_uploaded_file($data['file']['tmp_name'], __DIR__ . DIRECTORY . $data['file']['name'])) return true;
    }

    return false;
}

if (isset($_POST['submit'])) {
    if (Upload($_FILES)) {
        $message = "Файл был загружен успешно!";
    } else {
        $message = "Не смог загрузить файл...";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />

        <title>Upload file</title>
    </head>
    <body>
        <?=$message?>
        <form action="." method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="file" placeholder="Загрузить файл" />
            <input type="submit" name="submit" value="Загрузить" />
        </form>
    </body>
</html>