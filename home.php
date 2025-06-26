<?php
include 'config.php';
session_start();

$usermail="";
$usermail=$_SESSION['usermail'];
if($usermail == true){
}else{
  header("location: index.php");
}

// 新增：查数据库，生成房型和bedding类型的映射
$roomTypeMap = [];
$roomTypes = [];
$sql = "SELECT type, bedding FROM room WHERE type != '' AND bedding != ''";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
    $type = $row['type'];
    $bed = $row['bedding'];
    if(!isset($roomTypeMap[$type])) $roomTypeMap[$type] = [];
    if(!in_array($bed, $roomTypeMap[$type])) $roomTypeMap[$type][] = $bed;
    if(!in_array($type, $roomTypes)) $roomTypes[] = $type;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <title>Hotel blue bird</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <style>
      #guestdetailpanel{
        
        display: none;
      }
      #guestdetailpanel .middle{
        height: 630px;
      }
      
.listarrow, .listarrow li, .listarrow i {
    color: white !important;
}

.roomselect .roombox.room-btn.disabled-room {
  filter: grayscale(0.7);
  opacity: 0.5;
  pointer-events: none;
  cursor: not-allowed;
}

    </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img class="bluebirdlogo" src="./image/bluebirdlogo.png" alt="logo">
      <p>BLUEBIRD</p>
    </div>
    <ul>
      <li><a href="#firstsection">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#secondsection">Rooms</a></li>
      <li><a href="#contactus">contact us</a></li>
      <a href="./logout.php"><button class="btn btn-danger">Logout</button></a>
    </ul>
  </nav>

  <section id="firstsection" class="carousel slide carousel_section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="carousel-image" src="./image/hotel1.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel2.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel3.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel4.jpg">
        </div>

        <div class="welcomeline">
          <h1 class="welcometag">Welcome to Bluebird</h1>
        </div>

      <div id="guestdetailpanel">
        <form action="" method="POST" class="guestdetailpanelform" >
            <div class="head">
            <h3 style="margin-left: -8px">ROOM RESERVATION</h3>
                <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
            </div>
            <div class="middle">
            

                <div class="line"></div>




                <div class="reservationinfo">
                 
                    <input type="text" name="Name" placeholder="Full name">
                    <input type="email" name="Email" placeholder="Email" value="<?php echo $usermail; ?>" readonly>

                    <?php
                    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                    ?>

                    <select name="Country" class="selectinput">
						<option value selected >Select your country</option>
                        <?php
							foreach($countries as $key => $value):
							echo '<option value="'.$value.'">'.$value.'</option>';
							endforeach;
						?>
                    </select>
                    <input type="text" name="Phone" placeholder="Enter Phoneno">
                    <select name="RoomType" class="selectinput" id="roomTypeSelect">
                        <option value selected >Type Of Room</option>
                        <?php
                        if (count($roomTypes) > 0) {
                            foreach($roomTypes as $type) {
                                echo '<option value="'.htmlspecialchars($type).'">'.strtoupper(htmlspecialchars($type)).'</option>';
                            }
                        } else {
                            echo '<option value="None">None</option>';
                        }
                        ?>
                    </select>
                    <select name="Bed" class="selectinput" id="bedTypeSelect" readonly>
                        <option value selected >Bedding Type</option>
                        <!-- JS填充 -->
                    </select>
                    <input type="number" name="NoofRoom" class="selectinput" placeholder="No of Room" min="1" value="1">
                    <select name="Meal" class="selectinput">
						<option value selected >Meal</option>
                        <option value="Room only">Room only</option>
                        <option value="Breakfast">Breakfast</option>
						<option value="Half Board">Half Board</option>
						<option value="Full Board">Full Board</option>
					</select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type ="date">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type ="date">
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailsubmit">Submit</button>
            </div>
        </form>

        <?php       
    if (isset($_POST['guestdetailsubmit'])) {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Country = $_POST['Country'];
        $Phone = $_POST['Phone'];
        $RoomType = $_POST['RoomType'];
        $Bed = $_POST['Bed'];
        $NoofRoom = $_POST['NoofRoom'];
        $Meal = $_POST['Meal'];
        $cin = $_POST['cin'];
        $cout = $_POST['cout'];

        if($Name == "" || $Email == "" || $Country == "" || strtotime($cout) <= strtotime($cin)){
            echo "<script>swal({
                title: 'Fill the proper details',
                icon: 'error',
            });
            </script>";
        }
        else{
            $check_sql = "SELECT * FROM room WHERE type = '$RoomType' AND bedding = '$Bed' LIMIT 1";
            $check_result = mysqli_query($conn, $check_sql);
            
            if(mysqli_num_rows($check_result) == 0) {
                echo "<script>swal({
                    title: '".$RoomType." with ".$Bed." bedding not found',
                    icon: 'error',
                });
                </script>";
            } else {
                $row = mysqli_fetch_assoc($check_result);
                $room_id = $row['id'];
                
                $delete_sql = "DELETE FROM room WHERE id = '$room_id'";
                mysqli_query($conn, $delete_sql);

                $sta = "NotConfirm";
                $sql = "INSERT INTO roombook(Name,Email,Country,Phone,RoomType,Bed,NoofRoom,Meal,cin,cout,stat,nodays) VALUES ('$Name','$Email','$Country','$Phone','$RoomType','$Bed','$NoofRoom','$Meal','$cin','$cout','$sta',datediff('$cout','$cin'))";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>
                        swal({
                            title: 'Need any services?',
                            icon: 'success',
                            buttons: {
                                confirm: {
                                    text: 'Yes',
                                    value: true,
                                    visible: true,
                                    className: 'btn-primary',
                                    closeModal: true
                                },
                                cancel: {
                                    text: 'No',
                                    value: false,
                                    visible: true,
                                    className: 'btn-danger',
                                    closeModal: true,
                                }
                            }
                        }).then((value) => {
                            if (value) {
                                window.location.href = 'service.php';
                            }
                        });
                    </script>";
                } else {
                    echo "<script>swal({
                            title: 'Something went wrong',
                            icon: 'error',
                        });
                    </script>";
                }
            }
        }
    }
