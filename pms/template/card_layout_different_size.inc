
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Size combinations</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						<p class="mb-3">Multiple navbars support different heights as well, just add optional height classes to both navbars. If navbar type is <code>fixed</code>, add <code>.navbar-[size]-[size]-top</code> to the <code>&lt;body></code> container to set <strong>top</strong> padding and/or <code>.navbar-[size]-[size]-bottom</code> class if navbar placement is bottom to set <strong>bottom</strong> padding. Example: add <code>.navbar-md-sm-top</code> class to <code>&lt;body></code> if first navbar has default height and second has small.</p>

						<div class="mb-4">
							<p class="font-weight-semibold">Sizes of static multiple navbars:</p>
							<div class="navbar navbar-dark bg-teal-400 navbar-component navbar-expand-xl rounded-top mb-0">
								<div class="navbar-brand">
									<a href="index.html" class="d-inline-block">
										<img src="global_assets/images/logo_light.png" alt="">
									</a>
								</div>

								<div class="d-xl-none">
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-demo4-mobile">
										<i class="icon-grid3"></i>
									</button>
								</div>

								<div class="navbar-collapse collapse" id="navbar-demo4-mobile">
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

							<div class="navbar navbar-light navbar-component navbar-sm navbar-expand-xl rounded-bottom border-top-transparent">
								<div class="text-center d-xl-none w-100">
									<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-demo5-mobile">
										<i class="icon-unfold mr-2"></i>
										Light navbar component
									</button>
								</div>

								<div class="navbar-collapse collapse" id="navbar-demo5-mobile">
									<ul class="nav navbar-nav">
										<li class="nav-item">
											<a href="#" class="navbar-nav-link"><i class="icon-git-branch mr-2"></i> Branches</a>
										</li>
										<li class="nav-item">
											<a href="#" class="navbar-nav-link">
												<i class="icon-git-merge mr-2"></i>
												Merges
												<span class="badge badge-pill bg-info position-static ml-auto ml-xl-2">81</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="#" class="navbar-nav-link"><i class="icon-git-pull-request mr-2"></i> Requests</a>
										</li>
									</ul>

									<ul class="navbar-nav ml-xl-auto">
										<li class="nav-item">
											<a href="#" class="navbar-nav-link">
												<i class="icon-upload10 mr-2"></i>
												Upload files
											</a>
										</li>
										<li class="nav-item dropdown">
											<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
												<i class="icon-share4"></i>
												<span class="d-xl-none ml-2">Share</span>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-dribbble3"></i> Dribbble</a>
												<a href="#" class="dropdown-item"><i class="icon-pinterest2"></i> Pinterest</a>
												<a href="#" class="dropdown-item"><i class="icon-github"></i> Github</a>
												<a href="#" class="dropdown-item"><i class="icon-stackoverflow"></i> Stack Overflow</a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6">
								<p class="font-weight-semibold">Markup of static multiple navbars:</p>
								<pre class="language-markup mb-3" data-line="2, 5, 24"><code>&lt;!-- Document body -->
&lt;body>

	&lt;!-- First navbar -->
	&lt;div class="navbar navbar-dark bg-teal-400 navbar-expand-md">

		&lt;!-- Navbar content -->
		&lt;div class="navbar-header">
			...
		&lt;/div>
		&lt;div class="d-md-none">
			...
		&lt;/div>
		&lt;div class="collapse navbar-collapse" id="navbar-first">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /first navbar -->


	&lt;!-- Second navbar -->
	&lt;div class="navbar navbar-dark bg-slate-700 navbar-sm navbar-expand-md">

		&lt;!-- Navbar content -->
		&lt;div class="navbar-header">
			...
		&lt;/div>
		&lt;div class="d-md-none">
			...
		&lt;/div>
		&lt;div class="collapse navbar-collapse" id="navbar-second">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /second navbar -->

&lt;/body>
&lt;!-- /document body -->
</code></pre>
							</div>

							<div class="col-md-6">
								<p class="font-weight-semibold">Markup of fixed multiple navbars:</p>
								<pre class="language-markup mb-3" data-line="2, 5, 24"><code>&lt;!-- Document body -->
&lt;body class="navbar-md-sm-top">

	&lt;!-- First navbar -->
	&lt;div class="navbar navbar-dark bg-teal-400 navbar-expand-md">

		&lt;!-- Navbar content -->
		&lt;div class="navbar-header">
			...
		&lt;/div>
		&lt;div class="d-md-none">
			...
		&lt;/div>
		&lt;div class="collapse navbar-collapse" id="navbar-first">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /first navbar -->


	&lt;!-- Second navbar -->
	&lt;div class="navbar navbar-dark bg-slate-700 navbar-sm navbar-expand-md">

		&lt;!-- Navbar content -->
		&lt;div class="navbar-header">
			...
		&lt;/div>
		&lt;div class="d-md-none">
			...
		&lt;/div>
		&lt;div class="collapse navbar-collapse" id="navbar-second">
			...
		&lt;/div>
		&lt;!-- /navbar content -->

	&lt;/div>
	&lt;!-- /second navbar -->

&lt;/body>
&lt;!-- /document body -->
</code></pre>
							</div>
						</div>
					</div>
				</div>
				