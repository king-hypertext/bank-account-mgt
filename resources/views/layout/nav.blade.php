<header class="bg-body-tertiary fixed-top">
    <ul class="nav" style="z-index: 1092;">
        <div class="container">
            <ul class="navbar-nav flex-row p-2 justify-content-between">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('l.list') }}"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a id="signout" href="#" class="nav-link" title="click to logout">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Sign out</span>
                    </a>
                </li>
                <script>
                    $(document).ready(function() {
                        $('a#signout').click(function() {
                            $.ajax({
                                url: "{{ route('logout') }}",
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function() {
                                    window.location.replace("{{ route('login') }}");
                                }
                            });
                            return false; // to prevent the default link behavior from occurring
                        });
                    });
                </script>
            </ul>
        </div>
    </ul>
</header>
