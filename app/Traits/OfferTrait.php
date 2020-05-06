<?php

namespace App\Traits;

trait OfferTrait
{
    function saveImage($photo, $folder)
    {
        $file_extension = $photo->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $photo->move($folder, $file_name);
        return $file_name;
    }
}
