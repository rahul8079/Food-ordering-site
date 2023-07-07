<?php
session_start();

if (isset($_GET['category_ref'])) {
    $categoryRef = $_GET['category_ref'];

    switch ($categoryRef) {
        case 'category_id':
            $orderBy = 'category_id ASC';
            break;
        case 'category_name':
            $orderBy = 'category_name ASC';
            break;
        case 'description':
            $orderBy = 'description ASC';
            break;
        case 'status':
            $orderBy = 'status ASC';
            break;
        default:
            $orderBy = 'category_id ASC';
            break;
    }

    $_SESSION['order_by'] = $orderBy;
    echo "success";
} else {
    echo "error";
}
?>
