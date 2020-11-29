<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '
		<h1>Admin panel</h1>
		<div id="admin">
			<ul>
				<li><a href="index.php?menu=7&amp;action=1">Korisnici</a></li>
				<li><a href="index.php?menu=7&amp;action=2">Vijesti</a></li>
			</ul>';
			# Admin Users
			if ($action == 1) { include("admin/users.php"); }
			
			# Admin News
			else if ($action == 2) { include("admin/news.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Molimo vas da se registrirate ili ulogirate svojim podacima!!</p>';
		header("Location: index.php?menu=6");
	}
?>