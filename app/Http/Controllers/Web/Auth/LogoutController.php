<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploader;
use App\Traits\BaseValidator;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use BaseValidator;
    use ImageUploader;



    public function logout()
    {
        try {

            $user = Auth::user();
            if ($user) {
                Auth::logout();
                return redirect('/');
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), 500);
        }
    }
}