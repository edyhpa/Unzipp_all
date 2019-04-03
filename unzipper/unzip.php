<?php
echo '||ESTRAZIONE DEI FILE ZIP CONTENUTI NELLA DIRECTORY||'.PHP_EOL.'i file verranno estratti nella cartella -FILESTRATTI-'.PHP_EOL.PHP_EOL.PHP_EOL;
crea_cartella();

$directory = ".";
find_zip($directory);

function find_zip($directory) {
    if (is_dir($directory)) {
    echo 'Cerco zip in: '.$directory.PHP_EOL;
        if ($directory_handle = opendir($directory)) {	
            while (($file = readdir($directory_handle)) !== false) {
                if (($file != ".") & ($file != "..")) { 
                echo 'Elaboro: '.$file.PHP_EOL; 
                if(is_dir($directory.'/'.$file)){ 
            
                find_zip(($directory.'/'.$file));
                }  
                if (strtoupper(pathinfo($file, PATHINFO_EXTENSION)) == 'ZIP') { 
                unzip_file($file, $directory); 
                $name = trim($file, ".zip");
                find_zip($directory.'/'.$name) ;  
                } 
                }  
            }                    
        }             
    }           
}      
  
function unzip_file($filename, $destination) {
    $archive = new ZipArchive();
        if ($archive->open($destination.'/'.$filename) !== true) {
        die('Si e verificato un errore nella decompressione del file ' . $filename . "\n");
    }
    try {
        $destination = '.\filestratti';
        $archive->extractTo($destination);
        $archive->close();
    }catch (Exception $e) {echo $e->getMessage();}
    echo 'Estrazione completata!'.PHP_EOL.PHP_EOL;
} 

function crea_cartella(){
    $path = '.\filestratti';

    if (!file_exists($path)) {
        mkdir($path);
        echo ('Cartella creata in: '.$path.PHP_EOL);
    }
       
}

?>