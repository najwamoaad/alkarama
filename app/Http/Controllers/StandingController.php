<?php

namespace App\Http\Controllers;
use App\Http\Resources\StandingResource;
use App\Models\Standing;
use App\Models\Club;
use App\Models\Seasone;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
class StandingController extends Controller
{use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {try{$s=Seasone::where('name',$request->name)->value('id');
        $standings = Standing::with('club')->where('seasone_id', $s)->orderBy('points', 'asc')->get();
     


        $data['standings'] = StandingResource::collection($standings);

            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { try {
        $validator = Validator::make($request->all(), [
            'win' =>'required|integer',
           'lose'=>'required|integer',
           'draw'=>'required|integer',
           'plus'=>'required|integer',
           'play'=>'required|integer',
           'seasone_name'=>'required|string',
           'club_name'=>'required|string',
          

            
        ]);
        $clubName = $request->input('club_name');
        $seasoneName = $request->input('seasone_name');
       
        $club = Club::where('name', $clubName)->first();
        $Seasone = Seasone::where('name', $seasoneName)->first();
        if((!$club||!$Seasone)){
               
            $data['message'] = 'club || Seasone not found';
            return $this->apiResponse($data, true, null, 200);
        }
        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        
             
            $Standing=Standing::create([
                'uuid'=>Str::uuid(),
                'win'=>$request->win,
                'lose'=>$request->lose,
              
                'draw'=> $request->draw,
                'plus'=>$request->plus,
                'play'=>$request->play,
                'seasone_id'=>$Seasone->id,
                'club_id'=>$club->id
                
            ]) ;
        
           
         
            $data['Standing'] = new StandingResource($Standing);

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
    {
        try {
            $validator = Validator::make($request->all(), [
                'win' =>'required|integer',
               'lose'=>'required|integer',
               'draw'=>'required|integer',
               'plus'=>'required|integer',
               'play'=>'required|integer',
               'seasone_name'=>'required|string',
               'club_name'=>'required|string',
              
    
                
            ]);
            $Standing = Standing::where('uuid',$request->uuid)->firstOrFail();
            $clubName = $request->input('club_name');
            $seasoneName = $request->input('seasone_name');
           
            $club = Club::where('name', $clubName)->first();
            $Seasone = Seasone::where('name', $seasoneName)->first();
            if((!$club||!$Seasone)){
                   
                $data['message'] = 'club || Seasone not found';
                return $this->apiResponse($data, true, null, 200);
            }
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            
                 
                $Standing->update([
                     
                    'win'=>$request->win,
                    'lose'=>$request->lose,
                  
                    'draw'=> $request->draw,
                    'plus'=>$request->plus,
                    'play'=>$request->play,
                    'seasone_id'=>$Seasone->id,
                    'club_id'=>$club->id
                    
                ]) ;
            
               
             
                $data['Standing'] = new StandingResource($Standing);
    
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
