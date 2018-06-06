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
    public function index()
    {
        return Item::all();
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
        return Item::find($itemId);
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
		
		if ($request->name) {
			$item->name = $request->name;
		} else {
			if ($item->checked) {
				$item->checked = false;
			} else {
				$item->checked = true;
			}
		}

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
				'message'=>'success', 
				'status'=>204
			];
		};
    }
}
