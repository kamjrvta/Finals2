<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;


$stmt = $pdo->prepare('SELECT * FROM records ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of records, this is so we can determine whether there should be a next and previous button
$num_records = $pdo->query('SELECT COUNT(*) FROM records')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>List of Registered Students ID</h2>
	<table>
        <thead>
            <tr>
                <td>ID Number</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Address</td>
                <td>Phone Number</td>
                <td>Course</td>
                <td>Birthdate</td>
                <td>Contact Person</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $records): ?>
            <tr>
                <td><?=$records['id']?></td>
                <td><?=$records['first_name']?></td>
                <td><?=$records['last_name']?></td>
                <td><?=$records['address']?></td>
                <td><?=$records['phone']?></td>
                <td><?=$records['course']?></td>
                <td><?=$records['birthdate']?></td>
                <td><?=$records['contact']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$records['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$records['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_records): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>