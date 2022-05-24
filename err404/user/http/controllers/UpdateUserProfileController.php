<?php

namespace Err404\User\Http\Controllers;

use Err404\User\Classes\UserHook;
use Illuminate\Support\Facades\Event;
use Err404\User\Facades\JWTAuth;

class UpdateUserProfileController extends UserController
{

    protected function parsePostData( $data )
    {
        if ( !@$data['password'] ) unset ($data['password'], $data['password_confirmation']);

        $data['name'] = $data['firstName'];

        $data['surname'] = $data['lastName'];

        $data['street_addr'] = "{$data['address']}";

        if (@$data['additionAddress'])
            $data['street_addr'] .= " | {$data['additionAddress']}";

        $data['zip'] = $data['zipCode'];

        $data['shipAddress'] = "{$data['shipAddress']}";
        if (@$data['shipAdditionAddress'])
            $data['shipAddress'] .= " | {$data['shipAdditionAddress']}";
        $data['ship_country'] = $data['shipCountry'];

        // remove unnecesary
        unset(
            $data['firstName'],
            $data['lastName'],
            $data['address'],
            $data['additionAddress'],
            $data['zipCode'],
            $data['shipAdditionAddress'],
            $data['shipCountry']
        );

        return $data;
    }

    public function handle()
    {

        if (!$user = JWTAuth::getUser()) {
            return;
        }

        $data = $this->parsePostData(post());

        if (\Input::hasFile('avatar')) {
            $user->avatar = \Input::file('avatar');
        }

        Event::fire('Err404.user.beforeSaveUserData', [$user]);

        $user->fill($data);
        $user->save();

        $response = [
            'success' => true
        ];

        return $afterProcess = UserHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'data'   => $response,
                'status' => 200,
            ], 200);
        });
    }
}
