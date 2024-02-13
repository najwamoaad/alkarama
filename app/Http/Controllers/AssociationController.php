<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader1;
use App\Http\Resources\AssociationRessource;
use App\Http\Resources\AssociationCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Models\association;

class AssociationController extends Controller
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
            $association = association::all();
          
            if ( $association->isEmpty()) {
                $data['message'] = 'No association found';
                return $this->apiResponse($data, true, null, 200);
            }
             
            $data['association']= AssociationRessource::collection($association);
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
        
         try{
            $association = association::where('uuid',$request->uuid)->first();
           
        if (!$association) {
            $data['message'] = 'No association found';
            return $this->apiResponse($data, true, null, 200);
        }
       //  $mm = $association->informvideo()->get();
      
       $data['association'] =[
        'boss' => $association->boss,
        'image' => $association->image,
        'description' => $association->description,
        'videoAssociation' => $association->informvideo()->get(['url', 'description']),];
        //      $data['association'] =new AssociationRessource($association);
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
