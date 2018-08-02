<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
global $wpdb;

$contests = $wpdb->get_results("select * from mr_event");

wp_enqueue_style("megaresult_admin", get_template_directory_uri() . '/megaresult_admin.css');
wp_enqueue_script("jquery");
wp_enqueue_style("datatables", plugins_url( '/js/datatables.min.css', __FILE__));
wp_enqueue_script("datatables", plugins_url( '/js/datatables.min.js', __FILE__));
?>
<div id="megaresult-admin">

	<h1>MegaResult Administration</h1>

	Administrate your contests here.  Add a new contest by using the "add contest" button below.
	Add or administrate results for your existing contests below.


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