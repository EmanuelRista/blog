<?php

function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}