<style>
    .main {
        width: 800px;
        margin: 0 auto;
    }

    .main > header {
        background: #315786;
        padding: 50px 40px;
        height: 50px;
        position: relative;
    }

    .main > body {
        background: #fff;
        padding: 50px 40px;
        position: relative;
    }

    .blue { color: #4f9ee1; }
    .green { color: #b2e122; }
    .red { color: #ff3f3f; }
    .gray { color: #4a4a4a; }

    .main > header .logo {
        float: left;
    }

    .main h3 {
        /*float: right;*/
        /*color: #fff;*/
        font-size: 24px;
        font-weight: bold;
        font-family: "Arial";
    }
</style>

<div class="main">
    <header>
        <a href="{{ url('/') }}" class="logo"><img src="{{ url('/') }}/theme/img/logo20-dark.png" /></a>
    </header>

    <section class="body">
        @yield('content')
    </section>
</div>