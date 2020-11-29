<?php 
	print '
	<h1>Registracija</h1>
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="fname">Ime *</label>
			<input type="text" id="fname" name="firstname" placeholder="Vaše ime.." required>
			<label for="lname">Prezime *</label>
			<input type="text" id="lname" name="lastname" placeholder="Vaše prezime.." required>
				
			<label for="email">E-mail *</label>
			<input type="email" id="email" name="email" placeholder="Vaša e-mail adresa.." required>
			
			<label for="username">Korisničko ime:* <small>(Korisničko ime mora sadržavati minimalno 5 i maksimalno 10 znakova)</small></label>
			<input type="text" id="username" name="username" pattern=".{5,10}" placeholder="Korisničko ime.." required><br>
            
            <label for="city">Grad:* </label>
            <input type="text" id="city" name="city" placeholder="Grad.." required><br>
            
            <label for="street">Ulica:* </label>
			<input type="text" id="street" name="street" placeholder="Ulica.." required><br>
			
									
			<label for="password">Lozinka:* <small>(Lozinka mora sadržavati minimalno 4 znaka)</small></label>
			<input type="password" id="password" name="password" placeholder="Lozinka.." pattern=".{4,}" required>
			<label for="country">Država:</label>
			<select name="country" id="country">
				<option value="">molimo odaberite</option>';
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM countries";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
				}
			print '
			</select>
			<input type="submit" value="Potvrdi">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if ($row['email'] == '' || $row['username'] == '') {
			# password_hash https://secure.php.net/manual/en/function.password-hash.php
			# password_hash() creates a new password hash using a strong one-way hashing algorithm
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO users (firstname, lastname, email, username, password, country, city, street)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "', '" . $_POST['city'] . "', '" . $_POST['street'] . "')";
			$result = @mysqli_query($MySQL, $query);
			
			# ucfirst() — Make a string's first character uppercase
			# strtolower() - Make a string lowercase
			echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', hvala na registraciji! </p>
			<hr>';
		}
		else {
			echo '<p>Korisnik s ovom e-mail adresom ili korisničkim imenom već postoji!</p>';
		}
	}
	print '
	</div>';
?>