<h3>Módulos de terceros</h3>

<?php if (has_role(7) OR has_role(3)) {
	?>
	<?=make_link('tbs/thirdparties_requests/global_view', '<span class="icon input white xlarge"></span> Ingresos Vista Global', 'masonry button w33 dark')?>

	<?=make_link('tbs/thirdparties_requests', '<span class="icon input white xlarge"></span> Ingreso de terceros', 'masonry button w33 dark')?>

	<?=make_link('tbs/thirdparties_outputs', '<span class="icon output white xlarge"></span> Salidas de terceros', 'masonry button w33 purple')?>
	<?php
}else{
	?>
	<?=make_link('tbs/thirdparties_requests', '<span class="icon input white xlarge"></span> Ingreso de terceros', 'masonry button w50 dark')?>

	<?=make_link('tbs/thirdparties_outputs', '<span class="icon output white xlarge"></span> Salidas de terceros', 'masonry button w50 purple')?>
	<?php
} ?>

