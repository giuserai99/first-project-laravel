<?php

namespace App\Services;

use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMailJob;
use App\Models\Mail;
use App\DTO\CreateMailDTO;
use App\DTO\UpdateMailDTO;
use App\Models\Address;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MailService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * Funzione che crea una nuova mail e associa degli addresses.
     * Infine dispatch SendMailJob
     *
     * @param CreateMailDTO $data
     * @return Mail
     */
    public function send(CreateMailDTO $data): Mail
    {
        $mail = DB::transaction(function () use ($data) {
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

            return $mail;
        });


        $sendMailJob = new SendMailJob($mail->id);
        dispatch($sendMailJob);

        return $mail;
    }

    /**
     * Funzione che ritorna tutte le mails
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Mail::all();
    }

    /**
     * Funzione che ritorna una mail singola
     *
     * @param integer $id
     * @return Mail
     */
    public function getOne(int $id): Mail
    {
        return Mail::findOrFail($id);
    }

    /**
     * Funzione che elimina una mail
     *
     * @param Mail $mail
     * @return void
     */
    public function deleteOne(int $id): void
    {
        $mail = Mail::FindOrFail($id);
        $mail->delete();
    }

    /**
     * Funzione che aggiorna una mail
     *
     * @param UpdateMailDTO $data
     * @return void
     */
    public function updateOne(UpdateMailDTO $data): void
    {
        $mailUpdate = Mail::where('id', $data->id)->update([
            'subject' => $data->subject,
            'body' => $data->body
        ]);
    }
}
