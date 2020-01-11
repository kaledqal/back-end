<h1><?= $title ?></h1>
<table class="table table-hover table-light">
	<thead>
		<tr class="header-row">
			<th scope="col">Name</th>
			<th scope="col">Age</th>
			<th scope="col">Location</th>
			<th scope="col">Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($athletes as $athlete) : ?>
	<tr>
		<td><?php echo "{$athlete['first_name']} {$athlete['last_name']} "?></td>
		<td><?php echo "{$athlete['age']} "?></td>
		<td><?php echo "{$athlete['city']}, {$athlete['province']} "?></td>
		<td><a class="space-between" href="<?php echo site_url("athletes/athlete/{$athlete['pl_id']}") ?>">VIEW</a><a href="<?php echo site_url("athletes/athlete/delete/{$athlete['pl_id']}") ?>">DELETE</a></td>
		<?php endforeach; ?>
		</tr>
	</tbody>
</table>





