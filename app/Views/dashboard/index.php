<h2>Dashboard</h2>
<p>Hello, <?= esc(session()->get('username')) ?> (role: <?= esc(session()->get('role')) ?>)</p>
<a href="/logout" class="btn btn-danger">Logout</a>
