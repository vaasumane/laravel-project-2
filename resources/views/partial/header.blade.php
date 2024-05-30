<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWq_QfJRLlCMzVLdZT1KZqOBBfYlqAII9Xctxj-pmTRw&s" class="w-50" alt="Logo">
        </a>
        @if (isset($_COOKIE["authToken"]))
            <button class="btn btn-outline-success" type="button" onclick="deleteAllCookies();">Logout</button>
        @endif
    </div>
</nav>
