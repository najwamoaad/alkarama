<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplacmentResource;
use App\Models\Replacment;
use App\Models\Matche;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;

class ReplacmentController extends Controller
{use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                
               'player1_name'=>'required|string',
               'player2_name'=>'required|string',
               'matche_datetime'=>'required',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            
                $player1Name = $request->input('player1_name');
                $player2Name = $request->input('player2_name');
                $matcheDatetime= $request->input('matche_datetime');
               
                $player1 = Player::where('name', $player1Name)->first();
                $player2 = Player::where('name', $player2Name)->first();
                $matche = Matche::where('datetime', $matcheDatetime)->first();
                if((!$player1||!$player2||!$matche)){
                       
                    $data['message'] = 'player || matche not found';
                    return $this->apiResponse($data, true, null, 200);
                }
                $Replacment=Replacment::create([
                    'uuid'=>Str::uuid(),
                
                    'matche_id'=>$matche->id,
                    'inplayer_id'=>$player1->id,
                    'outplayer_id'=>$player2->id
                  
                ]);
            
            
             
                $data['Replacment'] = new ReplacmentResource($Replacment);
    
                return $this->apiResponse($data, true, null, 200);
            }
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    { $Replacment = Replacment::where('uuid',$request->uuid)->firstOrFail();
        try {
            $validator = Validator::make($request->all(), [
                
               'player1_name'=>'required|string',
               'player2_name'=>'required|string',
               'matche_datetime'=>'required',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            
                $player1Name = $request->input('player1_name');
                $player2Name = $request->input('player2_name');
                $matcheDatetime= $request->input('matche_datetime');
               
                $player1 = Player::where('name', $player1Name)->first();
                $player2 = Player::where('name', $player2Name)->first();
                $matche = Matche::where('datetime', $matcheDatetime)->first();
                if((!$player1||!$player2||!$matche)){
                       
                    $data['message'] = 'player || matche not found';
                    return $this->apiResponse($data, true, null, 200);
                }
                $Replacment->update([
                
                
                    'matche_id'=>$matche->id,
                    'inplayer_id'=>$player1->id,
                    'outplayer_id'=>$player2->id
                  
                ]);
            
            
             
                $data['Replacment'] = new ReplacmentResource($Replacment);
    
                return $this->apiResponse($data, true, null, 200);
            }
            catch (\Exception $ex) {
                return $this->apiResponse(null, false, $ex->getMessage(), 500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
