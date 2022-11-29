<?php $dir_name = 'test_folder'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Navigator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.min.css" />
    <link rel="stylesheet" href="css/index.css">
</head>

<body onload="collapseAll()">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Respaldo de CDX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
        </div>
    </nav>
    <div class="container">
        <div class="card w-100">
            <form action="filehandler.php?dir_name=<?php echo $dir_name ?>" method="POST">
                <div class="row">
                    <div class="col">
                        <?php

                        function listFolderFiles($dir, $level)
                        {
                            $allowed = array('php', 'html', 'css', 'js', 'txt', 'pdf', 'docx', 'txt');

                            $fileFolderList = scandir($dir);
                            echo '<ul class="drop" id="menu-' . $level . '">';
                            foreach ($fileFolderList as $fileFolder) {
                                if ($fileFolder != '.' && $fileFolder != '..') {
                                    if (!is_dir($dir . '/' . $fileFolder)) {
                                        $ext = pathinfo($fileFolder, PATHINFO_EXTENSION);
                                        if (in_array($ext, $allowed)) {
                                            //|||{/' . ltrim($dir . '/' . $fileFolder, './') . '}|||
                                            echo '<li style="display: list-item;"><input class="form-check-input" type="checkbox" value="/' . ltrim($dir . '/' . $fileFolder, './') . '" id="file-' . $level . '" name="check_list[]">   <label class="form-check-label" for="file-' . $level . '"><i class="fas fa-file-alt"></i>' . $fileFolder . '</label>';
                                        }
                                    } else {
                                        echo '<li style="display: list-item;" id="li-' . $level . '"><input class="form-check-input" type="checkbox" value="/' . ltrim($dir . '/' . $fileFolder, './') . '" id="fol-' . $level . '" name="check_list[]" onclick="checkAllChildren(\'li-' . $level . '\')"><label class="form-check-label" for="fol-' . $level . '"><a onclick="expand(\'li-' . $level . '\')" href="#"><i class="fas fa-folder-open"></i>' . $fileFolder . '</a></label>';
                                    }
                                    if (is_dir($dir . '/' . $fileFolder)) {
                                        listFolderFiles($dir . '/' . $fileFolder, $level);
                                    }
                                    echo '</li>';
                                }
                                $level++;
                            }
                            echo '</ul>';
                        }



                        listFolderFiles($dir_name, 0);


                        ?>
                    </div>


                </div>

                <input class="btn btn-primary" type="submit" value="Download!"></input>
            </form>

        </div>
    </div>
    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>