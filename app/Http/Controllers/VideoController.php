<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use App\Http\Traits\FileUploader1;
use App\Http\Traits\GeneralTrait;
use  App\Http\Resources\videoRessource;
use  App\Http\Resources\VideoCollection;
use App\Models\Video;
class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {try {
       // $video = Video::where('type',$request->type)->firstOrFail();
       $Video = Video::all();
        if (!$video) {
            return $this->notFoundResponse('video not found');
        }

        $data['video']= new videoRessource($video);
        return $this->apiResponse($data,true,null,200);

    } catch (\Exception $ex) {
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
        $Video = Video::where('uuid',$request->uuid)->firstOrFail();
        try{
        
        if (!$Video) {
            $data['message'] = 'No Video found';
            return $this->apiResponse($data, true, null, 200);
        }
         
        $data['Video'] =new videoRessource($Video);
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
