<?php


include "connection.php";




// Fetch food items
$sql = "SELECT f.food_id, f.food_name, f.price, h.hotel_name FROM food f JOIN hotel h ON f.hotel_id = h.hotel_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Listing</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Food Listing</h1>
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
        <h2>List of Food Items</h2>
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
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
    </main>

    <footer>
        <p>&copy; 2024 Hotel and Food Management</p>
    </footer>

    <?php $conn->close(); ?>
</body>

</html>