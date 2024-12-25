<?php

include "connection.php";


// Count totals
$totalHotelsQuery = "SELECT COUNT(*) AS total_hotels FROM hotel";
$totalFoodQuery = "SELECT COUNT(*) AS total_food FROM food";

$totalHotelsResult = $conn->query($totalHotelsQuery);
$totalFoodResult = $conn->query($totalFoodQuery);

$totalHotels = $totalHotelsResult->fetch_assoc()['total_hotels'];
$totalFood = $totalFoodResult->fetch_assoc()['total_food'];

// Monthly chart data
$monthlyHotelQuery = "SELECT MONTHNAME(created_at) AS month, COUNT(*) AS count FROM hotel GROUP BY MONTH(created_at)";
$monthlyFoodQuery = "SELECT MONTHNAME(created_at) AS month, COUNT(*) AS count FROM food GROUP BY MONTH(created_at)";

$monthlyHotelResult = $conn->query($monthlyHotelQuery);
$monthlyFoodResult = $conn->query($monthlyFoodQuery);

$monthlyData = [];
while ($row = $monthlyHotelResult->fetch_assoc()) {
    $monthlyData['hotels'][$row['month']] = $row['count'];
}
while ($row = $monthlyFoodResult->fetch_assoc()) {
    $monthlyData['food'][$row['month']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
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
        <section>
            <h2>Overview</h2>
            <p>Total Hotels: <?php echo $totalHotels; ?></p>
            <p>Total Food Items: <?php echo $totalFood; ?></p>
        </section>

        <section>
            <h2>Monthly Data</h2>
            <canvas id="monthlyChart"></canvas>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Hotel and Food Management</p>
    </footer>

    <script>
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyData = <?php echo json_encode($monthlyData); ?>;

        const labels = Object.keys(monthlyData.hotels || {});
        const hotelData = labels.map(month => monthlyData.hotels[month] || 0);
        const foodData = labels.map(month => monthlyData.food[month] || 0);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Hotels',
                        data: hotelData,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Food Items',
                        data: foodData,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Data for Hotels and Food Items'
                    }
                }
            }
        });
    </script>

    <?php $conn->close(); ?>
</body>

</html>