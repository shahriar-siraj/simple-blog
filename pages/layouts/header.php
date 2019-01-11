<!DOCTYPE html>
<html lang="en">

<head>
    <title>Simple Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-inverse navbar-custom">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Simple Blog</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo BASE_URL . '/blog'; ?>">Blogs</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a target="_blank" href="<?php echo BASE_URL . '/admin'; ?>"><span class="glyphicon glyphicon-log-in"></span> Admin Panel</a></li>
            </ul>
        </div>
    </nav>

    <style>
    body 
    {
        background: #fff;
    }

    .card 
    {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin: 10px 0;
        -webkit-box-shadow: 0 0px 20px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 0 0px 20px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
    }

    .card .title 
    {
        color: #175676;
        margin-top: 0;
    }

    .panel-custom 
    {
        border-color: #175676;
    }
    
    .panel-custom a
    {
        color: #175676;
    }

    .panel-custom .panel-heading 
    {
        color: #fff;
        background-color: #175676;
        border-color: #175676;
    }

    .btn-custom
    {
        color: #fff;
        background: #45B69C;
        border: none;
    }

    .navbar-custom
    {
        color: #fff;
        background: #175676;
        border: none;
    }

    .navbar-custom .navbar-brand
    {
        color: #fff;
        font-family: 'Pacifico', cursive;
    }

    .navbar-custom .navbar-nav>li>a
    {
        color: #fff;
    }

    @media (min-width: 768px)
    {
        .navbar 
        {
            border-radius: 0;
        }
    }
    </style>