<?php

namespace App\Http\Controllers;

use App\Mail\HtmlMail;
use App\Mail\MarkdownMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MailController extends Controller {


    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_to' => 'required|email',
            'type'    => 'required|in:"html","markdown"',
            'message' => 'string',
            'from'    => ['required', Rule::in(array_keys(config('addresses')))],
            'subject' => 'string|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);
        }

        $from = $request->input('from');

        if ($request->input('type') === 'markdown') {

            Mail::to($request->input('mail_to'))
                ->send(
                    new MarkdownMail(
                        $this->scriptStripper($request->input('message')),
                        $request->input('from'),
                        $request->input('subject')
                    ));

        } elseif ($request->input('type') === 'html'){

            Mail::to($request->input('mail_to'))
                ->send(new HtmlMail(
                    $request->input('message'),
                    $request->input('from'),
                    $request->input('subject')
                ));


        }
        
        return response()->json(['message' => 'Mail Send successfully']);
    }

    private function scriptStripper($input)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
    }

}
