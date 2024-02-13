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
        //
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
