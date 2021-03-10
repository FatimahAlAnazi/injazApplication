<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()     //not exist
    // {
    //     $this->middleware('guest');
    // }
    //send case success
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message'=> trans($response)]);

    }

//send case fail

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['error'=> trans($response)], 422);

    }

    //------------------------------------------------------------------------------------------------
    //for G groupe


    public function sendResponse($result, $message){

        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }


    public function sendError($error, $errormessage= [], $code=404){

        $response = [
            'success' => false,
            'message' => $error
        ];

        if(!empty($errormessage))
        { $response['data'] = $errormessage;}
        return response()->json($response, $code);
    }

      //for grope G
      /*
      protected function sendResetLinkResponseG(Request $request, $response)
      {
        $tokenFromEmail['token'] = $request->token;
        return $this->sendResponse($tokenFromEmail, ['message'=> trans($response)]);
      }
*/

      protected function sendResetLinkResponseG(Request $request, $response)
      {
        //$token = $request->route()->parameter('token');
        $token_reset = DB::table('password_resets')->where('email', $request->email)->first();
        $tokenFromEmail['token'] = $request->token;
        // $tokenFromEmail['token'] = $this->token;
        return $this->sendResponse($tokenFromEmail, ['message'=> trans($response)]);
      }

      protected function sendResetLinkFailedResponseG(Request $request, $response)
    {
        return $this->sendResponse(['error'=> trans($response)], 422);
    }

    public function sendResetLinkEmailG(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponseG($request, $response)
                    : $this->sendResetLinkFailedResponseG($request, $response);
    }
}
