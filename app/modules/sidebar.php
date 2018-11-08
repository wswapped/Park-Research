<!--
	Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->

<div class="logo">
	<a href="/" class="simple-text logo-mini">PKS</a>
	<a href="/" class="simple-text logo-normal">
		<?=PROJECT_NAME?>
	</a>				
	<div class="navbar-minimize">
		<button id="minimizeSidebar" class="btn btn-simple btn-icon btn-neutral btn-round">
				<i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
				<i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
		</button>
	</div>
</div>

<div class="sidebar-wrapper">
	<?php

		// var_dump($currentUser);
	?>
	<div class="user">
		<div class="photo">
			<img src="/<?php echo $currentUser->profilePicture ?>" />
		</div>
		<div class="info">
			<a data-toggle="collapse" href="#collapseExample" class="collapsed">
				<span><?php echo $currentUser->name ?> <b class="caret"></b></span>
			</a>
			<div class="clearfix"></div>
			<div class="collapse" id="collapseExample">
				<ul class="nav">
					<li>
						<a href="#">
							<span class="sidebar-mini-icon">MP</span>
							<span class="sidebar-normal">My Profile</span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="sidebar-mini-icon">EP</span>
							<span class="sidebar-normal">Edit Profile</span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="sidebar-mini-icon">S</span>
							<span class="sidebar-normal">Settings</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
		
	<ul class="nav">
		<li  class="active" >									
			<a href="dashboard">
				<i class="now-ui-icons design_app"></i>
				<p>Dashboard</p>
			</a>
		</li>
		
		<li >
			<a href="parking" >				
				<i class="now-ui-icons design_image"></i>
				<p>Parkings</p>
			</a>
		</li>
		
		<li >
			<a data-toggle="collapse" href="#componentsExamples" >
				<i class="now-ui-icons education_atom"></i>
				<p>
					Fees <b class="caret"></b>
				</p>
			</a>
			<div class="collapse " id="componentsExamples">
				<ul class="nav">
					<li >
						<a href="categories">
							<span class="sidebar-mini-icon">C</span>
							<span class="sidebar-normal"> Categories </span>
						</a>
					</li>
					<li >
						<a href="components/buttons.html">
							<span class="sidebar-mini-icon">E</span>
							<span class="sidebar-normal"> Earnings </span>
						</a>
					</li>
					<li >
						<a href="movements">
							<span class="sidebar-mini-icon">M</span>
							<span class="sidebar-normal"> Movements </span>
						</a>
					</li>
				</ul>
			</div>
		</li>
		
		<li>
			<a data-toggle="collapse" href="#formsExamples" >
				<i class="now-ui-icons design_image"></i>
				<p>
					Cameras <b class="caret"></b>
				</p>
			</a>

			<div class="collapse " id="formsExamples">
				<ul class="nav">
					<li >
						<a href="forms/regular.html">
							<span class="sidebar-mini-icon">RF</span>
							<span class="sidebar-normal"> Regular Forms </span>
						</a>
					</li>
				
					<li >
						<a href="forms/extended.html">
							<span class="sidebar-mini-icon">EF</span>
							<span class="sidebar-normal"> Extended Forms </span>
						</a>
					</li>
				
					<li >
						<a href="forms/validation.html">
							<span class="sidebar-mini-icon">V</span>
							<span class="sidebar-normal"> Validation Forms </span>
						</a>
					</li>
				
					<li >
						<a href="forms/wizard.html">
							<span class="sidebar-mini-icon">W</span>
							<span class="sidebar-normal"> Wizard </span>
						</a>
					</li>
				
				</ul>
			</div>
		</li>
		
		<li >
			<a href="users" >						
				<i class="now-ui-icons users_single-02"></i>
				<p>Users </p>
			</a>
		</li>
	</ul>
</div>