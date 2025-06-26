<?php
session_start();
$name = $_SESSION['usermail'] ?? 'Guest';

include 'config.php';
$email = $_SESSION['usermail'];
$sql = "SELECT id FROM roombook WHERE Email = '$email' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$roombook_id = $row['id'] ?? null;

// Initialize selected services as empty array
$selected_services = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roombook_id = $_POST['roombook_id'];
    $cleaning_time = $_POST['cleaning_time'] ?? null;
    $pool_time = $_POST['pool_time'] ?? null;
    $food_total = $_POST['food_total'] ?? 0;
    
    // Calculate total
    $total = 0;
    if ($cleaning_time) $total += 10;
    if ($pool_time) $total += 20;
    $total += floatval($food_total);
    
    $sql = "INSERT INTO service (id, clean, pool, food, total) 
            VALUES ($roombook_id, " . 
            ($cleaning_time ? "'$cleaning_time'" : "NULL") . ", " .
            ($pool_time ? "'$pool_time'" : "NULL") . ", " .
            ($food_total ? "$food_total" : "0.00") . ", " .
            "$total) 
            ON DUPLICATE KEY UPDATE 
            clean = " . ($cleaning_time ? "'$cleaning_time'" : "NULL") . ", 
            pool = " . ($pool_time ? "'$pool_time'" : "NULL") . ", 
            food = " . ($food_total ? "$food_total" : "0.00") . ",
            total = $total";
    
    mysqli_query($conn, $sql);
    
    // Set session flag to show confirmation popup
    $_SESSION['show_confirmation'] = true;
    
    header("Location: service.php");
    exit();
}

