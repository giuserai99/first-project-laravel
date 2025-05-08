<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class RabbitController extends Controller
{
    public function test(Request $request)
    {
        $request->validate([
            'address' => 'required',
        ]);

        $address = $request->input('address');

        // Su questa macchina
        // $sendMailJob = new SendMailJob($address);
        // dispatch($sendMailJob);

        return response()->json('Send', 200);

        // sul consumer
        //$job->handle();
    }
}
