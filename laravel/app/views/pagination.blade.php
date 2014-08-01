<div class="pagination-container">
 
	<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
	?>
 
	<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pagination pull-right">
	<?php echo $presenter->render(); ?>
	</ul>
	<?php endif; ?>
 
</div>