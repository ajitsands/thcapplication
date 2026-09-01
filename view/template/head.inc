	<title>THC-FMS</title>
	<meta name="author" content="SaNDS Lab, https://www.sandslab.com">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<!-- Permission CSS-->
	<link href="permission/css/datagrid.css?v=2.2" rel="stylesheet" type="text/css">
	<link href="permission/css/dropdown.css?v=2.2" rel="stylesheet" type="text/css">
	
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/modern_theme.css?v=2.2" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<style>
	/* Global DataTable Stacking & Dropdown Overflow Fix */
	.card,
	.card-body,
	.tab-content,
	.tab-pane,
	.dataTables_wrapper,
	.datatable-scroll,
	.datatable-scroll-wrap,
	.datatable-scroll-lg,
	.dataTables_scroll,
	.dataTables_scrollBody,
	.table-responsive {
	    overflow: visible !important;
	}

	.dataTables_wrapper {
	    position: relative !important;
	    z-index: 1 !important;
	}

	.datatable-scroll,
	.datatable-scroll-wrap,
	.datatable-scroll-lg,
	.dataTables_scroll,
	.dataTables_scrollBody,
	.table-responsive {
	    position: relative !important;
	    z-index: 99999 !important;
	    overflow: visible !important;
	}

	table.dataTable,
	.table {
	    position: relative !important;
	    z-index: 99999 !important;
	    border-collapse: collapse !important;
	}

	table.dataTable tbody tr,
	.table tbody tr {
	    position: static;
	}

	table.dataTable tbody tr td,
	.table tbody tr td {
	    overflow: visible !important;
	}

	table.dataTable tbody tr.dropdown-open,
	table.dataTable tbody tr:has(.dropdown.show),
	.table tbody tr.dropdown-open,
	.table tbody tr:has(.dropdown.show) {
	    position: relative !important;
	    z-index: 999999 !important;
	}

	.table .dropdown,
	table.dataTable .dropdown,
	.list-icons .dropdown {
	    position: relative !important;
	}

	.table .dropdown.show,
	table.dataTable .dropdown.show,
	.list-icons .dropdown.show {
	    position: relative !important;
	    z-index: 9999999 !important;
	}

	.table .dropdown-menu,
	table.dataTable .dropdown-menu,
	.dataTables_wrapper .dropdown-menu,
	.list-icons .dropdown-menu,
	.dropdown-menu.show,
	.dropdown-menu[class*="dropdown-menu-"] {
	    position: absolute !important;
	    z-index: 99999999 !important;
	    box-shadow: 0 10px 30px rgba(0, 29, 57, 0.28) !important;
	    border: 1px solid #c2daeb !important;
	}

	.datatable-footer,
	.dataTables_wrapper > .datatable-footer,
	.dataTables_wrapper .datatable-footer,
	.card-footer {
	    position: relative !important;
	    z-index: 0 !important;
	    clear: both !important;
	}

	.datatable-footer .dataTables_paginate,
	.datatable-footer .dataTables_info,
	.datatable-footer .pagination,
	.datatable-footer .paginate_button,
	.datatable-footer .page-item,
	.datatable-footer .page-link {
	    position: relative !important;
	    z-index: 0 !important;
	}
	</style>

	<!-- Core JS files-->
	<script src="global_assets/js/main/jquery.min.js"></script> 

 
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/ui/prism.min.js"></script>

	<script src="assets/js/app.js?v=2.2"></script>
	<!-- /theme JS files -->
	
	
	<script src="global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
	<script src="global_assets/js/demo_pages/form_input_groups.js"></script>
	<?php include_once('user_permission/permission_class/class_permission.php'); ?>

