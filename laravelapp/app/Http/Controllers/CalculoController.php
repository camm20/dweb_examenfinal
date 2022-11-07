<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Calculo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CalculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calculos = Calculo::all();
        return response()->json($calculos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$rules = [
            'user_id' => 'required'
        ];
        $messages = [
            'required' => 'El campo :attribute es obligatorio.'
        ];

        //$calculo = $request->input('vi') - ($request->input('a') * $request->input('t'));
        //$request->mergeIfMissing(['vf' => $calculo]);

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'message' => "Información incompleta o inválida -> ".$validator->messages()->first()
            ], 400);
        }
        $calculo = Calculo::create($request->all());*/

        $validator = Validator::make($request->all(), [
            'vf' => 'required|integer',
            'a' => 'required|integer',
            't' => 'required|integer',
            'vi' => 'nullable|integer',
            'user_id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $calculoBack = $request->input('vf') - ($request->input('a') * $request->input('t'));
        $request->merge(['vi' => $calculoBack]);

        $user = User::where('id', $request->user_id)->first();

        Calculo::create([
            'user_id' => $user->id,
            'vf' => $request->vf,
            'a' => $request->a,
            't' => $request->t,
            'vi' => $request->vi,
        ]);

        return response()->json([
            'message' => "Calculo saved successfully!",
            'calculo' => $request->input('vi')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calculo  $calculo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$calculo = Calculo::find($id);
        $calculo = DB::select('SELECT count(*) AS marcajes FROM marcajes WHERE user_id = :uid AND created_at >= CURDATE();', ['uid' => $id]);
        return response()->json($calculo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calculo  $calculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calculo $calculo)
    {
        $calculo->update($request->all());

        return response()->json([
            'message' => "Marcaje updated successfully!",
            'marcaje' => $calculo
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marcaje  $marcaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marcaje $marcaje)
    {
        $marcaje->delete();

        return response()->json([
            'message' => "Marcaje deleted successfully!",
        ], 200);
    }
}
