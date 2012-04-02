<form name="Luo käyttäjä" action="klisays.php" method="post" ><pre>
Käyttäjänimi:	<input type="text" autofocus name="kayttajanimi" maxlength="20" pattern="^[a-öA-Ö][a-öA-Ö0-9-_\.]{1,20}$" required placeholder="Käyttäjänimi" />
Sähköposti:	<input type="text" name="sahkoposti" placeholder="Sähköposti" />
Salasana: 	<input type="password" name="salasana" required placeholder="Salasana" maxlength="20"/>
Ylläpitäjä?	<select name="admin">
  <option value="t">Kyllä</option>
  <option value="f" selected>Ei</option>
</select>
<input type="submit" />
</pre>
</form>

