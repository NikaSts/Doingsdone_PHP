<?php

require_once 'init.php';

session_destroy();

header("Location: /guest.php");
