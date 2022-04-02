<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait fileUploadDeleteTrait{
    public function fileNameGenerateAndUpload($file,$filename,$uploadOn,$disk, $height, $width)
    {
        // dd($file,$filename,$uploadOn,$disk, $height, $width);
            $madeFileName = Str::slug($filename) . '-'.rand(100,1000). Carbon::now()->timestamp . '.'. $file->extension();
            $uploadFile = $file;
            if ($height && $width) {
                $uploadFile = Image::make($file)->resize( $width, $height )->save();
                Storage::disk($disk)->put("$uploadOn/" .$madeFileName, $uploadFile);
            }else {
                $file->storeAs("$uploadOn/", $madeFileName, $disk);
            }

            return $madeFileName;
    }
    public function fileUploads($files,$filename='customers',$uploadOn='customers', $disk='public',$height=null, $width=null)
    {    
        if (gettype($files)==='array') {
            $imageNames=[];
            foreach($files as $file){
                $madeFileName=$this->fileNameGenerateAndUpload($file,$filename,$uploadOn, $disk);
                array_push($imageNames,$madeFileName);                
            }
            return $imageNames;
        }else{
            return $this->fileNameGenerateAndUpload($files,$filename,$uploadOn, $disk,$height, $width);
        }
    }
    
    public function deleteFileTrait($files, $delForm='customers', $disk='public')
    {    
        if (gettype($files)==='array') {
            $imageNames=[];
            foreach($files as $file){
                // $madeFileName=$this->fileNameGenerateAndUpload($file,$filename,$delForm, $disk);
                // array_push($imageNames,$madeFileName);                
            }
            return $imageNames;
        }else{
            Storage::disk($disk)->delete("$delForm/$files");
            return true;
        }
    }
}