?>

          </div>
    </div>





  </section>
    


  <section id="about" style="padding: 80px 20px; background-color: #f5f7fa;">
  <div style="max-width: 1200px; margin: auto;">
    <h2 style="text-align: center; font-size: 32px; color: #003580; margin-bottom: 30px;">About Our Hotel</h2>

    <div style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center; justify-content: center;">
      
      <!-- Left: Image -->
      <div style="flex: 1; min-width: 300px;">
        <img src="./image/hotel1.jpg" alt="About Hotel" style="width: 100%; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
      </div>

      <!-- Right: Text -->
      <div style="flex: 1; min-width: 300px;">
        <h3 style="font-size: 24px; color: #003580; margin-bottom: 15px;">Our Hotel</h3>
        <p style="color: #555; line-height: 1.7;">
          Located in the city center, our hotel blends traditional Chinese decor with modern conveniences. Spacious rooms with smart lighting, welcoming staff, and a full-service restaurant make us ideal for both business and leisure.
        </p>
        <ul style="list-style: none; padding-left: 0; color: #333;">
          <li><i class="fa fa-check-circle" style="color:#0077cc;"></i> Room Service</li>
          <li><i class="fa fa-check-circle" style="color:#0077cc;"></i> Garden Environment</li>
          <li><i class="fa fa-check-circle" style="color:#0077cc;"></i> Breakfast Service</li>
          <li><i class="fa fa-check-circle" style="color:#0077cc;"></i> Translation Service</li>
          <li><i class="fa fa-check-circle" style="color:#0077cc;"></i> Bathing and Chess</li>
        </ul>
      </div>
    </div>
  </div>
</section>


<section id="secondsection" style="background-color: #f5f7fa; padding: 80px 20px;">
  <div class="ourroom" style="top: 0; height: auto;">
    <h1 class="head" style="font-size: 36px; color: #003580; margin-bottom: 40px;">Our Room</h1>

    <div class="roomselect" style="gap: 30px; flex-wrap: wrap; justify-content: center;">
      <div class="roombox room-btn" id="superiorRoomBox" style="background-color: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; cursor:pointer;">
        <div class="hotelphoto h1"></div>
        <div class="roomdata">
          <h2 style="color: #003580;">Superior Room</h2>
          <p style="color: #555;">RM 450 / night</p>
        </div>
      </div>

      <div class="roombox room-btn" id="deluxeRoomBox" style="background-color: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; cursor:pointer;">
        <div class="hotelphoto h2"></div>
        <div class="roomdata">
          <h2 style="color: #003580;">Deluxe Room</h2>
          <p style="color: #555;">RM 300 / night</p>
        </div>
      </div>

      <div class="roombox room-btn" id="guestRoomBox" style="background-color: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; cursor:pointer;">
        <div class="hotelphoto h3"></div>
        <div class="roomdata">
          <h2 style="color: #003580;">Guest ROOM</h2>
          <p style="color: #555;">RM 220 / night</p>
        </div>
      </div>

      <div class="roombox room-btn" id="singleRoomBox" style="background-color: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; cursor:pointer;">
        <div class="hotelphoto h4"></div>
        <div class="roomdata">
          <h2 style="color: #003580;">Single Room</h2>
          <p style="color: #555;">RM 150 / night</p>
        </div>
      </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <button class="bookbtn" id="bookNowBtn" style="padding: 12px 30px; background-color: #0077cc; border: none; color: white; font-size: 16px; border-radius: 8px;">Book Now</button>
    </div>
  </div>
