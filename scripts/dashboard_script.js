document.addEventListener('DOMContentLoaded', function() {
    // Mock data for the user's name and items on order
    const userName = ''; // Replace this with dynamic data as needed
    const itemsOnOrder = [
        // Uncomment the following lines to test with items
        // { name: 'Item 1', quantity: 2 },
        // { name: 'Item 2', quantity: 5 },
    ];

    // Update the user's name in the HTML
    const userNameElement = document.getElementById('user-name');
    if (userName.trim() === '') {
        userNameElement.textContent = '<Unknown User>'; // Display if name is empty or not found
    } else {
        userNameElement.textContent = userName;
    }

    // Get the list and message elements
    const itemsListElement = document.getElementById('items-list');
    const noItemsMessage = document.getElementById('no-items-message');

    // Clear the existing list
    itemsListElement.innerHTML = '';

    if (itemsOnOrder.length === 0) {
        noItemsMessage.style.display = 'block'; // Show the "No Items on Order" message
    } else {
        noItemsMessage.style.display = 'none'; // Hide the message
        itemsOnOrder.forEach(item => {
            const listItem = document.createElement('li');
            listItem.textContent = `${item.name} (Quantity: ${item.quantity})`;
            itemsListElement.appendChild(listItem);
        });
    }
});

