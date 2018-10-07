<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages;
use App\Http\Resources\MessagesResource;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Messages::orderBy('created_at', 'DESC')->paginate(2);

        //Return collection of messages as resource
        return MessagesResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = ($request->id) ? Messages::findOrFail($request->id) : new Messages;

        $message->message    = $request->message;
        $message->created_at = Carbon::now();

        if($message->save()){
            return new MessagesResource($message);
        } else {
            return 'error';
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
        $message = Messages::findOrFail($id);
        return new MessagesResource($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Messages::findOrFail($id);
        if($message->delete()){
            return new MessagesResource($message);
        }
    }
}
