<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<style>
    *{ margin: 0; padding: 0; }
    
    .clearfix:after {
        content: ".";
        display: block;
        clear: both;
        visibility: hidden;
        line-height: 0;
        height: 0;
    }

    .clearfix {
        display: inline-block;
    }

    html[xmlns] .clearfix {
        display: block;
    }

    * html .clearfix {
        height: 1%;
    }
    ul { margin: 0; padding: 0; margin-left: 100px; list-style-type: none; }

    #left { float: left; width: 100px; }
    #right { float: left; }

    #foodWrap { float: left; clear: both; margin-bottom: 20px; }

    #wrapper{
        margin: 0 auto;
        width: 1000px;
        height: 800px;
    }

    #marginDiv{
        margin-bottom: 40px;
    }
</style>
<?php
$foodJson;
$date = date("Y/m/d");
if (!$foodJson = file_get_contents(
        "http://www.sodexo.fi/ruokalistat/output/daily_json/43/" .
        $date . 
        "/fi"
        )) {
    die("Invalid JSON");
}
require_once 'Enum.php';
$data = json_decode($foodJson, TRUE);
?>
<html>
    <head>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
        <title>Ruokalista</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div id ="wrapper">
            
            <div style="clear: both;"><p>OAMK:n Kaukovainion yksikön päivän ruokalista</p></div>
            <div id="marginDiv"></div>
            
            <?php
            foreach ($data[Enum::COURSES] as $var) {
                echo "<div id='foodWrap' class='clearfix'>";

                echo "<div id='left'>";
                echo "<span>";
                echo $var[Enum::CAT];
                echo "</span>";
                echo "</div>";

                echo "<div id='right'>";
                echo "<ul>";
                echo "<li>";
                echo $var[Enum::FI];
                echo "</li>";
                echo "<li>";
                echo $var[Enum::EN];
                echo "</li>";
                echo "</ul>";
                echo "</div>";

                echo "</div>";
            }
            ?>
            <div id="time" style="clear: both;">
                <p>
                    <?php echo "Client updated at: " . gmdate("Y-m-d H:i:s", $data[Enum::META][Enum::GEN_DAY]); ?>
                </p>
                <p>
                    <?php echo "Sodexo updated at: " . gmdate("Y-m-d H:i:s", $data[Enum::META][Enum::REQ_DAY]); ?>
                </p>
            </div>
        </div>
    </body>
</html>
