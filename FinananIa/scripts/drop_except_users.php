<?php
// Borra todas las tablas excepto 'users' y 'migrations' en la base de datos finania
$host='127.0.0.1';
$port=3306;
$user='root';
$pass='';
$db='finania';
$keep = ['users','migrations'];
try{
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if(!$tables){
        echo "No tables found.\n";
        exit(0);
    }
    $toDrop = array_filter($tables, function($t) use($keep){ return !in_array($t,$keep); });
    if(empty($toDrop)){
        echo "No tables to drop.\n";
        exit(0);
    }
    echo "Tables detected:\n".implode(', ', $tables)."\n\n";
    echo "Will drop the following tables (keeping: ".implode(', ',$keep)."):\n".implode(', ',$toDrop)."\n\n";
    // Disable foreign key checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
    foreach($toDrop as $t){
        echo "Dropping: $t ... ";
        $pdo->exec("DROP TABLE IF EXISTS `$t`");
        echo "DONE\n";
    }
    // Re-enable FK checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    echo "\nAll done.\n";
} catch(PDOException $e){
    echo 'ERR: '.$e->getMessage()."\n";
    exit(1);
}
