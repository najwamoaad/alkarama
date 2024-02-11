<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Club;
use App\Http\Resources\MetcheResource;
use App\Http\Resources\MatchWithStateResource;
use App\Http\Resources\MatchWithStateCollection;
use App\Http\Resources\MatchWithLiveResource;
use App\Http\Resources\MatchWithLiveCollection;
use App\Http\Resources\UpcomingMatchResource;
use App\Http\Resources\UpcomingMatchCollection;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Alkoumi\LaravelHijriDate\Hijri;
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
    {
        $validator = Validator::make($request->all(), [
            'datetime' =>'required',
           'status'=>'required|string',
           'channel'=>'required|string',
           'round'=>'required',
           'play_ground'=>'required|string',
           'session_id'=>'required|string|exists:seasones,id',
           'club1_id'=>'required|string|exists:clubs,id',
           'club2_id'=>'required|string|exists:clubs,id',
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            
            $Matche=Matche::create([
                'uuid'=>Str::uuid(),
                'datetime'=>$request->datetime,
                'status'=>$request->status,
                'channel'=>$request->channel,
                'round'=>$request->round,
                'play_ground'=>$request->play_ground,
                'session_id'=>$request->session_id,
                'club1_id'=>$request->club1_id,
                'club2_id'=>$request->club2_id,
                 
              
            ]);
        
        
         
            $data['Matche'] = new MetcheResource($Matche);

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
    public function update(Request $request, $id)
    {
        //
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
        
        $datetime=$request->datetime;
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('datetime',$request->datetime)->where('status',"finished")->first();
        

        
        
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
            /* ->get(['datetime', 'status', 'play_ground', 'club1_id', 'club2_id'])
            ->map(function ($match) {
                $datetime = new Date($match->datetime);
                $match->day = Hijri::date('l', strtotime($datetime));
                $match->month = date('m/d', strtotime($datetime));
                $match->time =Hijri::date('h:i a', strtotime($datetime));
                unset($match->datetime);
                return $match;
            }); */
            
        
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
        
       
        $currentDateTime = Carbon::now();
        
       
   //     $threeHoursAgo = $currentDateTime->subHours(3);
        $threeHoursLater = $currentDateTime->addHours(3);
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('status', 'life')
            ->where('datetime', '>=', $currentDateTime)->get();
     
            /*  ->get(['datetime', 'status', 'play_ground', 'club1_id', 'club2_id'])
            ->map(function ($match) {
                $datetime = new Date($match->datetime);
                $match->day = Hijri::date('l', strtotime($datetime));
                $match->month = date('m/d', strtotime($datetime));
                $match->time =Hijri::date('h:i a', strtotime($datetime));
                $match->status = 'life';
                $club1 = Club::find($match->club1_id);
                $club2 = Club::find($match->club2_id);
                $match->club1_name = $club1->name;
                $match->club2_name = $club2->name;
                unset($match->club1_id);
                unset($match->club2_id);
                unset($match->datetime);
                return $match;
            });  */
            
        
            if (!$Matche) {
                $data['message'] = 'No Matche found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['Matche'] =MatchWithLiveResource::collection($Matche);
            return $this->apiResponse($data, true, null, 200);
        }
        catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
  
    public function getDisplayedMatchesLogoHalf()
    { try{
        
       
        $currentDateTime = Carbon::now();
        $threeHoursAgo = $currentDateTime->addHours(3);
        
      //  $threeHoursLater = $currentDateTime->addHours(3);
       
        $Matche = Matche::whereHas('club1', function ($query)  {
            $query->where('name',"الكرامة") ;})->where('status', 'life')
            ->where('datetime', '>=', $currentDateTime) ->orderBy('datetime')->get();
            
           /*  ->get(['datetime','status' ,'channel', 'play_ground', 'club1_id', 'club2_id'])
            ->map(function ($match) {
                $datetime = new Date($match->datetime);
                $match->day = Hijri::date('l', strtotime($datetime));
                $match->month = date('m/d', strtotime($datetime));
                $match->time =Hijri::date('h:i a', strtotime($datetime));
                
                $match->status = 'معروض مباشر';
                $match->is_first_half = false;
                $match->is_second_half = false;
                
                $club1 = Club::find($match->club1_id);
                $club2 = Club::find($match->club2_id);
                $match->club1_name = $club1->name;
                $match->club1_image = $club1->logo;
                $match->club2_name = $club2->name;
                $match->club2_image = $club2->logo;
                unset($match->club1_id);
                unset($match->club2_id);
                unset($match->datetime);
                $currentDateTime = Carbon::now();
                $matchTime = Carbon::parse($match->datetime);
        $diffInMinutes = $matchTime->diffInMinutes($currentDateTime);

            if ($diffInMinutes <= 45) {
                $match->is_first_half = true;
            } elseif ($diffInMinutes <= 105) {
                $match->is_second_half = true;
            } 
                return $match;
            }); */
            
        
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
    
}
