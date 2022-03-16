<?php

function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}


function convertSqlDate($sqlDate)
{
    /* @var $date DateTime */
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);
    return $date->format('d M Y');
}

function countCommentsForPost($postId)
{
    $conn = $GLOBALS['mysqli'];
    //isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;
    $query = "SELECT COUNT(*) c FROM comment WHERE post_id = $postId";
    $stmt = mysqli_query($conn, $query);
    return (int) $stmt->fetch_column();
}

function getCommentsForPost($postId)
{

    $conn = $GLOBALS['mysqli'];
    isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;
    $query = "SELECT id, name, text, created_at FROM comment WHERE post_id = $postId";
    $stmt = mysqli_query($conn, $query);
    return $stmt;
}