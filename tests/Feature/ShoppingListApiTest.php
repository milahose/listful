<?php

namespace Tests\Feature;

use \App\Item;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingListApiTest extends TestCase
{
	// use CreatesApplication, DatabaseMigrations;

    public function setUp()
    {
		parent::setUp();
		Artisan::call('migrate');
	}

	public function testDisplaysAllShoppingListItems()
    {
        factory(Item::class)->create([
            'name' => 'First Item'
        ]);

        factory(Item::class)->create([
            'name' => 'Second Item'
        ]);

        $response = $this->json('GET', '/api/items')
            ->assertStatus(200)
            ->assertJson([
                [ 'name' => 'First Item' ],
                [ 'name' => 'Second Item' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'checked', 'created_at', 'updated_at'],
            ]);
	}
	
	public function testDisplaysShoppingListItemById()
    {
        factory(Item::class)->create([
            'name' => 'First Item'
        ]);

        factory(Item::class)->create([
            'name' => 'Second Item'
        ]);

        // $response = $this->json('GET', '/api/items/1')
        //     ->assertStatus(200)
        //     ->assertJson([
        //         [ 'name' => 'Second Item' ]
		// 	])
        //     ->assertJsonStructure([
        //         '*' => ['id', 'name', 'checked', 'created_at', 'updated_at'],
		// 	]);
			
		$this->get('/api/items/2')->assertStatus(200)->assertJsonStructure([
			'id', 
			'name',
			'checked'
		]);
	}
	
	public function testAddsItemToShoppingList()
    {
		$response = $this->json('POST', '/api/items', [
			'name' => 'Bananas'
		]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'created_at' => true,
            ]);
	}

	public function testCanEditShoppingListItem() 
	{
        $item = factory(Item::class)->create([
            'name' => 'First Item',
        ]);

        $payload = [
			'name' => 'Lorem Ipsum'
        ];

        $response = $this->json('PUT', '/api/items/' . $item->id, $payload)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 1, 
                'name' => 'Lorem Ipsum'
            ]);
	}

	public function testsCanDeleteShoppingListItem()
    {
        $item = factory(Item::class)->create([
            'name' => 'First Item',
        ]);

        $this->json('DELETE', '/api/items/' . $item->id, [])
            ->assertStatus(200);
    }
	
}