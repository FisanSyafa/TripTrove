<!DOCTYPE html>
<html>

<head>
    <title>Comment & Rating</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 150vh;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 400px;
            height: 650px;
        }

        input[type="text"],
        textarea,
        select {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-container {
            display: flex;
            justify-content: center;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .comment-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 90%;
        }

        .comment-section h3 {
            margin: 0;
            color: #333;
        }

        .comment-section p {
            color: #555;
        }

        .comment-section small {
            color: #999;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <h2>Submit your comment and rating</h2>
    <?php
    session_start();
    include '../includes/koneksi.php';

    // Pastikan variabel session telah diatur
    if (isset($_SESSION['username']) && isset($_SESSION['nama_paket_trip'])) {
        $username = $_SESSION['username'];
        $nama_paket_trip = $_SESSION['nama_paket_trip'];
    } else {
        echo "Please log in and select a package trip.";
        exit;
    }
    ?>
    <form method="post" action="aksi_simpan_commentrating.php" enctype="multipart/form-data">
        <p>
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="nama_paket_trip" value="<?php echo htmlspecialchars($nama_paket_trip); ?>">
        </p>
        <p>
            <label>Region: </label>
            <select name="region_id" required>
                <option value=""></option>
                <?php
                $query = "SELECT * FROM regions ORDER BY region_name ASC";
                $result = mysqli_query($link, $query);

                while ($regions = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . htmlspecialchars($regions['region_id']) . '">' . htmlspecialchars($regions['region_name']) . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            Comment: <textarea name="comment" rows="5" cols="40" required></textarea>
            Rating:
            <select name="comment_star" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select><br>
        </p>
        <p>
            <label>Choose image to upload:</label><br>
            <input type="file" name="image" accept="image/*"><br><br><br>
        </p>
        <input type="hidden" name="comment_date" value="<?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        echo date('Y-m-d H:i:s');
                                                        ?>">
        <div class="submit-container">
            <input type="submit" value="Submit">
        </div>
    </form>
</body>

</html>
