<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (isset($_POST["page"])) {
        $page_no = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        if(!is_numeric($page_no))
            die("Error fetching data! Invalid page number!!!");
    } else {
        $page_no = 1;
    }

    require $lien.'pages/conn_bdd.php';

    $row_limit = 10;

    // get record starting position
    $start = (($page_no-1) * $row_limit);

    $results = $conn->prepare("SELECT * FROM plats ORDER BY Id LIMIT $start, $row_limit");
    $results->execute();

    while($row = $results->fetch(PDO::FETCH_ASSOC)) {

        echo '<tr>
            <th scope="row" class="align-middle text-center">'.$row['Id'].'</th>
            <td class="align-middle text-center">'.$row['Nom'].'</td>
            <td class="align-middle text-center">'.$row['Id_Categorie'].'</td>
            <td class="align-middle text-center">'.$row['Description'].'</td>
            <td class="align-middle text-center">'.$row['Image'].'</td>
            <td class="align-middle text-center">'.$row['Visible'].'</td>
            <td class="align-middle text-center">
                <div class="d-flex flex-row">
                    <div>
                        <button type="button" class="btn open_modal" data-id="'.$row['Id'].'" name="mod_'.$row['Id'].'">
                            <i name="mod_'.$row['Id'].'" class="fas fa-pen" data-id="'.$row['Id'].'" id="mod_'.$row['Id'].'"></i>
                        </button>
                    </div>
                    <div >
                        <button type="button" class="btn" onclick="Suppr_plat(event)" name="del_'.$row['Id'].'">
                            <i name="del_'.$row['Id'].'" class="fas fa-trash-can" id="del_'.$row['Id'].'"></i>
                        </button>
                    </div>
                </div>
            </td>
        </tr>';
    }

?>