<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
global $wpdb;

$contests = $wpdb->get_results("select * from mr_event");
?>
<div>
<button id="add-contest">Add Contest</button>

<table>
	<thead>
		<tr>
			<th>Contest ID</th>
			<th>Contest Name</th>
			<th>Slug</th>
			<th>Venue</th>
			<th>Start Date</th>
			<th>End Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($contests as $contest): ?>
			<tr>
				<td><?php echo $contest->id; ?></td>
				<td><?php echo $contest->event_name; ?></td>
				<td><?php echo $contest->event_slug; ?></td>
				<td><?php echo $contest->venue; ?></td>
				<td><?php echo $contest->start_date; ?></td>
				<td><?php echo $contest->end_date; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</div>