// Check if we should show confirmation popup
$show_confirmation = $_SESSION['show_confirmation'] ?? false;
if ($show_confirmation) {
    unset($_SESSION['show_confirmation']); // Clear the flag
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Choose Service - BlueBird</title>
    <link rel="stylesheet" href="css/service.css" />
</head>
<body>
<header>
    <button class="home-button" onclick="window.location.href='home.php'">
        <span style="font-size: 18px; margin-right: 8px;">🏠</span> Home
    </button>
    <div class="logo">BlueBird.com</div>
    <div class="user"><?php echo htmlspecialchars(substr($name,0,1)); ?></div>
</header>

<main>
    <div class="service-container">
        <div class="service-card" id="cleaningCard">
            <h3>🧹 Schedule Cleaning / RM 10</h3>
            <p>Request housekeeping service for your room.</p>
            <button onclick="openCleaning(event)">Select Service</button>
            <div class="selected-service" id="selectedCleaning"></div>
        </div>

        <div class="service-card" id="poolCard">
            <h3>🏊 Pool Reservation / RM 20</h3>
            <p>Reserve a time slot to use the swimming pool.</p>
            <button onclick="openPool(event)">Select Service</button>
            <div class="selected-service" id="selectedPool"></div>
        </div>

        <div class="service-card" id="foodCard">
            <h3>🍽️ View Food Menu</h3>
            <p>Available menu is updated in real time.</p>
            <br>
            <button onclick="openFoodMenu(event)">View Menu</button>
            <div class="selected-service" id="selectedFood"></div>
        </div>
    </div>
    
    <div class="confirm-container">
        <form id="mainForm" method="post">
            <input type="hidden" name="roombook_id" value="<?php echo $roombook_id; ?>">
            <input type="hidden" name="cleaning_time" id="cleaningTimeInput" value="">
            <input type="hidden" name="pool_time" id="poolTimeInput" value="">
            <input type="hidden" name="food_total" id="foodTotalInput" value="0">
            <button type="submit" class="confirm-button">Confirm All Services</button>
        </form>
    </div>
</main>

<div class="overlay" id="overlay"></div>

<!-- Confirmation Popup -->
<div class="popup" id="confirmationPopup" style="display: <?php echo $show_confirmation ? 'flex' : 'none'; ?>">
    <div class="popup-content">
        <h3>Selection Completed</h3>
        <p>Your service selections have been saved.</p>
        <div class="actions">
            <button type="button" class="ok-button" onclick="window.location.href='home.php'">Okay</button>
        </div>
    </div>
</div>

<div class="popup" id="cleaningPopup">
    <div class="popup-content">
        <h3>Schedule Cleaning</h3>
        <label for="cleaningTime">Choose Time:</label>
        <input type="time" id="cleaningTime" value="" />
        <div class="actions">
            <button type="button" onclick="saveCleaningTime()">Save</button>
            <button type="button" onclick="closePopup('cleaningPopup')">Cancel</button>
        </div>
    </div>
</div>

<div class="popup" id="poolPopup">
    <div class="popup-content">
        <h3>Pool Reservation</h3>
        <label for="poolTime">Choose Time:</label>
        <input type="time" id="poolTime" value="" />
        <div class="actions">
            <button type="button" onclick="savePoolTime()">Save</button>
            <button type="button" onclick="closePopup('poolPopup')">Cancel</button>
        </div>
    </div>
</div>

<div class="popup" id="foodPopup">
    <div class="popup-content">
        <h3>Food Menu</h3>
        <div class="food-menu" id="foodMenuList"></div>
        <div>
            <strong>Total: RM<span id="totalPrice">0.00</span></strong>
        </div>
        <div class="actions">
            <button type="button" onclick="saveFoodOrder()">Save</button>
            <button type="button" onclick="closePopup('foodPopup')">Cancel</button>
        </div>
    </div>
</div>

<footer>
    Copyright © 2025–2030 BlueBird.com™. All rights reserved
</footer>

<script>
    const overlay = document.getElementById('overlay');
    const roombookId = <?php echo $roombook_id ?? 'null'; ?>;
    
    const foodItems = [
        { id: 1, name: 'Burger', price: 5.99 },
        { id: 2, name: 'Pizza', price: 8.99 },
        { id: 3, name: 'Salad', price: 4.5 },
        { id: 4, name: 'Soda', price: 1.99 },
        { id: 5, name: 'Coffee', price: 2.99 }
    ];

    function showOverlay() {
        overlay.style.display = 'block';
    }
    
    function hideOverlay() {
        overlay.style.display = 'none';
    }
    
    function openPopup(id) {
        document.getElementById(id).style.display = 'flex';
        showOverlay();
    }
    
    function closePopup(id) {
        document.getElementById(id).style.display = 'none';
        hideOverlay();
    }

    function openCleaning(e) {
        e.stopPropagation();
        openPopup('cleaningPopup');
        document.getElementById('cleaningTime').value = document.getElementById('cleaningTimeInput').value || '';
    }

    function saveCleaningTime() {
        const time = document.getElementById('cleaningTime').value;
        document.getElementById('cleaningTimeInput').value = time;
        const displayElement = document.getElementById('selectedCleaning');
        displayElement.innerHTML = time ? `<p>Selected: ${time}</p>` : '';
        closePopup('cleaningPopup');
    }

    function openPool(e) {
        e.stopPropagation();
        openPopup('poolPopup');
        document.getElementById('poolTime').value = document.getElementById('poolTimeInput').value || '';
    }

    function savePoolTime() {
        const time = document.getElementById('poolTime').value;
        document.getElementById('poolTimeInput').value = time;
        const displayElement = document.getElementById('selectedPool');
        displayElement.innerHTML = time ? `<p>Selected: ${time}</p>` : '';
        closePopup('poolPopup');
    }

    function openFoodMenu(e) {
        e.stopPropagation();
        openPopup('foodPopup');
        renderFoodMenu();
    }

    function renderFoodMenu() {
        const container = document.getElementById('foodMenuList');
        container.innerHTML = '';
        foodItems.forEach(item => {
            const div = document.createElement('div');
            div.className = 'food-item';
            div.innerHTML = `
                <span>${item.name} - RM${item.price.toFixed(2)}</span>
                <input type="number" min="0" value="0" data-id="${item.id}" data-price="${item.price}" onchange="updateTotal()" />
            `;
            container.appendChild(div);
        });
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#foodMenuList input[type=number]').forEach(input => {
            const count = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price);
            total += count * price;
        });
        document.getElementById('totalPrice').textContent = total.toFixed(2);
    }

    function saveFoodOrder() {
        let total = 0;
        document.querySelectorAll('#foodMenuList input[type=number]').forEach(input => {
            const count = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price);
            total += count * price;
        });
        document.getElementById('foodTotalInput').value = total.toFixed(2);
        const displayElement = document.getElementById('selectedFood');
        displayElement.innerHTML = total > 0 ? `<p>Total: RM${total.toFixed(2)}</p>` : '';
        closePopup('foodPopup');
    }

    overlay.onclick = () => {
        ['cleaningPopup', 'poolPopup', 'foodPopup', 'confirmationPopup'].forEach(id => {
            closePopup(id);
        });
    };

    // Show confirmation popup if needed
    <?php if ($show_confirmation): ?>
        document.addEventListener('DOMContentLoaded', function() {
            openPopup('confirmationPopup');
        });
    <?php endif; ?>
</script>
</body>
</html>