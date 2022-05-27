<?php
/**
 * Estate Filter Template
 */
?>

<div class="estate-cpt-widget estate-filter | js-estate-filter">
	<?php include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/estate-cpt-filter-form.php'; // include filter form	?>	
	<div class="estate-filter__content mt-4 | js-estate-filter__content"><!-- Here comes the AJAX content --></div>
	<div class="estate-filter__pagination mt-4 | js-estate-filter__pagination"><!-- Here comes the pagination --></div>
</div><!-- End of .estate-cpt-widget -->