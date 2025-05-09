<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMailJob;
use App\Models\Address;
use App\Services\MailService;
use Illuminate\Http\Request;
use App\DTO\CreateMailDTO;
use App\DTO\UpdateMailDTO;
use App\Http\Resources\MailCollection;
use App\Http\Resources\MailResource;
use App\Models\Mail;

class MailController extends Controller
{

    public function __construct(private MailService $mailService) {}


    public function sendMail(SendMailRequest $request)
    {

        $mailDTO = new CreateMailDTO(
            $request->input('emailsTo'),
            $request->input('subject'),
            $request->input('body')
        );

        return new MailResource($this->mailService->send($mailDTO));
    }

    public function showAllMail()
    {
        return new MailCollection($this->mailService->showAllMail());
    }

    public function getMail(int $id)
    {
        return new MailResource($this->mailService->getMail($id));
    }

    public function deleteMail(int $id)
    {

        $this->mailService->deleteMail(Mail::FindOrFail($id));
        return 'No content';
    }

    public function updateMail(int $id, Request $request)
    {
        $mailDTO = new UpdateMailDTO(
            $id = $id,
            $request->input('subject'),
            $request->input('body')
        );
        $this->mailService->updateMail($mailDTO);
        return 'Updated';
    }
}
