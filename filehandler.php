<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <img src="imgx/loading.gif" alt="loading" id="image">

    <?php

    if (!isset($_POST['check_list'])) {
        echo '<script type="text/javascript>alert("No se selecciono ningun archivo")</script>';
        header('Location: index.php');
    }

    $files = $_POST['check_list'];



    function rmtree($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object)) {
                        rmtree($dir . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
    $zip = new ZipArchive;

    $f = date('Y-m-d') . '-' . date("h-i-sa") . '.zip';
    $fileName = './respaldos/' . $f;
    $zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);


    $to_dir = 'files/';

    foreach ($files as $selected) {
        if (is_dir('./' . $selected) && !is_dir($to_dir . $selected)) {
            mkdir($to_dir . $selected, 0777, true);
        }
    }

    foreach ($files as $selected) {
        if (is_file('./' . $selected) && !file_exists($to_dir . $selected)) {
            copy('./' . $selected, $to_dir . $selected);
        }
    }

    if (count(scandir($to_dir)) > 2) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($to_dir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($to_dir) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();
        //rmtree('to_dir');
        rmtree($to_dir . $_GET['dir_name']);

        header("refresh:2;url=index.php");
    }


    ?>
    <script type="text/javascript">
        a = document.createElement('a');
        a.href = '<?php echo $fileName ?>'
        a.download = '<?php echo $f ?>'
        document.body.appendChild(a);
        a.click()
        document.body.removeChild(a);
    </script>
</body>

</html>