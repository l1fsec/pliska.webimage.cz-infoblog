<?php
session_start();

//Kontrola dat, cerpa se to z inputu z atirbutu name="name"
if ( !isset($_POST['name'], $_POST['psw']) ) {

	// Data nepřístupná, nic jsme nezadali a proto to neodesle
	exit('Prosím vyplňte všechna pole!');
}
//.....................Tohle resi kontrolu, selectujeme data................................
if ($stmt = $con->prepare('SELECT id, psw FROM accounts WHERE name = ?')) {
	$stmt->bind_param('s', $_POST['name']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $psw);
	$stmt->fetch();
//--------------------------------------------------------------------------


	if ($_POST['psw'] === $psw) { //Uspěšně připojeno
		//regenuruji session
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['name'];
		//tady budeme potrebovat neco udelat, ckj.
		$_SESSION['id'] = $id;
		header('Location: prihlaseno.php');
	}
	}
} else {
	//tohle te odesle zpatky na index, pokud jsou wrong credentials
	header('Location: index.html');
}


	$stmt->close();
?>
