<form name="Luo käyttäjä" action="klisays.php" method="post" ><pre>
Käyttäjänimi:	<input type="text" autofocus name="kayttajanimi" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" required placeholder="Käyttäjänimi" />
Sähköposti:	<input type="text" name="sahkoposti" placeholder="Sähköposti" />
Salasana:	<input type="password" name="salasana" required placeholder="Salasana" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" />
Ylläpitäjä?	<select name="admin">
  <option value="t" selected>Kyllä</option>
  <option value="f">Ei</option>
</select>
<input type="submit" />
</pre>
</form>

