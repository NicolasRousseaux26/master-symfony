<?php


namespace App\Service;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * $fileName = $this->>uploadDir->upload($file);
     */
    public function upload(UploadedFile $image)
    {
        // génére le nom de l'image
        $fileName = uniqid() . '.' . $image->guessExtension();
        // on deplace l'image
        $image->move($this->uploadDir, $fileName);

        return $fileName;

    }
    public function remove($fileName)
    {
        $fs = new Filesystem();
        //recupére le chemin du fichier
        $file = $this->uploadDir.'/'.$fileName;
        if($fs->exists($file)){
            //supprimé le fichier
            $fs->remove($file);
        }

    }
}