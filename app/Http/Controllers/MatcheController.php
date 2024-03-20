<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Club;
use App\Models\Seasone;
use App\Http\Resources\MetcheResource;
use App\Http\Resources\MatchWithStateResource;
use App\Http\Resources\MatchWithStateCollection;
use App\Http\Resources\MatchWithLiveResource;
use App\Http\Resources\MatchWithLiveCollection;
use App\Http\Resources\UpcomingMatchResource;
use App\Http\Resources\UpcomingMatchCollection;
use App\Http\Resources\PlayerWithInfoResource;
use App\Http\Resources\MetcheViewResourceResource;
use App\Http\Resources\MatchWithReplecmentResource;
 
use Carbon\Carbon;
 
 
use App\Http\Resources\MetcheCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
 
class MatcheController extends Controller
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
    {    try {
        $validator = Validator::make($request->all(), [
            'datetime' =>'required',
           'status'=>'in:not_started,finished,life',
           'channel'=>'required|string',
           'round'=>'required',
           'play_ground'=>'required|string',
           'club1_name'=>'required|string',
           'club2_name'=>'required|string',
           'seasone_name'=>'required|string',
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        
            $clubName1 = $request->input('club1_name');
            $clubName2 = $request->input('club2_name');
            $seasoneName = $request->input('seasone_name');
           
            $club1 = Club::where('name', $clubName1)->first();
            $club2 = Club::where('name', $clubName2)->first();
            $Seasone = Seasone::where('name', $seasoneName)->first();
            if((!$club1||!$Seasone||!$club2)){
                   
                $data['message'] = 'club || Seasone not found';
                return $this->apiResponse($data, true, null, 200);
            }
            $Matche=Matche::create([
                'uuid'=>Str::uuid(),
                'datetime'=>$request->datetime,
                'status'=>$request->status,
                'channel'=>$request->channel,
                'round'=>$request->round,
                'play_ground'=>$request->play_ground,
                
                'seasone_id'=>$Seasone->id,
                'club1_id'=>$club1->id,
                'club2_id'=>$club2->id
              
            ]);
        
        
         
            $data['Matche'] = new MetcheViewResourceResource($Matche);

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
                'datetime' =>'required',
               'status'=>'in:not_started,finished,life',
               'channel'=>'required|string',
               'round'=>'required',
               'play_ground'=>'required|string',
               'club1_name'=>'required|string',
               'club2_name'=>'required|string',
               'seasone_name'=>'required|string',
                
            ]);
    
            if ($validator->fails()) {
                return $this->requiredField($validator->errors()->first());
            }
    
            
                $clubName1 = $request->input('club1_name');
                $clubName2 = $request->input('club2_name');
                $seasoneName = $request->input('seasone_name');
               
                $club1 = Club::where('name', $clubName1)->first();
                $club2 = Club::where('name', $clubName2)->first();
                $Seasone = Seasone::where('name', $seasoneName)->first();
                $Matche = Matche::where('uuid',$request->uuid)->firstOrFail();
                if((!$club1||!$Seasone||!$club2)){
                       
                    $data['message'] = 'club || Seasone not found';
                    return $this->apiResponse($data, true, null, 200);
                }
                $Matche->update([
                  
                    'datetime'=>$request->datetime,
                    'status'=>$request->status,
                    'channel'=>$request->channel,
                    'round'=>$request->round,
                    'play_ground'=>$request->play_ground,
                    
                    'seasone_id'=>$Seasone->id,
                    'club1_id'=>$club1->id,
                    'club2_id'=>$club2->id
                  
                ]);
            
            
             
                $data['Matche'] = new MetcheViewResourceResource($Matche);
    
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
    public function showMatcheDatetime(Request $request)
    { try{
        $currentDateTime = date("Y-m-d H:i:s");
     //   $datetime=$request->datetime;
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('datetime',$request->datetime) ->where('datetime', '<=', $currentDateTime)->where('status',"finished")->first();
        

        
        
            if (!$Matche) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['Matche'] =new MetcheResource($Matche);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
    public function showMatcheStatus()
    { try{
        
       
      
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('status','not_started')
            ->where('datetime', '>=', Carbon::now())
            ->orderBy('datetime', 'asc')->get();
        
            
        
            if ($Matche->isEmpty()) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
            
             
            $data['Matche'] =MatchWithStateResource::collection($Matche);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    public function getDisplayedMatches()
    { try{
        
       
        $currentDateTime = date('Y-m-d H:i:s');
        $end_time = date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($currentDateTime)));
      
            $Matche = Matche::whereHas('club1', function ($query)  {
                $query->where('name',"الكرامة") ;})->where('status', 'life')
             
               -> where('datetime','<=',$currentDateTime) 
              ->orderBy('datetime', 'asc')->get();
          
            
   
            if (!$Matche) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['Matche'] = MatchWithLiveResource::collection($Matche);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
  
    public function getDisplayedMatchesLogoHalf()
    { try{
        
        $Mm = Matche::all();
        $m=$Mm->datetime;
        
        $currentDateTime = date('Y-m-d H:i:s');
    $end_time = date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($currentDateTime)));
  
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('status', 'life')
            -> where('datetime','<=',$currentDateTime)->get();
       //   ->whereBetween('datetime', [$m, $end_time])->get();
            
          
            
        
            if (!$Matche) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['Matche'] =UpcomingMatchResource::collection($Matche);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
    public function getDisplayedMatcheWithReplecment(Request $request)
    { try{
        
       
        $Matche = Matche::where('uuid',$request->uuid)->first();
            
        
            
       // $dade = Carbon::parse($Matche->datetime);
            if (!$Matche) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
            
                
           
         
          $data['Matche'] =  new MatchWithReplecmentResource($Matche);
            return $this->apiResponse($data, true, null, 200);
        
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
    
}
