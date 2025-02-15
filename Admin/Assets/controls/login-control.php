<?php
    session_start();
    // Database Connection
    require 'db_connect.php';

    $message = ""; // Store feedback messages
    
    if (isset($_POST['login'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_input = trim($_POST['email']); // Username or Email
            $password = trim($_POST['password']);
    
            // Check if input is empty
            if (empty($user_input) || empty($password)) {
                $message = "<div class='alert alert-danger'>Please enter your email/username and password!</div>";
            } 
            else {
                // Check if the user exists (username or email)
                $sql = "SELECT * FROM admin WHERE email = ?";
                $stmt = mysqli_stmt_init( $conn);
    
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    $message = "<div class='alert alert-danger'>sql error in connecting</div>";
                }
                else{
                    mysqli_stmt_bind_param($stmt,'s',$user_input);
                    mysqli_stmt_execute($stmt);

                    //fetch result
                    $result = mysqli_stmt_get_result($stmt);
    
                    //if user doesn't exit
                    if(mysqli_num_rows($result) != 1){
                        $message = "<div class='alert alert-danger'>Incorrect username</div>";
                        
                    }
    
                    // password verification
                    while ($row = mysqli_fetch_assoc($result)){
                        // decrypting encrypted password during verification
                        if (password_verify($password, $row['password'])){
                            $_SESSION['admin_id'] = $row['id'];
                            $_SESSION['admin_role'] = $row['role'];
                            $_SESSION['admin_email'] = $row['email'];
                            $_SESSION['admin_username'] = $row['username'];
                            $_SESSION['admin_password'] = $row['password'];
                            $_SESSION['admin_regdate'] = $row['date_created'];
    
    
                            if (mysqli_stmt_execute($stmt)){
                                header('Location: dashboard.php');
    
                            }
                            else{
                                // if sql execution was not successful
                                $message = "<div class='alert alert-danger'>sql execution was not successful</div>";
                                
                            }
    
                        }
                        else{
                            $message = "<div class='alert alert-danger'>incorrect password</div>";
                           
                        }
                        
                    }
                }
    
            }
        }
    }

?>