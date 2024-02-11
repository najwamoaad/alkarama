<?php

namespace App\Http\Controllers;
use App\Http\Resources\StandingResource;
use App\Models\Standing;
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
    public function index()
    {try{
        $standings = Standing::with('club')->get();
       
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
    {
        $validator = Validator::make($request->all(), [
            'win' =>'required|integer',
           'lose'=>'required|integer',
           'draw'=>'required|integer',
           'plus'=>'required|integer',
           'play'=>'required|integer',
           'seasone_id'=>'required|string|exists:seasones,id',
           'club_id'=>'required|string|exists:clubs,id',
          

            
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
             
            $Standing=Standing::create([
                'uuid'=>Str::uuid(),
                'win'=>$request->win,
                'lose'=>$request->lose,
              
                'draw'=> $request->draw,
                'plus'=>$request->plus,
                'play'=>$request->play,
                'seasone_id'=>$request->seasone_id,
                'club_id'=>$request->club_id
                
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
}
