<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMailJob;
use App\Models\Address;
use App\Services\MailService;
use Illuminate\Http\Request;
use App\DTO\CreateMailDTO;
use App\DTO\UpdateMailDTO;
use App\Models\Mail;

class MailController extends Controller
{

    public function __construct(private MailService $mailService) {}


    public function sendMail(SendMailRequest $request){

        $mailDTO = new CreateMailDTO(
            $request->input('emailsTo'),
            $request->input('subject'),
            $request->input('body')
        );

        $mail = $this->mailService->send($mailDTO);
        
        return response()->json($mail,201);
    }

    public function showAllMail() {
        return $this->mailService->showAllMail();
    }

    public function getMail(int $id){
        return $this->mailService->getMail($id);
    }

    public function deleteMail(int $id){
        return $this->mailService->deleteMail($id);
    }

    public function updateMail(int $id, Request $request){
        $mailDTO = new UpdateMailDTO(
            $request->input('subject'),
            $request->input('body')
        );
        return $this->mailService->updateMail($id,$mailDTO);
    }


}
