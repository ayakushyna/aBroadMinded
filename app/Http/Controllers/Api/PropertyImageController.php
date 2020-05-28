<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyImageController
{
    public function store(Request $request)
    {
        $property_id = json_decode($request->property_id);
        $images = $request->images;


        if(isset($images))
        {
            foreach($images as $image)
            {
                $image_path = $image->storeAs(
                    'property_' . $property_id, time() . '_' . $image->getClientOriginalName(), 'public'
                );

                PropertyImage::create([
                    'image_path' =>  $image_path,
                    'property_id' => $property_id
                ]);
            }
        }


        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        $image = PropertyImage::find($id);

        if(Storage::disk('public')->exists($image->image_path))
        {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

    }
}
