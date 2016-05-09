<?php
    if(isset($_SERVER["RDS_HOSTNAME"])){
        //do nothing we are in production and have ENV vars already
    }else{
        include "localhost_conf.php";
    }
?>
<?php
    define("ADMIN_USERNAME_STR", $_SERVER["RDS_USERNAME"]);
    define("DATABASE_PORT_STR",  $_SERVER["RDS_PORT"]);
    define("DATABASE_NAME_STR",  $_SERVER["RDS_DB_NAME"]);
    define("HOST_IP_STR", $_SERVER["RDS_HOSTNAME"]);
    define("DB_PASSWORD_STR", $_SERVER["RDS_PASSWORD"]);
    $query_str = "";
    $status_str = "";
    $cmd_str = "";
    $pdo = "";
    $con_str = "mysql:host=".HOST_IP_STR.";port=".DATABASE_PORT_STR;
    $pdo = new PDO($con_str, ADMIN_USERNAME_STR, DB_PASSWORD_STR);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS ".DATABASE_NAME_STR);
    $pdo->exec("use ".DATABASE_NAME_STR);
    $sql = "CREATE TABLE IF NOT EXISTS `names` (
    `names_id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(25) NOT NULL,
    `gender` varchar(7) NOT NULL,
    PRIMARY KEY (`names_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    $sql = trim($sql);
    $count1 = $pdo->exec($sql);
    $val = "INSERT INTO names (name, gender)
    VALUES
    ('Rick', 'male'),
    ('Marko', 'male'),
    ('Diyah', 'female'),
    ('Sally', 'female'),
    ('Jim', 'male'),
    ('William', 'male'),
    ('Majeed', 'male'); ";
    $val = trim($val);
    $count2 = $pdo->exec($val);
    $select = "SELECT * FROM names ORDER BY gender LIKE 'male'";
    foreach($pdo->query($select) as $row){
        print $row['gender'] . ' - ' . $row['name'] . "<br />\r\n";
    }
    echo "Inserted some names";
?>