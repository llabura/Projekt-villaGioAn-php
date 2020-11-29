<?php 
print'
<h1>Kontaktirajte nas</h1>
<div id="contact">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d750896.5392483312!2d13.969909674557348!3d45.25119008930057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477b626ac0b3bbc5%3A0x1f00c2188d542fbb!2sVilla+GioAn!5e0!3m2!1sen!2shr!4v1509892505253" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
    <form action="http://work2.eburza.hr/pwa/responzive-page/send-contact.php" id="contact_form" name="contact_form" method="POST">
        <label for="fname">Ime *</label>
        <input type="text" id="fname" name="firstname" placeholder="Vaše ime.." required>

        <label for="lname">Prezime *</label>
        <input type="text" id="lname" name="lastname" placeholder="Vaše prezime.." required>
        
        <label for="lname">E-mail *</label>
        <input type="email" id="email" name="email" placeholder="Vaša e-mail adresa.." required>

        <label for="country">Država</label>
        <select id="country" name="country">
          <option value="">Odaberite</option>
          <option value="BE">Belgium</option>
          <option value="HR" selected>Croatia</option>
          <option value="LU">Luxembourg</option>
          <option value="HU">Hungary</option>
        </select>

        <label for="subject">Predmet</label>
        <textarea id="subject" name="subject" placeholder="Upišite nešto.." style="height:200px"></textarea>

        <input type="submit" value="Potvrdi">
    </form>
</div>';
?>