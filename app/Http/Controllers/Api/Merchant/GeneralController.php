<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppStartPageResource;
use App\Http\Resources\EmailResource;
use App\Http\Resources\InformationResource;
use App\Http\Resources\PhoneResource;
use App\Http\Resources\SocialMediaResource;
use App\Http\Resources\UnitResource;
use App\Models\AppStartPage;
use App\Models\ContactMessage;
use App\Models\Email;
use App\Models\Information;
use App\Models\Phone;
use App\Models\SocialMedia;
use App\Models\Unit;
use App\Models\UserAddress;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;


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

    public function getPhones(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $phones = Phone::whereStatus(1)->get();
        return $this->successMessage(PhoneResource::collection($phones), 'App Phones');
    }

    public function getSocialMedia(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $socialMedias = SocialMedia::whereStatus(1)->get();
        return $this->successMessage(SocialMediaResource::collection($socialMedias), 'App Social Media');
    }

    public function getEmails(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $emails = Email::whereStatus(1)->get();
        return $this->successMessage(EmailResource::collection($emails), 'App Email');
    }

    public function sendContactMessage(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'message' => 'required|min:4|string',
        ]);

        try {
            $user = \auth()->user();
            $address = UserAddress::whereUserId(\auth()->id())->first();
            $input['name']          = $user->full_name;
            $input['company']       = $request->company;
            $input['email']        = $user->email;
            $input['mobile']        = $user->mobile;
            if (!empty($address)){
                $input['country_id']    = $address->country_id;
                $input['state_id']      = $address->state_id;
                $input['city_id']       = $address->city_id;
            }
            $input['subject']          = $request->subject;
            $input['message']          = $request->message;
            $input['status']          = '1';
            ContactMessage::create($input);
            return $this->returnSuccessMessage('Your Message Was Sent Successfully !');

        }catch (\Exception $e) {
            return $this->returnErrorMessage('Sorry! Please Try Again !', '422');

        }
    }

    public function getAboutUs(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $record = Information::whereType('About Us')->whereStatus(1)->first();
        return $this->successMessage(new InformationResource($record), 'About Us');
    }
    public function getPrivacy(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $record = Information::whereType('Privacy')->whereStatus(1)->first();
        return $this->successMessage(new InformationResource($record), 'Privacy');
    }
    public function getRule(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $record = Information::whereType('Rules')->whereStatus(1)->first();
        return $this->successMessage(new InformationResource($record), 'Rules && Conditions');
    }

}
