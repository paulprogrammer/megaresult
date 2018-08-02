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
				<td><?php= $contest->id ?></td>
				<td><?php= $contest->event_name ?></td>
				<td><?php= $contest->event_slug ?></td>
				<td><?php= $contest->venue ?></td>
				<td><?php= $contest->start_date ?></td>
				<td><?php= $contest->end_date ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</div>