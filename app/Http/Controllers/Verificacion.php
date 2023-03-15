<?php

namespace App\Http\Controllers;

use App\Mail\verifiactionMail;
use Illuminate\Http\Request;
use App\Models\code;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class Verificacion extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function verificacion(Request $request)
    {
        $codigoLog  = strval(mt_rand(100000, 999999));
        $codigoApp = strval(mt_rand(100000, 999999));

        $codigo = new code();
        $codigo->codeLog = Crypt::encryptString($codigoLog);
        $codigo->AppCode = Crypt::encryptString($codigoApp);
        $codigo->ID_user = Auth::user()->id;
        $codigo->save();

        $url_firmada = URL::temporarySignedRoute(
            'mostrar', now()->addMinutes(30), Auth::user()->id
        );
        $mail = new verifiactionMail($url_firmada);
        Mail::to(Auth::user()->email)
            ->send($mail);

        return view('verificacion');

    }
 
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $codigo = code::where('ID_user', Auth::user()->id)
            ->where('status',true)
            ->first();
        // error_log($codigo);
        return view('mail.show_code', ['codigo'=>Crypt::decryptString($codigo->AppCode)]);
    }
    
    public function validar_app(Request $request){
        $codigin = $request->input('Codigo_APP');
        $codigos = code::where('status',true)
            ->get();
        foreach ($codigos as $codigo) {
            if(Crypt::decryptString($codigo->AppCode)==$codigin){
                return response()->json([
                    'codigo'=> Crypt::decryptString($codigo->codeLog)
                ],201);
            }
        } 
        return response()->json([
            'mensaje'=> 'Codigo incorrecto'
        ],400);
        // error_log($codigo)
    }
    
    public function validar_login(Request $request){
        $codigin = $request->input('codigo');
        $codigos = code::where('ID_user', Auth::user()->id)
            ->where('status',true)
            ->get();
        foreach ($codigos as $codigo) {
            if(Crypt::decryptString($codigo->codeLog)==$codigin){
                $codigos = code::find($codigo->id);
                $codigos->status=false;
                $codigos->save();
                Session::put('code', $codigo->codeLog);
                return redirect('dashboard');
            }
        } 
        return redirect('verificacion');
        response()->json([
            'mensaje'=> 'Codigo incorrecto'
        ],400);
        ;
        
        error_log($codigo);
    }

}
