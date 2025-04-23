<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


trait ImageUploadTraits
{

  public function uploadImage(Request $request, $inputName, $path)
  {
    if ($request->hasFile($inputName)) {

      $image = $request->{$inputName};
      $text = $image->getClientOriginalExtension();
      $imageName = 'media_' . uniqid() . '.' . $text;
      $image->move(public_path($path), $imageName);
      return $path . '/' . $imageName;
    }
  }
  // Upload Multipal Image Upload
  public function uploadMultipleImage(Request $request, $inputName, $path)
  {
    if ($request->hasFile($inputName)) {
      $imagePaths = [];
      $images = $request->{$inputName};
      foreach ($images as $image) {
        $text = $image->getClientOriginalExtension();
        $imageName = 'media_' . uniqid() . '.' . $text;
        $image->move(public_path($path), $imageName);
        $imagePaths[] = $path . '/' . $imageName;
      }
      return $imagePaths;
    }
  }

  // Function For Edit Image And Old Image Delete

  public function updateImage(Request $request, $inputName, $path, $oldPath = null)
  {
    if ($request->hasFile($inputName)) {

      if (File::exists(public_path($oldPath))) {
        File::delete(public_path($oldPath));
      }

      $image = $request->{$inputName};
      $text = $image->getClientOriginalExtension();
      $imageName = 'media_' . uniqid() . '.' . $text;
      $image->move(public_path($path), $imageName);
      return $path . '/' . $imageName;
    }
  }

  // Delete Image
  public function deleteImage(string $path)
  {
    if (File::exists(public_path($path))) {
      File::delete(public_path($path));
    }
  }
}
