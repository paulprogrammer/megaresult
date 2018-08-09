<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
global $wpdb;

$contests = $wpdb->get_results("select * from mr_event");

wp_enqueue_style("megaresult_admin", plugins_url( '/megaresult_admin.css', __FILE__));
wp_enqueue_script("megaresult_admin", plugins_url( '/megaresult_admin.js', __FILE__), ["jquery"]);
wp_enqueue_style("datatables", plugins_url( '/js/datatables.min.css', __FILE__));
wp_enqueue_script("datatables", plugins_url( '/js/datatables.min.js', __FILE__), ["jquery"]);
wp_enqueue_style( 'dashicons' );

add_thickbox();
?>
<div id="mr-result-upload-modal" style="display:none;">
	<h2>Upload results</h2>
	<p>Choose a CSV file that conforms to the results template</p>
	<form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data"
		id="mr_upsert_results">
		<?php wp_nonce_field('mr_upsert_results_nonce'); ?>
		<input type="hidden" name="action" value="upsert_results"/>
		<input required name="results_file" type="file" accept="text/csv"/><p/>
		<button type="submit">Upload</button>
	</form>
</div>
<?php if( $contest_scores > 0): ?>
<div id="mr-result-upload-confirmation">
	<h4>Upload Complete</h4>
	<p>Uploaded <?php echo $contest_scores; ?> scores</p> 
</div>
<?php endif; ?>

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
			<th>Add Results</th>
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
				<td><a href="#TB_inline?width=600&height=550&inlineId=mr-result-upload-modal&contest=<?php echo $contest->id; ?>" class="thickbox"><span class="dashicons dashicons-welcome-add-page"></span></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</div>