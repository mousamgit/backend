<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function fetchUserProfile(Request $request){
        $authUser = $request->user();
        return (new UserProfileResource($authUser))
            ->response()
            ->setStatusCode(200);
    }
}
