<?php 
include('_fn.php');

$prod_n = $_POST['prod_n']; //  name
$prod_q = $_POST['prod_q']; //quantity
$prod_f = $_POST['prod_f']; //fuature
$prod_i = $_POST['prod_i']; //image

//exit($prod_name . '' . $prod_q . '' .$prod_f. ''.$prod_im);

prod_add_save($prod_n,$prod_q,$prod_f,$prod_i);

?>