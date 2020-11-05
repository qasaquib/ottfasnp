 <?php 
 function student_edit_form($email)
 {
$fname=$lname=$gender=$contact=$street=$house=$landmark=$city=$pin="";
$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
$query = "SELECT * FROM student_data WHERE email='$email'";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) == 1) {
      // log user in
      while ($row = mysqli_fetch_row($result)) {
        $fname = $row[1];
        $lname = $row[2];
        $gender = $row[3];
        $city=$row[4];
        }
    }
echo<<<EOT
              <form class="form-group" method="post" action="edit_profile.php" onsubmit="return valInputs()">
               <label class="cw">First Name</label>
               <span class='cy'></span>
              <input type="text" name="fname" class="form-control" placeholder="Enter your first name" value="$fname" required>
              <label class="cw">Last Name</label>
              <span class='cy'></span>
              <input type="text" name="lname" class="form-control" placeholder="Enter your last name" value="$lname" required>
              <label class="cw">Gender</label>
              <span class='cy'></span>
              <select class="form-control" name="gender" value="$gender" required>
                <option>Choose Gender</option>
EOT;  
                if($gender=="Male")
                {
                echo '<option selected>Male</option><option>Female</option>
                <option>Others</option>';
                }
                else if($gender=="Female")
                {
                echo '<option>Male</option><option selected>Female</option>
                <option>Others</option>';
                }
                else
                {
                echo '<option>Male</option><option>Female</option>
                <option selected>Others</option>';
                }
echo <<<EOT
              </select>
              <label class="cw">City</label>
              <span class='cy'></span>
                  <select name="city" id="cityS" class="form-control custom-select sel" required="">
                  <option value="">Select City</option>
EOT;
                   $_SESSION['cities']=popCity();
echo <<<END
                  </select>
                  <label class="cw">State</label>
                  <span class='cy'></span>
                  <select name="state" id="stateS" class="form-control custom-select sel" required="">
                  <option value="">Select State</option>
END;
                  $_SESSION['states']=popState();
echo <<<END
              </select>
              <button type="submit" name="submit_stu" class="btn btn-outline-success btn-block btn-lg mt-2">SUBMIT</button>
            </form>
END;
}

function teacher_edit_form($email)
{
$fname=$lname=$gender=$contact=$street=$house=$landmark=$city=$pin="";
$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
$query = "SELECT * FROM teacher_data WHERE email='$email'";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) == 1) {
      // log user in
      while ($row = mysqli_fetch_row($result)) {
        $fname = $row[1];
        $lname = $row[2];
        $gender = $row[3];
        $contact=$row[4];
        $street=$row[5];
        $house=$row[6];
        $landmark=$row[7];
        //$city=$row[8];
        $pin=$row[10];
        }
    }
echo <<<END
              <form class="form-group" method="post" action="edit_profile.php" onsubmit="return valInputs()">
              <?php include('student_errors.php');?>
               <label class="cw">First Name</label>
               <span class='cy'></span>
              <input type="text" name="fname" class="form-control" placeholder="Enter your first name" value="$fname" required>
              <label class="cw">Last Name</label>
              <span class='cy'></span>
              <input type="text" name="lname" class="form-control" placeholder="Enter your last name" value="$lname" required>
              <label class="cw">Gender</label>
              <span class='cy'></span>
              <select class="form-control" name="gender" value="$gender" required>
                <option>Choose Gender</option>
END;  
                if($gender=="Male")
                {
                echo '<option selected>Male</option><option>Female</option>
                <option>Others</option>';
                }
                else if($gender=="Female")
                {
                echo '<option>Male</option><option selected>Female</option>
                <option>Others</option>';
                }
                else
                {
                echo '<option>Male</option><option>Female</option>
                <option selected>Others</option>';
                }
echo <<<END
              </select>
                  <label class="cw">Contact Number</label>
                  <span class='cy'></span>
                  <input type="text" name="contact" class="form-control" placeholder="Enter your contact number" value="$contact" required>
                  <label class="cw">Street Address</label>
                  <span class='cy'></span>
                  <input type="text" name="house" class="form-control" placeholder="House No. / Bldg No. / Flat / Floor" value="$house">
                  <input type="text" name="street" class="form-control" placeholder="Colony / Street / Locality" value="$street" required>
                  <label class="cw">Landmark</label>
                  <span class='cy'></span>
                  <input type="text" name="landmark" class="form-control" placeholder="E.g. Near NITMAS" value="$landmark">
                  <label class="cw">City</label>
                  <span class='cy'></span>
                  <select name="city" id="cityS" class="form-control custom-select sel" required="">
                  <option value="">Select City</option>
END;
                   $_SESSION['cities']=popCity();
echo <<<END
                  </select>
                  <label class="cw">State</label>
                  <span class='cy'></span>
                  <select name="state" id="stateS" class="form-control custom-select sel" required="">
                  <option value="">Select State</option>
END;
                  $_SESSION['states']=popState();
echo <<<END
                  </select>
                  <label class="cw">Pincode</label>
                  <span class='cy'></span>
                  <input type="text" name="pin" class="form-control" placeholder="Type pincode" value="$pin" required>
              <br><button type="submit" name="submit_tea" class="btn btn-outline-success btn-block btn-lg">SUBMIT</button>
              </from>
END;
}

function student_pass_form($email)
 {
echo<<<EOT
              <form class="form-group" method="post" action="change_password.php" onsubmit="return valInputs()">
              <?php include('student_errors.php');
               ?>
                  <label class="cw">Previous Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password_p" class="form-control" placeholder="Type your previous password" required>
                  <label class="cw">Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password_1" class="form-control" placeholder="Type your password" required>
                  <label class="cw">Re-enter password</label>
                  <input type="Password" name="password_2" class="form-control" placeholder="Type your password" required>          
              <br><button type="submit" name="submit_stu" class="btn btn-outline-success btn-block btn-lg" onclick="return valInputs()">SUBMIT</button>
            </form>
EOT;
}

function teacher_pass_form($email)
{
echo <<<END
              <form class="form-group" method="post" action="change_password.php" onsubmit="return valInputs()">
              <?php include('student_errors.php');?>
                  <label class="cw">Previous Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password_p" class="form-control" placeholder="Type your previous password" required>
                  <label class="cw">Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password_1" class="form-control" placeholder="Type your password" required>
                  <label class="cw">Re-enter password</label>
                  <input type="Password" name="password_2" class="form-control" placeholder="Type your password" required>    
              <br><button type="submit" name="submit_tea" class="btn btn-outline-success btn-block btn-lg" onclick="valInputs()">SUBMIT</button>
              </from>
END;
}