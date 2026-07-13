<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Contact as ContactFormModel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendNotificationToAdmin(array $parameter)
    {
        $customer = customer();
        if ( ! $customer->admin ) {
            return false;
        }

        return $customer->admin->sendCustomerActivityToAdmin($parameter);
    }

    protected static function doUpload($name, $imageKey) {
        $file = request()->file( $imageKey );

        $uri = $name . '.' . $file->extension();
        $file->move(public_path(static::UPLOAD_DIRECTORY), $uri);

        return $uri;
    }


    protected static function get_contact()
    {
        $admin = admin();

        $contacts = null;
        if ( $admin->isSuper() ) {
            $contacts = ContactFormModel::where(function ($query) use ($admin) {
                $query->whereNull('admin_id')->orWhere('admin_id', $admin->id);
            });
        } else {
            $contacts = $admin->contacts();
        }

        return $contacts->whereStatus('failed');
    }
}
