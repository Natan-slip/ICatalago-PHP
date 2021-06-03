<?php

$senha = password_hash("654321", PASSWORD_DEFAULT);

var_dump(password_verify("123456",$senha));

echo $senha;



echo "<br>";