<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Models\{
    CaseNotification
};

class MailController extends Controller
{
    

    public function send_email_notification(Request $request) {
        try {
            $case_id = $request->case_id;
            $step_id = $request->step_id;

            $cases = DB::table('cases as c')
                        ->selectRaw('c.*, h.name AS handler_name, h.email, s.id AS step_id, s.name AS current_step, cs.id as case_step_id, cs.completion_date')
                        ->join('handlers as h', 'h.id', 'c.handler_id')
                        ->join('case_step as cs', function($cases){
                            $cases->whereRaw('cs.step_id = c.step_id')
                                  ->whereRaw('cs.case_id = c.id');
                        })
                        ->join('steps as s', 's.id', 'c.step_id')
                        ->where('cs.id', $step_id)
                        ->where('c.id', $case_id)
                        ->first();

            $to_name  = $cases->handler_name;
            $to_email = $cases->email; //'ranjay@nexbridgetech.com';  

            $data = [
                'case_type' => $cases->case_type,
                'case_no'   => $cases->case_no,
                'step'      => $cases->current_step,
                'due_date'  => date('F d, Y  - l', strtotime($cases->completion_date)),
                'handler'   => $cases->handler_name
            ];  

            $email_subject = 'NOTIFICATION FOR CASE '.$cases->case_no;

            Mail::send('emails.handler_notif_template', $data, function($message) use ($to_name, $to_email, $email_subject) {
                $message->to($to_email, $to_name)
                ->subject($email_subject);
                $message->from('noreply.hsac@gmail.com', 'HSAC Admin');
            });


            if (Mail::failures()) {
                return myReturn('error', 'Message not Delivered');
            }else{
                
                CaseNotification::firstOrCreate([
                    'case_id' => $case_id,
                    'step_id' => $cases->case_step_id
                ],[
                    'date_notified' => date('Y-m-d')
                ]);

                return myReturn('success', 'Email sent');
            }

        } catch (\Throwable $th) {
           return myReturn('error', $th->getMessage());
        }

   }
}
