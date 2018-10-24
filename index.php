<?php
function print_dir($path)
{
    $typeNotAccepted = ['image/jpeg'];
    $dir = opendir($path);
    
    echo '<ul>';
    while($file=readdir($dir))
    {
        if(!is_dir($path.$file))
        {
            echo '<li>';
            if (!in_array(mime_content_type($path.$file),$typeNotAccepted))
            {
                echo '<a href="?f='.$path.$file.'">'.$file.'</a>';
            }
            else
            {
                echo $file;
            }
            echo '   <a class="deleteLink" href="?del='.$path.$file.'">Delete</a>';
            echo '</li>';
        }
        elseif($file!='.' && $file!='..')
        {
            echo '<li>'.$file.'  <a class="deleteLink" href="?delf='.$path.$file.'">Delete</a></li>';
            print_dir($path.$file.'/');
        }
    }
    echo '</ul>';
}

function deleteFile($file)
{
    if(file_exists($file))
    {
        unlink($file);
    }
}

function deleteFolder($folder)
{
    return rmdir($folder);
}

if(isset($_POST['contenu']))
{
    $fichier = $_POST['file'];
    $file = fopen($fichier,'w');
    fwrite($file,$_POST['contenu']);
    fclose($file);
}

if(isset($_GET['del']))
{
    deleteFile($_GET['del']);
}

if(isset($_GET['delf']))
{
    if(!deleteFolder($_GET['delf']))
    {
        echo "Please delete all the files before deleting the folder";
    }
}

?>

<?php include('inc/head.php'); ?>

<div>
    
    <?php

    $origin = 'files/';
    print_dir($origin);
       
    ?>
</div>
<?php
    if(isset($_GET['f']))
    {
        $fichier = $_GET['f'];
        $contenu = file_get_contents($fichier);
    
?>

        <form action="" method="POST">
            <textarea name="contenu" rows="10" style="width:100%;"><?php echo $contenu;?></textarea>
            <input type="hidden" name="file" value="<?php echo $fichier?>">
            <input type="submit" value="Envoyer">
        </form>
<?php
    }
?>

<?php include('inc/foot.php'); ?>