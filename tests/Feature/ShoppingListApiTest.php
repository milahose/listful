<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingListApiTest extends TestCase
{
   public function testFetchesAllShoppingListItems()
    {
		// $items = $this->call('GET', '/api/items');
        // $result = $this->parseJson($response);
        // $this->assertIsJson($data);
		// $this->assertInternalType('array', $data->photos);
		
		// $response = $this->call('GET', '/api/items');
		// var_dump($response);
		// $this->get('/api/items')
		// 	->assertStatus(200) ;

		$response = $this->call('GET', '/api/items');
			

		// $items = Item::all()->toJson();
		// $this->get('/api/items')
		// 	->assertStatus(200);
	}
}
