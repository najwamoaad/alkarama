<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use App\Http\Resources\PlansRessource;
use App\Http\Resources\PlansCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use  App\Models\Plan;
use  App\Models\Matche;
use App\Models\Player;

use Illuminate\Http\Request;

class PlansController extends Controller
{use GeneralTrait;
    use FileUploader1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $plan = Plan::all();
          
            if ( $plan->isEmpty()) {
                $data['message'] = 'No plan found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['plan']= PlansRessource::collection($plan);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            
                'status'=>'in:main,beanch',
                'player_name' => 'required ',
                'matche_datetime'=>'required',
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $playerName = $request->input('player_name');
            $matcheDatetime= $request->input('matche_datetime');
            $player = Player ::where('name', $playerName)->first();
            $matche = Matche::where('datetime', $matcheDatetime)->first();
            
            if(  ( ! $player ||!$matche) ) {
               
                $data['message'] = 'player and matche  not found';
                return $this->apiResponse($data, true, null, 200);
            }
                
                $plan=Plan::create([
                 'uuid'=>Str::uuid(),   
                'status'=>$request->status,
                'player_id' =>$player->id,
                'matche_id'=>$matche->id,
                ]);
            
            $data['plan'] = new PlansRessource($plan);
            return $this->apiResponse($data, true, null, 200);    } 
        catch (\Exception $ex) 
        {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        } 
        
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
       
                $matchTime = $request->input('datetime');
 
                $match = Matche::where('datetime', $matchTime)->first();
                $plan = Plan::where('matche_id', $match->id)->get();
            if (!$plan) {
                $data['message'] = 'No plan found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['plan']= PlansRessource::collection($plan);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request )
    {
        try {
            $validator = Validator::make($request->all(), [
              
                'status'=>'in:main,beanch',
                'player_name' => 'required ',
                'match_datetime' => 'required '
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
            $playerName = $request->input('player_name');
            $match_datetime = $request->input('match_datetime');
            $player = Player ::where('name', $playerName)->first();
            $matche = Matche::where('datetime', $match_datetime)->first();
            $plan = Plan::where('uuid',$request->uuid)->firstOrFail();
            if(  ( ! $player ||!$matche) ) {
               
                $data['message'] = 'player and matche  not found';
                return $this->apiResponse($data, true, null, 200);
            }
                $plan->update([
                    'status'=>$request->status,
                    'player_id' =>$player->id,
                    'matche_id'=>$matche->id,
                ]);
            
            
             
                $data['plan'] = new PlansRessource($plan);
    
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
