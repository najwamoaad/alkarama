<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\Information;
use App\Http\Resources\InformationResource;
use App\Http\Resources\InformationCollection;
class InformationController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        try {
            $information = Information::where('type',$request->type)->firstOrFail();

            if (!$information) {
                return $this->notFoundResponse('information not found');
            }

            $data['information']= new InformationResource($information);
            return $this->apiResponse($data,true,null,200);

        } catch (\Exception $ex) {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    { $Information = Information::where('uuid',$request->uuid)->firstOrFail();
        try{
        
        if (!$Information) {
            $data['message'] = 'No Information found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['player'] =new InformationResource($Information);
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
    public function destroy(Request $request)
    {
        try
{      
    $Information = Information::where('uuid',$request->uuid)->firstOrFail();
     if (!$Information) {
        return $this->notFoundResponse('Information not found.');
    }
        $Information->delete();
        return $this->apiResponse([], true, null, 200);
}
catch (\Exception $ex) {
    return $this->apiResponse(null, false, $ex->getMessage(), 500);
} 
    }
}
