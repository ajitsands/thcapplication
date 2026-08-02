
				<div class="card">

					<div class="card-header header-elements-inline">
						<h5 class="card-title">Small navbar</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						<p class="mb-3">Decrease height of the navbar by adding <code>.navbar-sm</code> class to the main <code>.navbar</code> container. Small navbar height is ~46px including borders, all navbar components are adjusted to the large navbar height automatically. If navbar type is fixed, add <code>.navbar-sm-top</code> class to the <code>&lt;body></code> container to set <strong>top</strong> padding and/or <code>.navbar-sm-bottom</code> class if navbar placement is bottom to set <strong>bottom</strong> padding.</p>

						<div class="mb-4">
							<p class="font-weight-semibold">Small navbar example:</p>
							<div class="navbar navbar-dark bg-info-700 navbar-sm navbar-component navbar-expand-xl rounded">
								<div class="navbar-brand">
									<a href="index.html" class="d-inline-block">
										<img src="global_assets/images/logo_light.png" alt="">
									</a>
								</div>

								<div class="d-xl-none">
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-demo3-mobile">
										<i class="icon-grid3"></i>
									</button>
								</div>

								<div class="navbar-collapse collapse" id="navbar-demo3-mobile">
									<ul class="navbar-nav">
										<li class="nav-item"><a href="#" class="navbar-nav-link active">Active</a></li>
										<li class="nav-item"><a href="#" class="navbar-nav-link">Link</a></li>
										<li class="nav-item dropdown">
											<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">Menu</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item">Action</a>
												<a href="#" class="dropdown-item">Another action</a>
												<a href="#" class="dropdown-item">Something else here</a>
												<a href="#" class="dropdown-item">One more line</a>
											</div>
										</li>
									</ul>

									<ul class="navbar-nav ml-xl-auto">
										<li class="nav-item">
											<a href="#" class="navbar-nav-link">
												<i class="icon-pin-alt mr-2"></i>
												Link
											</a>
										</li>
										<li class="nav-item dropdown">
											<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog7"></i>
												<span class="d-xl-none ml-2">Settings</span>
											</a>
											
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item">Action</a>
												<a href="#" class="dropdown-item">Another action</a>
												<a href="#" class="dropdown-item">Something else here</a>
												<a href="#" class="dropdown-item">One more line</a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p class="font-weight-semibold">Small static navbar markup:</p>
								<pre class="language-markup mb-3" data-line="2, 5"><code>&lt;!-- Document body -->
&lt;body>

	&lt;!-- Small static navbar -->
	&lt;div class="navbar navbar-dark navbar-sm navbar-expand-md">

		&lt;!-- Brand and toggler -->
		&lt;div class="navbar-header">...&lt;/div>
		&lt;div class="d-md-none">...&lt;/div>
		&lt;!-- /brand and toggler -->

		&lt;!-- Navbar content -->
		&lt;div class="collapse navbar-collapse" id="navbar-main">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /small static navbar -->

&lt;/body>
&lt;!-- /document body -->
</code></pre>
							</div>

							<div class="col-md-6">
								<p class="font-weight-semibold">Small fixed navbar markup:</p>
								<pre class="language-markup mb-3" data-line="2, 5"><code>&lt;!-- Document body -->
&lt;body class="navbar-sm-top">

	&lt;!-- Small fixed navbar -->
	&lt;div class="navbar navbar-dark navbar-sm navbar-expand-md fixed-top">

		&lt;!-- Brand and toggler -->
		&lt;div class="navbar-header">...&lt;/div>
		&lt;div class="d-md-none">...&lt;/div>
		&lt;!-- /brand and toggler -->

		&lt;!-- Navbar content -->
		&lt;div class="collapse navbar-collapse" id="navbar-main">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /small fixed navbar -->

&lt;/body>
&lt;!-- /document body -->
</code></pre>
							</div>
						</div>
					</div>
				</div>
				