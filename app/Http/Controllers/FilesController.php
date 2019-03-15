<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function base64Image(Request $request)
    {
        $this->validate($request, [
            'base64_image'    => 'required|string',
            'image_name'      => 'required|string|max:255',
        ]);

        // $maxSizeInKB          = env('FILE_UPLOAD_MAXSIZE');
        $allowedExtensions    = explode(",", env('FILE_UPLOAD_ALLOWED_EXT'));

        $imageType  = substr($request->input('base64_image'), 0, strpos($request->input('base64_image'), ',') + 1);
        $imageExt   = substr($imageType, strpos($imageType, '/')+1, strpos($imageType, ';') - strpos($imageType, '/') - 1);
        $base64Str  = substr($request->input('base64_image'), strpos($request->input('base64_image'), ',') + 1);
        $image      = base64_decode($base64Str);

        if (!$image) {
            return response()->json('not_proper_base64', 200);
        }

        // $sizeInKB = number_format(strlen($image) / 1024, 2);

        // if ($sizeInKB > $maxSizeInKB) {
        //     return response()->json('file_too_large', 400);
        // }

        if (!in_array($imageExt, $allowedExtensions)) {
            return response()->json('file_type_not_allowed', 400);
        }

        $user           = \Auth::user();
        $uuid           = \Uuid::generate()->string;
        $originalName   = empty($request->input('image_name')) ? $uuid : $request->input('image_name');
        $now            = \Carbon\Carbon::now()->format('Ymd-His');
        $fileName       = substr($uuid, 0, 8) . '_' . $now;
        $fileNameExt    = substr($uuid, 0, 8) . '_' . $now . '.' . $imageExt;
        $fullPath       = env('FILE_UPLOAD_PATH') . $fileName;

        \Storage::disk('file_upload_images')->put($fileNameExt, $image);

        $file = \App\File::create([
            'uuid'                  => $uuid,
            'original_name'         => $originalName,
            'original_extension'    => $imageExt,
            'name'                  => $fileName,
            'extension'             => $imageExt,
            'full_path'             => $fullPath,
            'user_id'               => $user->id
        ]);

        $file->save();

        return response()->json($file, 200);
    }

    public function imageUrl(Request $request)
    {
        $this->validate($request, [
            'image_url'     => 'required',
            'image_name'    => 'string|max:255'
        ]);

        $maxSizeInKB          = env('FILE_UPLOAD_MAXSIZE');
        $allowedExtensions    = explode(",", env('FILE_UPLOAD_ALLOWED_EXT'));

        $imageUrl      = $request->input('image_url');
        $base64Image   = file_get_contents($imageUrl);

        if ($base64Image) {
            $base64Image = 'data:image/png;base64,' . base64_encode($base64Image);
        }

        $imageType  = substr($base64Image, 0, strpos($base64Image, ',') + 1);
        $imageExt   = substr($imageType, strpos($imageType, '/') + 1, strpos($imageType, ';') - strpos($imageType, '/') - 1);
        $base64Str  = substr($base64Image, strpos($base64Image, ',')+1);
        $image      = base64_decode($base64Str);

        if (!$image) {
            return response()->json('not_proper_base64');
        }

        $sizeInKB = number_format(strlen($image) / 1024, 2);
        if ($sizeInKB > $maxSizeInKB) {
            return response()->json('file_too_large', 400);
        }

        if (!in_array($imageExt, $allowedExtensions)) {
            return response()->json('file_type_not_allowed', 400);
        }

        $user           = \Auth::user();
        $uuid           = \Uuid::generate()->string;
        $originalName   = empty($request->input('image_name')) ? $uuid : $request->input('image_name');
        $fileName       = substr($uuid, 0, 8) . '_' . \Carbon\Carbon::now()->format('Ymd-His') . '.' . $imageExt;
        $fullPath       = env('FILE_UPLOAD_PATH') . $fileName;

        \Storage::disk('file_upload_images')->put($fileName, $image);

        $file = \App\File::create([
            'uuid'                  => $uuid,
            'original_name'         => $originalName,
            'original_extension'    => $imageExt,
            'name'                  => $fileName,
            'extension'             => $originalExtension,
            'full_path'             => $fullPath,
            'user_id'               => $user->id
        ]);

        $file->save();
        
        return response()->json($file, 200);
    }

    public function imageFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image'
        ]);

        if (!$request->file('file')->isValid()) {
            return response()->json('invalid_file', 403);
        }

        $uploadedFile   = $request->file('file');

        $maxSizeInKB          = env('FILE_UPLOAD_MAXSIZE');
        $allowedExtensions    = explode(",", env('FILE_UPLOAD_ALLOWED_EXT'));

        $sizeInKB = number_format(filesize($uploadedFile) / 1024, 2);

        if ($sizeInKB > $maxSizeInKB) {
            return response()->json('file_too_large', 400);
        }

        $user               = \Auth::user();
        $uuid               = \Uuid::generate()->string;
        $originalName       = $uploadedFile->getClientOriginalName();
        $originalExtension  = $uploadedFile->getClientOriginalExtension();
        
        if (!in_array($originalExtension, $allowedExtensions)) {
            return response()->json('file_type_not_allowed', 400);
        }

        $fileName   = substr($uuid, 0, 8) . '_' . \Carbon\Carbon::now()->format('Ymd-His') . '.' . $originalExtension;
        $path       = env('FILE_UPLOAD_PATH') . '/images/';

        $uploadedFile->move($path, $fileName);

        $file = \App\File::create([
            'uuid'                  => $uuid,
            'original_name'         => $originalName,
            'original_extension'    => $originalExtension,
            'name'                  => $fileName,
            'extension'             => $originalExtension,
            'full_path'             => $path . $fileName,
            'user_id'               => $user->id
        ]);

        $file->save();

        return response()->json($file, 200);
    }
}
