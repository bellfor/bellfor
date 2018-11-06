<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-shortcodes').submit() : false;"><i class="fa fa-trash-o"></i></button>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-shortcodes">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="text-left"><?php if ($sort == 'admin_name') { ?>
											<a href="<?php echo $sort_admin_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_admin_name; ?></a>
										<?php } else { ?>
											<a href="<?php echo $sort_admin_name; ?>"><?php echo $column_admin_name; ?></a>
										<?php } ?>
									</td>
									<td class="text-left"><?php if ($sort == 'name') { ?>
											<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
										<?php } else { ?>
											<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
										<?php } ?>
									</td>
									<td class="text-left"><?php if ($sort == 'type') { ?>
											<a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
										<?php } else { ?>
											<a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?></a>
										<?php } ?>
									</td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($shortcodes) { ?>
									<?php foreach ($shortcodes as $shortcode) { ?>
										<tr>
											<td class="text-center"><?php if (in_array($shortcode['id'], $selected)) { ?>
													<input type="checkbox" name="selected[]" value="<?php echo $shortcode['id']; ?>" checked="checked" />
												<?php } else { ?>
													<input type="checkbox" name="selected[]" value="<?php echo $shortcode['id']; ?>" />
												<?php } ?>
											</td>
											<td>
												<?php echo $shortcode['admin_name'] ?>
											</td>
											<td>
												[<?php echo $shortcode['name'] ?>]
											</td>
											<td>
												<?php echo $shortcode['type'] ?>
											</td>
											<td class="text-right"><a href="<?php echo $shortcode['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
										</tr>
									<?php } ?>
								<?php } else { ?>
									<tr>
										<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php echo $footer; ?>
