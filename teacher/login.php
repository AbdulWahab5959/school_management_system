<?php

require_once('../includes/db.php');
 
if(isset($_POST['submit']))
{
	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
	{
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$sql = "select * from staff where email = :email ";
			$handle = $pdo->prepare($sql);
			$params = ['email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0)
			{
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $getRow['password']))
				{
					unset($getRow['password']);
					$_SESSION['user_id']=($getRow['user_id']);
					$_SESSION['name']=($getRow['name']);
					$_SESSION['email']=($getRow['email']);
					$_SESSION['user_type']=($getRow['user_type']);
				
					header('location:index.php');
					exit();
				}
				else
				{
					$errors[] = "Wrong  Password";
				}
			}
			else
			{
				$errors[] = "Wrong Email";
			}
			
		}
		else
		{
			$errors[] = "Email address is not valid";	
		}
 
	}
	else
	{
		$errors[] = "Email and Password are required";	
	}
 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Admin Login</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../dashboard_assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="../dashboard_assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="../dashboard_assets/css/style.css">
     </head>
  <body>
        <div class="wrapper">
        <?php 
				if(isset($errors) && count($errors) > 0)
				{
					foreach($errors as $error_msg)
					{
						echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.
							$error_msg.
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'.
						'</div>';
					}
				}
			?>
        <div class="container">
            <div class="col-left">
            <div class="login-text">
                <h1>Welcome Back</h1>
            </div>
            </div>
            <div class="col-right">
            <div class="login-form">
                <h2>Login</h2>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <p>
                    <label for="email"> Email address<span>*</span></label>
                    <input type="text" id="email" name="email" placeholder="Username or Email"  required>
                </p>
                <p>
                    <label for="password">Password<span>*</span></label>
                    <input type="password"  id="password" name="password" placeholder="Password" required>
                </p>
                <p>
                    <input type="submit" name="submit" value="Sing In" />
                </p>
                </form>
            </div>
            </div>
        </div>
        
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="../dashboard_assets/js/core/bootstrap.min.js"></script>
		 </body>
</html>
