var shoppingItemTemplate = (
	'<li class="js-shopping-item">' +
	'<p><span class="shopping-item js-shopping-item-name"></span></p>' +
	'<div class="shopping-item-controls">' +
	'<button class="js-shopping-item-toggle">' +
	'<span class="button-label">check</span>' +
	'</button>' +
	'<button class="js-shopping-item-delete">' +
	'<span class="button-label">delete</span>' +
	'</button>' +
	'</div>' +
	'</li>'
);

var SHOPPING_LIST_URL = '/api/items';

function getAndDisplayShoppingList() {
	console.log( 'Retrieving shopping list' );
	$.getJSON( SHOPPING_LIST_URL, function( items ) {
		console.log( 'Rendering shopping list' );
		var itemElements = items.map( function( item ) {
			var element = $( shoppingItemTemplate );
			element.attr( 'id', item.id );
			var itemName = element.find( '.js-shopping-item-name' );
			itemName.text( item.name );
			element.attr( 'data-checked', item.checked );
			if ( item.checked ) {
				itemName.addClass( 'shopping-item__checked' );
			}
			return element
		} );
		$( '.js-shopping-list' ).html( itemElements );
	} );
}

function addShoppingItem( item ) {
	console.log( 'Adding shopping item: ' + item );
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
	console.log( 'Deleting shopping item `' + itemId + '`' );
	$.ajax( {
		url: SHOPPING_LIST_URL + '/' + itemId,
		method: 'DELETE',
		success: getAndDisplayShoppingList
	} );
}

function updateShoppingListitem( item ) {
	console.log( 'Updating shopping list item `' + item.id + '`' );
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
		console.log('item', element)
		var item = {
			id: element.attr( 'id' ),
			checked: !JSON.parse( element.attr( 'data-checked' ) ),
			name: element.find( '.js-shopping-item-name' ).text()
		}
		console.log(item)
		updateShoppingListitem( item );
	} );
}

$( function() {
	getAndDisplayShoppingList();
	handleShoppingListAdd();
	handleShoppingListDelete();
	handleShoppingCheckedToggle();
} );
