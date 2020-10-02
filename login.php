<?php 
  ob_start();
  session_start();
  $pageTitle = 'Login';
  if(isset($_SESSION['user'])) {
    header('Location: index.php');// redirect to Homepage
    }
  include 'init.php';
  // check if user coming from http post request
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['login'])){
      $user = $_POST['username'];
      $pass = $_POST['password'];
      $hashedPass = sha1($pass);
      //check if the user exist in database
      $stmt = $con->prepare("SELECT
                                  userID, Username, Password
                              FROM
                                  users
                              WHERE
                                  Username = ?
                              AND
                                  Password = ?");
      $stmt->execute(array($user,$hashedPass));
      $get = $stmt->fetch();
      $count = $stmt->rowCount();
      //if count > 0 this mean the database contain record about this username
      if($count > 0 ){
        $_SESSION['user'] = $user; // register session name
        $_SESSION['uid'] = $get['userID']; // Register User ID In Session
        print_r($_SESSION);
        header('Location: index.php'); // redirect to home page
        exit();
        }
        }else{
          $formErrors  = array();
          $username    = $_POST['username']; 
          $password    = $_POST['password'];
          $email       = $_POST['email'];
          if (isset($username)){
            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
            if (strlen($filterdUser) < 4 ){$formErrors []= "Username Must Be Larger Than 4 Characters";}
            echo $filterdUser;
            }
          if (isset($password) && isset($_POST['password2']) ){
            if (empty($password)){$formErrors[] = " Sorry Password Can't Be Empty";}
            $pass1 =sha1($password);
            $pass2 =sha1($_POST['password2']);
            if ($pass1 !== $pass2){$formErrors [] = 'Sorry Password Is Not Match';}
            }
          if (isset($email)){
            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL ) != true){ $formErrors[]= "This Email Is Not Valid";}
            echo $filterdUser;
            }
          // Check If There's No Error Proceed The User Add
          if(empty($formErrors)){
            // Check If User Exist In Database
            $check = checkItem("Username", "users", $username);
            if($check == 1){
              $formErrors[]="Sorry This User Is Exist";
              }else{
                // Insert Userinfo In Database
                  $stmt = $con->prepare("INSERT INTO users(	Username , Password, Email, RegStatus, Date) VALUES(:zuser, :zpass, :zmail, 0, now())");
                  $stmt->execute(array(
                    'zuser'=> $username,
                    'zpass'=> $pass1,
                    'zmail'=> $email,
                    ));
                  //Echo Success Massage
                  $succesMsg = "Congrats You Are Now Registerd User";
                }
          }
      }
    }
?>
  <div>
  <div class="container login-page">
    <h1 class="text-center">
      <span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
    </h1>
    <!--------------------------------------------- Start Signup form --------------------------------->
      <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Username"/>
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password"/>
        <input class="btn btn-primary btn-block" name="login" type="submit"  value="Login"/>
      </form>
    <!--------------------------------------------- Start Signup form --------------------------------->
      <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <div class="input-container">
          <input pattern=".{4,8}" title="Username Must Be Between 4&8 Chars" class="form-control" type="text" name="username" autocomplete="off" placeholder=" Type Your Username" required/>
        </div>
        <div class="input-container">
          <input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type A Complex Password" required/>
        </div>
        <div class="input-container">
          <input minlength="4" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Type A Password Again" required/>
        </div>  
        <div class="input-container">
          <input class="form-control" type="email" name="email" autocomplete="new-password" placeholder="Type A Valid Email" required/>
          <input class="btn btn-success btn-block" name="signup" type="submit"  value="Signup"/>
        </div>
      </form>
    <div class="the-errors text-center">
      <?php 
        if (!empty($formErrors)){
          foreach ($formErrors as $error){
            echo $error . "<br>";
            }
          }
        if (isset($succesMsg)){
          echo "<div class='msg success'>" . $succesMsg . "</div>";
        }
      ?>
    </div>
  </div>
</div>

<?php include $tpl . 'footer.php';
ob_end_flush();
?>