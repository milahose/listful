<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$item = Item::all()->toJson();
		return $item;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
    {
		$this->validate($request, [
			'name' => 'required'
		]);

		$item = new Item;
		$item->name = $request->name;
		$item->save();

		return $item;
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
		if (!Item::find($itemId)) {
			return [
				'message'=>'Not Found', 
				'error'=>[
					'status' => 404
				]
			];
		} else {
			return Item::find($itemId);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
		$item = Item::find($itemId);
		$item->name = $request->name;
		$item->checked = $request->checked;	
		$item->save();
		return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
		if (Item::destroy($itemId)) {
			return [
				'message' => 'success', 
				'status' => 204
			];
		}
	}
}
