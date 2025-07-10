<?php

namespace App\Observers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserObserver
{
    /**
     * Handle the User "deleting" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        if ($user->image_url) {
            // Extract public_id from the image_url
            $pattern = '/users\/([^\.\/]+)\./';
            if (preg_match($pattern, $user->image_url, $matches)) {
                $publicId = 'users/' . $matches[1];
                try {
                    Cloudinary::destroy($publicId);
                } catch (\Exception $e) {
                    // Log or handle error if needed
                }
            }
        }
    }
}
