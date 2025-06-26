<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/roombook.css">
    <title>BlueBird - Admin</title>
</head>

<body>
    <!-- ================================================= -->
    <div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search..." onkeyup="searchFun()">
      
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <?php
       
            $query = "SELECT r.id, r.Name, r.Email, r.RoomType, r.Bed, 
                      s.clean, s.pool, s.food 
                      FROM service s
                      JOIN roombook r ON r.id = s.id
                      ORDER BY r.id";
            $result = mysqli_query($conn, $query);
            $nums = mysqli_num_rows($result);
        ?>
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Type of Room</th>
                    <th scope="col">Type of Bed</th>
                    <th scope="col">Cleaning Time</th>
                    <th scope="col">Pool Reservation</th>
                    <th scope="col">Food Bill</th>
                    <th scope="col">Total Bill</th>
                </tr>
            </thead>

            <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
         
                $total_bill = 0;
                
               
                if (!empty($row['clean'])) {
                    $total_bill += 10;
                }
                
              
                if (!empty($row['pool'])) {
                    $total_bill += 20;
                }
                
              
                if (!empty($row['food'])) {
                    $total_bill += $row['food'];
                }
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['Name'] ?></td>
                    <td><?php echo $row['Email'] ?></td>
                    <td><?php echo $row['RoomType'] ?></td>
                    <td><?php echo $row['Bed'] ?></td>
                    <td><?php echo !empty($row['clean']) ? substr($row['clean'], 0, 5) : 'Not reserved' ?></td>
                    <td><?php echo !empty($row['pool']) ? substr($row['pool'], 0, 5) : 'Not reserved' ?></td>
                    <td><?php echo !empty($row['food']) ? '' . number_format($row['food'], 2) : '0.00' ?></td>
                    <td><?php echo number_format($total_bill, 2) ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
<script src="./javascript/roombook.js"></script>
</html>