<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($message,$data){
        /*
            data:les donnéés envoyer
            message: message de réussi
        */
        $reponse=[
            'success'=>true,
            'data'=>$data,
            'message'=>$message

        ];
        return Response()->json($reponse,200);
    }
    public function sendError($error,$errorMessage=[]){
         /*
            error:array message for fail
            errorMessage: message de error
        */
        $reponse=[
            'success'=>false,
            'data'=>$error,
        ];
        if(!empty($message)){
            $reponse['data']=$errorMessage;
        }
        return Response()->json($reponse,404);
    }


}
