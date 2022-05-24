<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\RegistrationConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    public static function index($email)
    {

    Mail::to($email)->send(new RegistrationConfirmationMail());
    return 'A message has been sent to Mailtrap!';

    }
}
