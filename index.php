<?php 
        # Stop Hacking attempt
        define('__APP__', TRUE);
        
        # Start session
        session_start();

        # Database connection
        include ("dbconn.php");
        
        # Variables MUST BE INTEGERS
        if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
        if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
        
        # Variables MUST BE STRINGS A-Z
        if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
        
        if (!isset($menu)) { $menu = 1; }
        
        # Classes & Functions
        include_once("functions.php");

print '
<!DOCTYPE html>
<html>
    <head>
            
             <!-- CSS -->
            <link rel="stylesheet" href="css/style.css">
            <link rel="shortcut icon" href="img/favicon.ico">
            <!-- End CSS -->
            <title>Villa GioAn | Croatia</title>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <meta name="description" content="Villa GioAn">
            <meta name="keywords" content="Villa, GioAn, vacation house, family vacation">
            <meta name="author" content="Lucija Labura">
            <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    </head>
<body>
        <header>
                <div'; if ($menu > 1) { print ' class="villa-subimage"'; } else { print ' class="villa-image"'; }  print '></div>
                <nav>';
                    include("menu.php");
                print '</nav>
        </header>
        <main>';
            
        if (isset($_SESSION['message'])) {
			print $_SESSION['message'];
			unset($_SESSION['message']);
		}
	
	# Homepage
	if (!isset($menu) || $menu == 1) { include("home.php"); }
	
	# News
	else if ($menu == 2) { include("news.php"); }
	
	# Contact
	else if ($menu == 3) { include("contact.php"); }
	
	# About us
	else if ($menu == 4) { include("about.php"); }
	
	# Register
    else if ($menu == 5) { include("register.php"); }
    
    # Signin
	else if ($menu == 6) { include("signin.php"); }
	
	# Admin webpage
	else if ($menu == 7) { include("admin.php"); }
	
        print '
        </main>
        <footer>
            <p>Copyright &copy; 2020 Lucija Labura<a href="https://github.com/llabura/Projekt-villa-GioAn"><img src="img/github_icon.png" title="Github" alt="Github"></a></p>
        </footer>
    </body>
    </html>';
?>