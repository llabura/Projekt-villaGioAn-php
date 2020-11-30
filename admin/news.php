<?php

    if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false'){
        header("Location: index.php?menu=6");
	}
	
    else if($_SESSION['user']['valid'] == 'true'){
		#Add news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
	
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO news (title, description, archive)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['archive'] . "')";
		$result = @mysqli_query($MySQL, $query);
		
		$ID = mysqli_insert_id($MySQL);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku.</p>';
			}
        }
		
		
		$_SESSION['message'] .= '<p>Uspješno ste dodali vijesti!</p>';
	
		
		# Redirect
		header("Location: index.php?menu=7&action=2");
	}
        if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
            $query  = "UPDATE news SET title='" . $_POST['title'] . "', description='" . $_POST['article'] . "', picture='" . $_POST['picture'] . "'";
            $query .= " WHERE id=" . (int)$_POST['edit'];
            $query .= " LIMIT 1";
            $result = @mysqli_query($MySQL, $query);
            # Close MySQL connection
            @mysqli_close($MySQL);
            
            $_SESSION['message'] = '<p>Uspjesno ste unijeli promjene!</p>';
            
            # Redirect
            header("Location: index.php?menu=7&action=1");
        }
        if (isset($_GET['delete']) && $_GET['delete'] != '') {
            if ($_SESSION['user']['role'] == 1) {
            $query  = "DELETE FROM news";
            $query .= " WHERE id=".(int)$_GET['delete'];
            $query .= " LIMIT 1";
            $result = @mysqli_query($MySQL, $query);

            $_SESSION['message'] = '<p>Uspjesno ste obrisali clanak!</p>';
		
            # Redirect
            header("Location: index.php?menu=7&action=1");
			}else{
				header("Location: index.php?menu=7&action=2");
				print '<p>Zabranjeno</p>';
				
			}
			
		}
		#Add news 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2) {
		
		print '
		<h2>Dodaj vijesti</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" placeholder="News title.." required>
			<label for="description">Opis *</label>
			<textarea id="description" name="description" placeholder="News description.." required></textarea>
				
			<label for="picture">Slika</label>
			<input type="file" id="picture" name="picture">
						
			<label for="archive">Arhiviraj:</label><br />
            <input type="radio" name="archive" value="Y"> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N" checked> NO
			
			<hr>
			
			<input type="submit" value="Potvrdi">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	else{
		header("Location: index.php?menu=7&action=2");
		print '<p>Zabranjeno</p>';
		
	}
}

        else if (isset($_GET['edit']) && $_GET['edit'] != '') {
            if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2) {
                $query  = "SELECT * FROM news";
                $query .= " WHERE id=".$_GET['edit'];
                $result = @mysqli_query($MySQL, $query);
                $row = @mysqli_fetch_array($result);
                $checked_archive = false;
                
				print '
		<h2>Edit news</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="News title.." required>
			<label for="description">Opis *</label>
			<textarea id="description" name="description" placeholder="News description.." required>' . $row['description'] . '</textarea>
				
			<label for="picture">Slika</label>
			<input type="file" id="picture" name="picture">
						
			<label for="archive">Arhiviraj:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
			
			<hr>
			
			<input type="submit" value="Potvrdi">
			
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
            }
            else {
                header("Location: index.php?menu=7&action=2");
				print '<p>Zabranjeno</p>';
            }
        }
        else{
        print'
        <h2>News</h2>
		<div id="news">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . pickerDateToMysql($row['date']) . '</td>
						<td>';
							if ($row['archive'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add news</a>
		</div>';
	}
}
	# Close MySQL connection
	@mysqli_close($MySQL);
?>