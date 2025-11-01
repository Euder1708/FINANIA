<?php
$host='127.0.0.1';
$port=3306;
$user='root';
$pass='';
$db='finania';
try{
    $pdo=new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $tables=$pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables:\n".implode("\n",$tables)."\n\n";
    foreach(['users','llaves'] as $t){
        if(in_array($t,$tables)){
            echo "--- $t (up to 5 rows) ---\n";
            $stmt=$pdo->query("SELECT * FROM `$t` LIMIT 5");
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if($rows){
                foreach($rows as $r){
                    echo json_encode($r, JSON_UNESCAPED_UNICODE)."\n";
                }
            } else{
                echo "(no rows)\n";
            }
            echo "\n";
        }
    }
} catch(PDOException $e){
    echo 'ERR: '.$e->getMessage();
}
