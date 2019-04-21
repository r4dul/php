<?php
function create_tables($conn)
{
	$ctables = "CREATE TABLE IF NOT EXISTS users (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) unique NOT NULL,
	password VARCHAR(255) NOT NULL,
	role int NOT NULL
);";
	mysqli_query($conn, $ctables);
	$ctables = "CREATE TABLE IF NOT EXISTS category (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255)
);";
	mysqli_query($conn, $ctables);
	$ctables = "CREATE TABLE IF NOT EXISTS product (
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	link VARCHAR(255),
	price float NOT NULL
);";
	mysqli_query($conn, $ctables);
	
	$ctables = "CREATE TABLE IF NOT EXISTs cat_prod (
	idCat int NOT NULL,
	idProd int(11) NOT NULL,
	Foreign key (idCat) references category(id),
	Foreign key (idProd) references product(id),
	unique (idCat, idProd)
);";
	mysqli_query($conn, $ctables);
}
?>