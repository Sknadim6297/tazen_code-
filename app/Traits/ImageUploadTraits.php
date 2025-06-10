<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


trait ImageUploadTraits
{

  public function uploadImage(Request $request, $inputName, $path)
  {
    if ($request->hasFile($inputName)) {
      $image = $request->file($inputName);
      $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
      
      // Store the image in the specified path
      $path = $image->storeAs($path, $imageName, 'public');
      
      return $path;
    }
    return null;
  }
  // Upload Multipal Image Upload
  public function uploadMultipleImage(Request $request, $inputName, $path)
  {
    if ($request->hasFile($inputName)) {
      $imagePaths = [];
      $images = $request->file($inputName);
      
      foreach ($images as $image) {
        $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs($path, $imageName, 'public');
        $imagePaths[] = $imagePath;
      }
      
      return $imagePaths;
    }
    return [];
  }

  // Function For Edit Image And Old Image Delete

  public function updateImage(Request $request, $inputName, $path, $oldPath = null)
  {
    if ($request->hasFile($inputName)) {
      // Delete old image if exists
      if ($oldPath && Storage::exists($oldPath)) {
        Storage::delete($oldPath);
      }

      $image = $request->file($inputName);
      $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
      
      // Store the new image
      $path = $image->storeAs($path, $imageName, 'public');
      
      return $path;
    }
    return $oldPath;
  }

  // Delete Image
  public function deleteImage(string $path)
  {
    if (Storage::exists($path)) {
      Storage::delete($path);
    }
  }
}
