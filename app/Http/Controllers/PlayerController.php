<?php

namespace App\Http\Controllers;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Sport;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\PlayerWithInfoResource;
use App\Http\Resources\PlayerWithInfoCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
class PlayerController extends Controller
{
    
    use GeneralTrait;
    use FileUploader1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { try {
        $player = Player::all();
      
        if ($player->isEmpty()) {
            $data['message'] = 'No player found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['player']= PlayerResource::collection($player);
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
    {  try {
        $validator = Validator::make($request->all(), [
            'name' =>'required|string|unique:players',
           'high'=>'required|integer',
           'play'=>'required|string',
           'from'=>'required|string',
           'number'=>'required|integer',
           'born'=>'required',
           'first_club'=>'required|string',
           'career'=>'required|string',
           'sport_name'=>'required|string',
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
        $sportName = $request->input('sport_name');
        $sport = Sport::where('name', $sportName)->first();
       
        if( (!$sport) ) {
           
            $data['message'] = 'Sport  not found';
            return $this->apiResponse($data, true, null, 200);
        }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'player_images';
                $Player=Player::create([
                'uuid'=>Str::uuid(),
                'name'=>$request->name,
                'high'=>$request->high,
                'play'=>$request->play,
                'number'=>$request->number,
                'born'=>$request->born,
                'from'=>$request->from,
                'first_club'=>$request->first_club,
                'career'=>$request->career,
                'image'=> $this->storeImage($file, $folder),
                'sport_id'=>$sport->id,
            ]);
        }
        
         
            $data['Player'] = new PlayerResource($Player);

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
    public function show(Request $request)
    { $Player = Player::where('uuid',$request->uuid)->firstOrFail();
        try{
        
        if (!$Player) {
            $data['message'] = 'No player found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['player'] =new PlayerResource($Player);
        return $this->apiResponse($data, true, null, 200);
    }
    catch (\Exception $ex) {
        return $this->apiResponse(null, false, $ex->getMessage(), 500);
    }
         
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
            $Player = Player::where('uuid',$request->uuid)->firstOrFail();
        $currentImagePath = $Player->image;
        $id = $Player->id;
        $validator = Validator::make($request->all(), [
            'name' =>'required|string|unique:players,name,' . $id,
           'high'=>'required|integer',
           'play'=>'required|string',
           'from'=>'required|string',
           'number'=>'required|integer',
           'born'=>'required',
           'first_club'=>'required|string',
           'career'=>'required|string',
           'sport_name'=>'required|string',
            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
         $sportName = $request->input('sport_name');
        $sport = Sport::where('name', $sportName)->first();
       
        if(  ( !$sport) ) {
           
            $data['message'] = 'Sport  not found';
            return $this->apiResponse($data, true, null, 200);
        }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'player_images';
            $Player->update([
                'name'=>$request->name,
                'high'=>$request->high,
                'play'=>$request->play,
                'number'=>$request->number,
                'born'=>$request->born,
                'from'=>$request->from,
                'first_club'=>$request->first_club,
                'career'=>$request->career,
                'image'=> $this->updateImage($file, $folder, $currentImagePath),
                'sport_id'=>$sport->id,
            ]);
        }
        
         
            $data['Player'] = new PlayerResource($Player);

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
    public function destroy(Request $request)
    {
        try
{      
    $Player = Player::where('uuid',$request->uuid)->firstOrFail();
     if (!$Player) {
        return $this->notFoundResponse('Player not found.');
    }
        $Player->delete();
        return $this->apiResponse([], true, null, 200);
}
catch (\Exception $ex) {
    return $this->apiResponse(null, false, $ex->getMessage(), 500);
} 
} 
public function PlayerWithInfo()
    { try {
        $player = Player::all();
      
        if ($player->isEmpty()) {
            $data['message'] = 'No player found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['player']= PlayerWithInfoResource::collection($player);
        return $this->apiResponse($data, true, null, 200);
    }
    catch (\Exception $ex) {
        return $this->apiResponse(null, false, $ex->getMessage(), 500);
    }
    }
}


