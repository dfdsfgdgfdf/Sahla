<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppStartPageResource;
use App\Http\Resources\UnitResource;
use App\Models\AppStartPage;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;



class GeneralController extends Controller
{
    use GeneralTrait;

    public function appStartPages(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $pages = AppStartPage::whereStatus(1)->get();
        return $this->successMessage(AppStartPageResource::collection($pages), 'App Start Pages');
    }

    public function getUnits(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $units = Unit::whereStatus(1)->get();
        return $this->successMessage(UnitResource::collection($units), 'App Start Pages');
    }

}
