<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMailJob;
use App\Models\Address;
use App\Services\MailService;
use Illuminate\Http\Request;
use App\DTO\CreateMailDTO;
use App\DTO\UpdateMailDTO;
use App\Http\Requests\UpdateMailRequest;
use App\Http\Resources\MailCollection;
use App\Http\Resources\MailResource;
use App\Http\Resources\MailResourceCollection;
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

    public function getAll()
    {
        return new MailResourceCollection($this->mailService->getAll());
    }

    public function getMail(int $id)
    {
        return new MailResource($this->mailService->getOne($id));
    }

    public function deleteMail(int $id)
    {
        $this->mailService->deleteOne($id);
        return response()->noContent();
    }

    public function updateMail(UpdateMailRequest $request)
    {
        $mailDTO = new UpdateMailDTO(
            $request->route('id'),
            $request->input('subject'),
            $request->input('body')
        );
        $this->mailService->updateOne($mailDTO);
        return response()->noContent();
    }
}
