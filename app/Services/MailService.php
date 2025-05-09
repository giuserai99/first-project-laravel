<?php

namespace App\Services;

use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMailJob;
use App\Models\Mail;
use App\DTO\CreateMailDTO;
use App\DTO\UpdateMailDTO;
use App\Models\Address;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MailService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function send(CreateMailDTO $data)
    {
        return DB::transaction(function () use ($data) {
            $mail = Mail::create([
                'subject' => $data->subject,
                'body' => $data->body
            ]);

            Address::insert(array_map(function ($email) use ($mail) {
                return [
                    'mail_id' => $mail->id,
                    'email_to' => $email,
                    'name' => ''
                ];
            }, $data->emailsTo));

            $sendMailJob = new SendMailJob($mail->id);
            dispatch($sendMailJob);

            return $mail;
        });
    }

    public function showAllMail()
    {
        $mails = Mail::all();

        if ($mails === null)
            return new Response('Mails not found', 404);
        return new Response($mails, 200);
    }

    public function getMail(int $id)
    {
        $mail = Mail::find($id);
        if ($mail === null)
            return new Response('Id not found', 404);

        // if ($mail->delete_at !== null)
        //     return new Response('Id not found', 404);
        return new Response($mail, 200);
    }

    public function deleteMail(int $id)
    {
        $mail = Mail::find($id);
        if ($mail === null)
            return new Response('Id not found', 404);

        // if ($mail->delete_at !== null)
        //     return new Response('Id not found', 404);
        Mail::destroy($id);
        return new Response('', 204);
    }

    public function updateMail(int $id, UpdateMailDTO $data)
    {
        $mail = Mail::find($id);
        if ($mail === null)
            return new Response('Id not found', 404);

        // if ($mail->delete_at !== null)
        //     return new Response('Id not found', 404);

        return DB::transaction(function () use ($id, $data) {
            Mail::where('id', $id)->update([
                'subject' => $data->subject,
                'body' => $data->body
            ]);
            return new Response('Updated', 200);
        });
    }
}
