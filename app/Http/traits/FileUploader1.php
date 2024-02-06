<?php

namespace App\Http\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait FileUploader1
{
    public function uploadFile($request, $data, $name, $inputName = 'files')
    {
        $requestFile = $request->file($inputName);
        try {
            $dir = 'public/files/'.$name;
            $fixName = $data->id.'-'.$name.'.'.$requestFile->extension();

            if ($requestFile) {
                Storage::putFileAs($dir, $requestFile, $fixName);
                $request->file = 'files/'.$name.'/'.$fixName;

                $data->update([
                    $inputName => $request->file,
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    // delete file
    public function deleteFile($fileName = 'files')
    {
        try {
            if ($fileName) {
                Storage::delete('public/files/'.$fileName);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }

    /**
     * For Upload Images.
     * @param mixed $request
     * @param mixed $data
     * @param mixed $name
     * @param mixed|null $inputName
     * @return bool|string
     */
    public function uploadImagePublic ($request, $data='null', $name,$inputName='player')
    {
        $requestFile = $request->file($inputName);
        // dd($requestFile);
        try {
            $dir = 'public/images/'.$name;
            // $dir = 'images/'.$name;
            // $fixName = $data->id.'-'.$name.'.'.$requestFile->extension();
            $fixName = time().'-'.$name.'.'.$requestFile->extension();
            if ($requestFile) {
                $r=  Storage::putFileAs($dir, $requestFile, $fixName);
                // $r = $requestFile->storeAs($dir, $fixName,'public');
                // $requestFile->move(public_path($dir), $fixName);
                $request->image = $fixName;

                // $data->update([
                //     $inputName => $request->image,
                // ]);
            }

            return $r;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }


    public function uploadImagePrivate($request, $data='null', $name, $inputName ='identity_card')
    {
        $requestFile = $request->file($inputName);
        try {
            $dir = 'images/'.$name;
            // $fixName = $data->id.'-'.$name.'.'.$requestFile->extension();

            $fixName = time().'-'.$name.'.'.$requestFile->extension();
            if ($requestFile) {
                $url=  Storage::putFileAs($dir, $requestFile, $fixName);
                $request->image = $fixName;
            }
            return $url;
        } catch (\Throwable $th) {
            report($th);
            return $th->getMessage();
        }
    }


    public function uploadPhoto($request, $data, $name)
    {
        try {
            $dir = 'public/images/'.$name;
            $fixName = time().'-'.$name.'.'.$request->file('image')->extension();

            if ($request->file('image')) {
                Storage::putFileAs($dir, $request->file('image'), $fixName);
                $request->image = $fixName;

                $data->update([
                    'image' => $request->image,
                ]);
            }
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }


    // use Validator; // Import the Validator facade if not already imported

    // // ...




    public function uploadMultiImage($request, $data, $name, $inputName = 'images')
    {
        // Ensure the request has the files for the given input name
        // if (!$request->hasFile($inputName)) {
        //     return ['status' => 'Error', 'message' => 'No files found for the input name: ' . $inputName];
        // }

        $requestFiles = $request->file($inputName);

        // Check if the input is an array
        // var_dump($requestFiles);
        if (!is_array($requestFiles)) {
            return ['status' => 'Error', 'message' => 'The input must be an array of files for: ' . $inputName];
        }

        $uploadedImages = [];

        foreach ($requestFiles as $file) {
            $dir = 'images/' . $name;
            $fixName = $data->id . '-' . $name . '_'  . $file->getClientOriginalExtension();

            if ($file) {
                Storage::putFileAs($dir, $file, $fixName);
                $uploadedImages[] = [
                    'url' => $dir . '/' . $fixName,
                ];
            }
        }

        // Return array of uploaded images URLs
        return $uploadedImages;
    }
    public function storeImage(UploadedFile $file, $folder)
    {
        $path = $file->store($folder, 'public');

        return $path;
    }
    public function updateImage(UploadedFile $file, $folder, $currentImagePath = null)
    {
        // حذف الصورة الحالية إذا تم تمرير مسارها
        if (!is_null($currentImagePath)) {
            Storage::disk('public')->delete($currentImagePath);
        }

        // تحميل الصورة الجديدة وتخزينها في المجلد العام
        $path = $file->store($folder, 'public');

        return $path;
    }
}
