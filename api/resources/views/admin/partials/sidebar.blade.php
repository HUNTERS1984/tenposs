<ul class="main-navigation">
	<li><a href="{{ route('admin.home') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.clients') }}">Clients</a></li>
	<li><a href="#">Catalog</a>
		<ul>
			<li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
			<li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
		</ul>
	</li>
</ul>