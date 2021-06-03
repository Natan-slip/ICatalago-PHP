<?php

    //testando os hash
    
    echo md5("1234");

    echo "<br/> <br/>";

    echo sha1("1234");

    echo "<br/> <br/>";

    echo password_hash("123456", PASSWORD_DEFAULT);
    echo "<br/> <br/>";
    echo password_hash("112233", PASSWORD_DEFAULT);

