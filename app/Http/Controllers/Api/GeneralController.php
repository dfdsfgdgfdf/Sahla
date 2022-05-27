<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppStartPageResource;
use App\Models\AppStartPage;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;



class GeneralController extends Controller
{
    use GeneralTrait;

    public function appStartPages(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,th',
        ]);

        $pages = AppStartPage::whereStatus(1)->get();
        return $this->successMessage(AppStartPageResource::collection($pages), 'App Start Pages');
    }

}
