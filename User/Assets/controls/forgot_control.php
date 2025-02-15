<?php
    // Database Connection
    require 'db_connect.php';

    // session:
    session_start();

    // errors:
    $errors = array();

    // success:
    $success = array();

    if(isset($_POST['confirm'])){

        // collecting Data:
        $email = $_POST['email'];
        $phone = $_POST['name'];

        if (empty($email)){
            $errors['status'] = "Enter Email";
            
        }elseif (empty($phone)){
            $errors['status'] = "Enter Username";
        }
        else{
            // checking if the email exist
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_stmt_init($connect);

            if (!mysqli_stmt_prepare($stmt, $sql)){
                $errors['db-error'] = "Database Error Please Try Again Later";
            }
            else{
                mysqli_stmt_bind_param($stmt,'s',$email);
                mysqli_stmt_execute($stmt);

                
                //fetch result
                $result = mysqli_stmt_get_result($stmt);

                //if user doesn't exit
                if(mysqli_num_rows($result) != 1){
                    $errors['failure'] = "Email Do Not Exist";
                }
                else{
                  // checking if the phone number match the existing email
                        while ($row = mysqli_fetch_assoc($result)){
                            if($phone == $row['username']){
                                $_SESSION['User_Email'] = $email;
                                $_SESSION['User_Password'] = $row['password'];
                                $_SESSION['User_Name'] = $row['username'];
                                $_SESSION['User_Skill'] = $row['skills'];
                                $_SESSION['User_RegDate'] = $row['date_created'];

                                
                                // redirect to reset password
                                header('Location: index.php?'.$Email);

                            }
                            else{
                                //if phone number do not match the existing email
                                $errors['failure'] = "Username Do Not Match";
                                
                            }
                        }
                }
            }
        }
    }
?>