</section>


<section id="contactus" style="background-color: #003580; padding: 40px 20px;">
  <div style="max-width: 1000px; margin: auto; text-align: center;">
    <!-- icon -->
    <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; align-items: center; margin-bottom: 20px;">
    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
  <i class="fa-brands fa-instagram" style="font-size: 28px; color: white;"></i>
</a>
    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
  <i class="fa-brands fa-facebook" style="font-size: 28px; color: white;"></i>
</a>
<a href="https://www.gmail.com/" target="_blank" rel="noopener noreferrer">
  <i class="fa-solid fa-envelope" style="font-size: 28px; color: white;"></i>
</a>
    
</section>



</body>

<script>
    var bookbox = document.getElementById("guestdetailpanel");

    // Book Now button should always work
    document.getElementById('bookNowBtn').onclick = function() {
      bookbox.style.display = "flex";
      // Reset room type selection
      var roomTypeSelect = bookbox.querySelector('select[name=\"RoomType\"]');
      if(roomTypeSelect) {
        roomTypeSelect.selectedIndex = 0;
        var event = new Event('change');
        roomTypeSelect.dispatchEvent(event);
      }
    };

    // Room card click: open and prefill type
    function openbookboxWithRoomType(roomType) {
      bookbox.style.display = "flex";
      var roomTypeSelect = bookbox.querySelector('select[name=\"RoomType\"]');
      if(roomTypeSelect) {
        for (var i = 0; i < roomTypeSelect.options.length; i++) {
          if(roomTypeSelect.options[i].value.toLowerCase().replace(/\s/g, '') === roomType.toLowerCase().replace(/\s/g, '')) {
            roomTypeSelect.selectedIndex = i;
            break;
          }
        }
        // Trigger change event to update bedding type
        var event = new Event('change');
        roomTypeSelect.dispatchEvent(event);
      }
    }

    function closebox() {
      bookbox.style.display = "none";
    }

    // Room type and bedding type mapping from PHP
    var roomTypeMap = <?php echo json_encode($roomTypeMap); ?>;
    var roomTypeSelect = document.getElementById('roomTypeSelect');
    var bedTypeSelect = document.getElementById('bedTypeSelect');

    // Initialize Bedding Type as readonly
    bedTypeSelect.setAttribute('readonly', true);
    bedTypeSelect.innerHTML = '<option value selected >Bedding Type</option>';

    roomTypeSelect.addEventListener('change', function() {
        var type = this.value;
        bedTypeSelect.innerHTML = '';
        if (!type || type === 'Type Of Room' || !roomTypeMap[type] || roomTypeMap[type].length === 0) {
            bedTypeSelect.innerHTML = '<option value="None">None</option>';
            bedTypeSelect.setAttribute('readonly', true);
        } else {
            bedTypeSelect.removeAttribute('readonly');
            bedTypeSelect.innerHTML = '<option value selected >Bedding Type</option>';
            roomTypeMap[type].forEach(function(bed) {
                bedTypeSelect.innerHTML += '<option value="'+bed+'">'+bed+'</option>';
            });
        }
    });

    // Enable/disable room cards based on database
    function setRoomBoxStatus() {
      var typeMap = {
        'Superior Room': 'superiorRoomBox',
        'Deluxe Room': 'deluxeRoomBox',
        'Guest House': 'guestRoomBox',
        'Single Room': 'singleRoomBox'
      };
      Object.keys(typeMap).forEach(function(type) {
        var box = document.getElementById(typeMap[type]);
        if (roomTypeMap[type] && roomTypeMap[type].length > 0) {
          box.classList.remove('disabled-room');
          box.style.opacity = 1;
          box.style.pointerEvents = 'auto';
          box.onclick = function() { openbookboxWithRoomType(type); };
        } else {
          box.classList.add('disabled-room');
          box.style.opacity = 0.5;
          box.style.pointerEvents = 'none';
          box.onclick = null;
        }
      });
    }
    setRoomBoxStatus();
</script>
</html>
