<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingListApiTest extends TestCase
{
   public function testFetchesAllShoppingListItems()
    {
		$response = $this->get('/api/items')->assertStatus(200)->getContent();
	}
}
