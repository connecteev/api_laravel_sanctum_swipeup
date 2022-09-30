<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\CollectionResource;

// Reference: https://codelapan.com/post/how-to-create-a-crud-rest-api-in-laravel-8-with-sanctum
class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // do not return all entries - security issue if a user can see *all* records
        // $data = Collection::latest()->get();

        // return all entries for this user only
        $loggedInUser = auth()->user();
        if (is_null($loggedInUser) || is_null($loggedInUser->id)) {
            return response()->json('Unauthenticated: loggedInUser not found', 404);
        }

        $data = Collection::where('user_id', $loggedInUser->id)->orderBy('id', 'ASC')->get();
        return response()->json(CollectionResource::collection($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loggedInUser = auth()->user();
        if (is_null($loggedInUser) || is_null($loggedInUser->id)) {
            return response()->json('Unauthenticated: loggedInUser not found', 404);
        }

        $validator = Validator::make($request->all(),[
            // 'user_id' => 'required',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Check if duplicate entry with the same name already exists for this user (okay to have duplicate names by other users)
        if (Collection::where([
            ['name', '=', $request->name],
            ['user_id', '=', $loggedInUser->id]
        ])->exists()) {
           // collection with same name already exists for this user
            return response()->json("A collection with the name '$request->name' already exists for this user", 404);
        }

        // if ($loggedInUser->id != $request->user_id) {
        //     return response()->json("Forbidden, user id # $request->user_id does not match with logged-in user with id: $loggedInUser->id", 403);
        // }

        $collection = Collection::create([
            'user_id' => $loggedInUser->id,
            'name' => $request->name
         ]);
        return response()->json(['Collection created successfully.', new CollectionResource($collection)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    // public function show(Collection $collection)
    // {
    //     //
    // }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loggedInUser = auth()->user();
        if (is_null($loggedInUser) || is_null($loggedInUser->id)) {
            return response()->json('Unauthenticated: loggedInUser not found', 404);
        }

        $collection = Collection::find($id);
        if (is_null($collection)) {
            return response()->json("Collection with id# $id not found", 404);
        }

        // check if the item belongs to this user who is currently logged in (with the bearer token)
        if ($loggedInUser->id != $collection->user_id) {
            return response()->json("Forbidden, item # $id does not belong to this user", 403);
        }
        return response()->json([new CollectionResource($collection)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    // public function edit(Collection $collection)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Collection $collection)
    // {
    //     // this version uses reflection
    //     return($collection);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $loggedInUser = auth()->user();
        if (is_null($loggedInUser) || is_null($loggedInUser->id)) {
            return response()->json('Unauthenticated: loggedInUser not found', 404);
        }

        // check if record exists with this id for the currently logged-in user
        $recordCheck = [
            ['id', '=', $id],
            ['user_id', '=', $loggedInUser->id],
        ];
        $collection = Collection::where($recordCheck)->first(); // model or null
        if (!$collection) {
            return response()->json("Collection with id# $id was not found or does not belong to this user", 404);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Don't allow duplicate entry with the same name for this user
        // Note: okay to have duplicate entries (with same name) for other users
        $duplicateQueryCheck = [
            ['name', '=', $request->name],
            ['user_id', '=', $loggedInUser->id],
            ['id', '!=', $collection->id]
        ];
        if (Collection::where($duplicateQueryCheck)->exists()) {
           // collection with same name already exists for this user
            return response()->json("A collection with the name '$request->name' already exists for this user", 404);
        }

        $collection->name = $request->name;
        $collection->save();
        return response()->json(['Collection updated successfully.', new CollectionResource($collection)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Collection $collection)
    // {
    //     // this version uses reflection
    //     $collection->delete();

    //     return response()->json('Collection deleted successfully');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedInUser = auth()->user();
        if (is_null($loggedInUser) || is_null($loggedInUser->id)) {
            return response()->json('Unauthenticated: loggedInUser not found', 404);
        }

        // check if record exists with this id for the currently logged-in user
        $recordCheck = [
            ['id', '=', $id],
            ['user_id', '=', $loggedInUser->id],
        ];
        $collection = Collection::where($recordCheck)->first(); // model or null
        if (!$collection) {
            return response()->json("Collection with id# $id was not found or does not belong to this user", 404);
        }

        // this version uses reflection
        $collection->delete();

        return response()->json('Collection deleted successfully');
    }

}
