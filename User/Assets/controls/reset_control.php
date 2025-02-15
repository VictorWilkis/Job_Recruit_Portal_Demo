<?php
    // Database Connection
    require 'db_connect.php';

    // session:
    session_start();

    // errors:
    $errors = array();

    // success:
    $success = array();

    if (isset($_POST['change'])){
        // collect confirm data:
        $Password = $_POST['New Password'];
        $CPassword = $_POST['Confirm Password'];

        if (empty($Password)){
            $errors['status'] = "Please Enter New Password";
            
        } elseif (empty($CPassword)){
            $errors['status'] = "Please Confirm New Password";
          }
        else{
            if($Password==$CPassword){
                // action:
                $old = $_SESSION['User_Password'];

                // checking if new password is the same as the old password
                if(password_verify($Password, $old)){
                    $errors['status'] = "New Password Is The Same As Old Password"; 
                    
                }
                else{
                    $Email = $_SESSION['User_Email'];
                    $Name1 = $_SESSION['User_Name'];
    
                    $secure = password_hash($Password,PASSWORD_DEFAULT);

                    $update_pass = "UPDATE users SET Password = '$secure' WHERE email ='$Email'";
                    $update_res = mysqli_query($connect, $update_pass);

                    if($update_res){
                        $_SESSION['Change'] = "Your Password Has Been Change Successfully Please Login With Your New Password";
                        // redirect to reset password
                        header('Location: index.php?passwordchanged'.$Email);
                        
                    }
                    else{
                        $errors['pass-error'] = "Database Failed while updating Password Try Again Later!";
                    }



                }
            }
            else{
                $errors['status'] = "Password Do Not Match";
            }
        }
    }
?>