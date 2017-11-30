<?php
include'header.php';



function paginate ($dbcon){
    
    $sql = 'SELECT COUNT(*) as numberofrows FROM appointment';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;
    
    
    $rows = 25;
    $pages = ceil($numberofrows / $rows);
 
    
    echo '<ul>';
    for($i = 1; $i <= $pages; $i++){
        echo '<li>';
        echo '<a href="afspraken.php/?page='.$i.'">'.$i.'</a>';
        echo '</li>';
    }
    echo '</ul>';
    
    if(isset($_GET['id'])){
        $afspraakId = $_GET['id'];
        $sql = 'SELECT * from appointment where id = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$afspraakId]);
        $data =  $stmt->fetchAll();
        var_dump($data);
    }
    
    
    if(isset($_GET['page'])){
        getAfspraakinfo($dbcon, $_GET['page']);
    }else{
        
    }
}

paginate($dbcon);

include'footer.php';
?>