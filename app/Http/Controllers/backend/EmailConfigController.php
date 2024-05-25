<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\frontend\Ideas;
use App\Models\backend\Company;
use App\Models\backend\Location;
use App\Models\frontend\Feedback;
use App\Models\frontend\EmailConfig;
use App\Models\frontend\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\frontend\IdeaRevision;

class EmailConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $emails = EmailConfig::orderBy('email_config_id', 'DESC')->get();
        return view('backend.email_config.index', compact('emails'));
    }


    public function update(Request $request)
    {
        $emails_update = array();
        $data = array();
        // dd($request->all());
        $emails_update_counter = 0;
        for ($i = 0; $i < sizeof($request->email_config_id_arr); $i++) {
            $data = EmailConfig::where('email_config_id', $request->email_config_id_arr[$i])->get();
            if (count($data) > 0) {
                $email_config = EmailConfig::where('email_config_id', $request->email_config_id_arr[$i])->first();
                $data['team_name'] = $email_config->team;
                $data['old_emails'] = $email_config->emails;
                $email_config->emails = $request->emails_arr[$i];
                // dump($data['old_emails']);
                if ($email_config->save()) {
                    if ($data['old_emails'] == $email_config->emails) {
                        $data['updated'] = 0;
                    } else {
                        $data['updated'] = 1;
                    }
                    $emails_update_counter++;
                    $data['new_emails'] = $email_config->emails;
                } else {
                    return redirect('/admin/email_config')->with('error', 'Failed to update Emails');
                }
            }
            array_push($emails_update, $data);
        }
        $log_description = '';
        foreach (collect($emails_update) as $email_update) {
            if ($email_update['updated'] == 1) {
                // dump($email_update['team_name']);
                $log_description .= $email_update['team_name'] . ' : ' . $email_update['old_emails'] . ' to ' . $email_update['new_emails'] . ', ';
            }
        }
        // dd($log_description);
        if ($emails_update_counter > 0) {
            // Activity Log
            $log_description = trim($log_description, ', ');
            if($log_description) {
                $log = ['module' => 'Activity_log', 'action' => 'Email Config Updated', 'description' => 'Emails configured : ' . $log_description];
                captureActivity($log);
            }

            return redirect('/admin/email_config')->with('success',  $emails_update_counter . ' Email(s) Has Been Updated');
        } else {
            return redirect('/admin/email_config')->with('error', 'Failed to update Emails');
        }
    }
}
