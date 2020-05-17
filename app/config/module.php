<?php


function isUserLoggedIn()
{
    if($_SESSION['user'])
        return true;
    return false;
}