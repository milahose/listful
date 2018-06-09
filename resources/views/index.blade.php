<!DOCTYPE html>
<html>
  <head>
    <title>Welcome to HyperDev!</title>
    <meta name="description" content="Shopping and to do lists">
    <link id="favicon" rel="icon" href="https://hyperdev.com/favicon-app.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!-- <link href="{{ asset('css/index.css') }}" rel="stylesheet"> -->

	<style>
		* {
			box-sizing: border-box;
		}

		body {
			font-family: 'Roboto', sans-serif;
		}

		button, input[type="text"] {
			padding: 5px;
		}

		button:hover {
			cursor: pointer;
		}

		#shopping-list-item {
			width: 250px;
		}

		.container {
			max-width: 600px;
			margin: 0 auto;
		}

		.shopping-list {
			list-style: none;
			padding-left: 0;
		}

		.shopping-list > li {
			margin-bottom: 20px;
			border: 1px solid grey;
			padding: 20px;
		}

		.shopping-item {
			display: block;
			color: grey;
			font-style: italic;
			font-size: 20px;
			margin-bottom: 15px;
		}

		.shopping-item:focus {
			outline: none;
		}

		.shopping-item__checked {
			text-decoration: line-through;
		}
	</style>
  </head>
  <body>
    <div class="container">
      <main>
        <section>
          <h2>Shopping list</h2>
          <form id="js-shopping-list-form">
            <label for="shopping-list-entry">Add an item</label>
            <input type="text" name="shopping-list-entry" id="js-new-item" placeholder="e.g., broccoli">
            <button type="submit">Add item</button>
          </form>

          <ul class="shopping-list js-shopping-list">
          </ul>
        </section>
      </main>
    </div>
    <script src="//code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="{{ asset('js/client.js') }}"></script> -->

	<script>
		var shoppingItemTemplate = 
			`<li class="js-shopping-item">
				<input name="shopping-item" class="shopping-item"></input>
				<div class="shopping-item-controls">
				<button class="js-shopping-item-toggle">
					<span class="button-label">check</span>
				</button>
				<button class="js-shopping-item-delete">
					<span class="button-label">delete</span>
				</button>
				</div>
			</li>`;

		var SHOPPING_LIST_URL = '/api/items';

		function getAndDisplayShoppingList() {
			$.getJSON( SHOPPING_LIST_URL, function( items ) {
				var itemElements = items.map( function( item ) {
					var element = $( shoppingItemTemplate );
					element.attr( 'id', item.id );
					var itemName = element.find( '.js-shopping-item-name' );
					itemName.text( item.name );
					var input = element.find( '.shopping-item' );
					input.attr( 'value', item.name );
					element.attr( 'data-checked', item.checked );
					if ( item.checked ) {
						input.prop( 'disabled', true);
						input.addClass( 'shopping-item__checked' );
					}
					return element
				} );
				$( '.js-shopping-list' ).html( itemElements );
			} );
		}

		function addShoppingItem( item ) {
			$.ajax( {
				method: 'POST',
				url: SHOPPING_LIST_URL,
				data: JSON.stringify( item ),
				success: function( data ) {
					getAndDisplayShoppingList();
				},
				dataType: 'json',
				contentType: 'application/json'
			} );
		}

		function deleteShoppingItem( itemId ) {
			$.ajax( {
				url: SHOPPING_LIST_URL + '/' + itemId,
				method: 'DELETE',
				success: getAndDisplayShoppingList
			} );
		}

		function updateShoppingListitem( item ) {
			$.ajax( {
				url: SHOPPING_LIST_URL + '/' + item.id,
				method: 'PUT',
				data: JSON.stringify( item ),
				success: function( data ) {
					getAndDisplayShoppingList()
				},
				dataType: 'json',
				contentType: 'application/json'
			} );
		}

		function handleShoppingListAdd() {

			$( '#js-shopping-list-form' ).submit( function( e ) {
				e.preventDefault();
				addShoppingItem( {
					name: $( e.currentTarget ).find( '#js-new-item' ).val(),
					checked: false
				} );
			} );

		}

		function handleShoppingListDelete() {
			$( '.js-shopping-list' ).on( 'click', '.js-shopping-item-delete', function( e ) {
				e.preventDefault();
				deleteShoppingItem(
					$( e.currentTarget ).closest( '.js-shopping-item' ).attr( 'id' ) );
			} );
		}

		function handleShoppingCheckedToggle() {
			$( '.js-shopping-list' ).on( 'click', '.js-shopping-item-toggle', function( e ) {
				e.preventDefault();
				var element = $( e.currentTarget ).closest( '.js-shopping-item' );
				var item = {
					id: element.attr( 'id' ),
					checked: !JSON.parse( element.attr( 'data-checked' ) ),
					name: element.find( '.shopping-item' ).val()
				}

				updateShoppingListitem( item );
			} );
		}

		function handleShoppingItemUpdate() {
			$( '.js-shopping-list' ).on( 'change', '.shopping-item', function( e ) {
				e.preventDefault();
				var element = $( e.currentTarget ).closest( '.js-shopping-item' );
				var item = {
					id: element.attr( 'id' ),
					checked: element.attr( 'data-checked' ),
					name: element.find( '.shopping-item' ).val()
				}

				updateShoppingListitem( item );
			} );
		}

		$( function() {
			getAndDisplayShoppingList();
			handleShoppingListAdd();
			handleShoppingListDelete();
			handleShoppingCheckedToggle();
			handleShoppingItemUpdate();
		} );

	</script>
  </body>
</html>
