<?php

include "connection.php";

// Fetch hotels
$sql = "SELECT * FROM hotel";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Listing</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Hotel Listing</h1>
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
        <h2>List of Hotels</h2>
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
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
    </main>

    <footer>
        <p>&copy; 2024 Hotel and Food Management</p>
    </footer>

    <?php $conn->close(); ?>
</body>

</html>

