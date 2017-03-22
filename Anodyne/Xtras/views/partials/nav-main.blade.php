<nav class="nav-main visible-xs visible-sm">
	<div class="container">
		<ul>
			<li><a href="#" class="active" data-toggle="modal" data-target="#navGlobalMobile">Xtras<div class="arrow"></div></a></li>
		</ul>
	</div>
</nav>

<div class="modal fade" id="navGlobalMobile">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Anodyne Productions</h4>
			</div>
			<div class="modal-body">
				<ul>
					<li><a href="{{ config('anodyne.links.www') }}">Anodyne</a></li>
					<li><a href="{{ config('anodyne.links.nova') }}">Nova</a></li>
					<li><a href="{{ route('home') }}">Xtras</a></li>
					<li><a href="{{ config('anodyne.links.forums') }}">Forums</a></li>
					<li><a href="{{ config('anodyne.links.help') }}">Help</a></li>
					<li><a href="#" class="js-contact">Contact</a></li>
					<li><a href="{{ config('anodyne.links.www') }}register">Register</a></li>
					<li><a href="{{ route('login') }}">Log In</a></li>
				</ul>
			</div>
			<div class="modal-footer">
				<a href="#" data-dismiss="modal" class="btn btn-lg btn-block btn-default">Close</a>
			</div>
		</div>
	</div>
</div>

<nav class="nav-main visible-md visible-lg">
	<div class="container">
		<ul class="visible-md visible-lg pull-right">
			<li><a href="#" class="js-contact">Contact</a></li>

			@if (Auth::check())
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="user-icon">{{ $_icons['user'] }}</span> {{ $_currentUser->present()->name }} <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-menu-right dd">
						<li><a href="{{ route('account.xtras') }}">My Xtras</a></li>
						
						@if ($_currentUser->can('xtras.item.create') or $_currentUser->can('xtras.admin'))
							<li class="hidden-xs hidden-sm"><a href="{{ route('item.create') }}">Create New Xtra</a></li>
						@endif
						<li class="divider"></li>
						<li><a href="{{ route('account.profile', [$_currentUser->username]) }}">My Profile</a></li>
						<li><a href="{{ config('anodyne.links.www') }}admin/users/{{ $_currentUser->username }}/edit">Edit My Profile</a></li>
						<li class="divider"></li>
						<li><a href="{{ route('account.downloads') }}">My Downloads</a></li>
						<li><a href="{{ route('account.notifications') }}">My Notifications</a></li>

						@if ($_currentUser->can('xtras.admin'))
							<li class="divider"></li>
							<li><a href="{{ route('item.admin') }}">Manage Items</a></li>
							<li><a href="{{ route('admin.products.index') }}">Manage Products</a></li>
							<li><a href="{{ route('admin.types.index') }}">Manage Item Types</a></li>
							<li class="divider"></li>
							<li><a href="{{ route('admin.report.items') }}">Item Size Report</a></li>
							<li><a href="{{ route('admin.report.users') }}">User Size Report</a></li>
						@endif

						<li class="divider"></li>
						<li><a href="{{ route('logout') }}">Logout</a></li>
					</ul>
				</li>
			@else
				<li><a href="{{ config('anodyne.links.www') }}register">Register</a></li>
				<li><a href="{{ route('login') }}">Log In</a></li>
			@endif
		</ul>

		<ul>
			<li><a href="{{ config('anodyne.links.www') }}">Anodyne<div class="arrow"></div></a></li>
			<li><a href="{{ config('anodyne.links.nova') }}">Nova<div class="arrow"></div></a></li>
			<li><a href="{{ route('home') }}" class="active">Xtras<div class="arrow"></div></a></li>
			<li><a href="{{ config('anodyne.links.forums') }}">Forums<div class="arrow"></div></a></li>
			<li><a href="{{ config('anodyne.links.help') }}">Help<div class="arrow"></div></a></li>
			<!--<li><a href="http://learn.anodyne-productions.com">Learn<div class="arrow"></div></a></li>-->
			<li class="visible-sm"><a href="#" class="js-contact">Contact</a></li>
			<li class="visible-sm"><a href="{{ config('anodyne.links.www') }}register">Register</a></li>
			<li class="visible-sm"><a href="{{ route('login') }}">Log In</a></li>
		</ul>
	</div>
</nav>