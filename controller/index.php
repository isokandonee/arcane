

    <?php
    // Connect to the database
    require "connect.php";
    
    // Check if the form has been submitted
    if (isset($_POST['token'])) {
        // Get the form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $phone = $_POST['phone'];
    
        // Validate the form data
        // Check for empty fields
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($cpassword)) {
            header("Location: ../index.php?error=emptyfields&firstname=".$firstname."lastname=".$lastname."mail=".$email);
            exit;
        }
    
        // Email validation
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?error=invalidmail&firstname=".$firstname."lastname=".$lastname);
            exit;
        }
        
        // First and Lastname validation
        // elseif (!preg_match('/^[a-zA-Z]*$/', $firstname) || !preg_match('/^[a-zA-Z]*$/',$lastname)) {
        //     header("Location: ../index.php?error=incorrectdetails&mail=".$email);
        //     exit;
        // }
       
        // Password validation
        elseif (!preg_match('/[a-zA-Z\d]{8,}$/', $password)) {
            header("Location: ../index.php?error=weakpassword&firstname=".$firstname."lastname=".$lastname."mail=".$email);
            exit;
        }
    
        // Check if password and confirm password match
        elseif ($cpassword !== $password) {
            header("Location: ../index.php?error=passwordsdonotmatch&firstname=".$firstname."lastname=".$lastname."mail=".$email);
            exit;
        }
        else {
            // Insert the user's data into the database
            // Hash the password using password_hash() function
            $hpassword = password_hash($password, PASSWORD_DEFAULT, $o);
    
            // Using prepared statement to insert the data safely
            $stmt = mysqli_prepare($conn, "INSERT INTO user_tb (first_name, last_name, email, password, phone, created_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP())");
            mysqli_stmt_bind_param($stmt, 'sssss', $firstname, $lastname, $email, $hpassword, $phone);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../login.php?signup=success");
                exit;
            }
        }
    }