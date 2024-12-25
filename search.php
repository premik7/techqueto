<?php

include "connection.php";


// Search functionality
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$hotelQuery = "SELECT * FROM hotel WHERE hotel_name LIKE ? OR location LIKE ?";
$foodQuery = "SELECT f.food_id, f.food_name, f.price, h.hotel_name FROM food f JOIN hotel h ON f.hotel_id = h.hotel_id WHERE f.food_name LIKE ?";

$stmtHotel = $conn->prepare($hotelQuery);
$stmtHotel->bind_param("ss", $likeTerm, $likeTerm);

$stmtFood = $conn->prepare($foodQuery);
$stmtFood->bind_param("s", $likeTerm);

$likeTerm = "%" . $searchTerm . "%";
$stmtHotel->execute();
$hotelResult = $stmtHotel->get_result();

$stmtFood->execute();
$foodResult = $stmtFood->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      
    </style>
</head>

<body>
    <header>
        <h1>Search Results</h1>
        <nav>
            <ul>
                <li><a href="hotel_list.php">Hotel Listing</a></li>
                <li><a href="food_list.php">Food Listing</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form method="GET" action="search.php">
            <input type="text" name="search" placeholder="Search hotels or food..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>

        <section>
            <h2>Hotels</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($hotelResult->num_rows > 0): ?>
                        <?php while ($row = $hotelResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['hotel_id']; ?></td>
                                <td><?php echo $row['hotel_name']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td><?php echo $row['rating']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No hotels found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Food Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Hotel Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($foodResult->num_rows > 0): ?>
                        <?php while ($row = $foodResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['food_id']; ?></td>
                                <td><?php echo $row['food_name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['hotel_name']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No food items found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Hotel and Food Management</p>
    </footer>

    <?php
    $stmtHotel->close();
    $stmtFood->close();
    $conn->close();
    ?>
</body>

</html>