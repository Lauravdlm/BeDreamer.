<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Enlaces útiles</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('places.index') }}">Todos los destinos</a></li>
                    <li><a href="{{ route('blogs.index') }}">Todos los Blogs</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Redes sociales</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/?locale=es_ES/"><i class="bi bi-facebook"></i> Facebook</a></li>
                    <li><a href="https://es.linkedin.com/"><i class="bi bi-linkedin"></i> Linkedin</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contacto</h5>
                <ul class="list-unstyled">
                    <li><p><i class="bi bi-envelope-fill"></i> lauri.v.m.vb@gmail.com</p></li>
                    <li><p><i class="bi bi-person-fill"></i> Laura Valera de los Mozos</p></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h1 class="site-title">
                    <a href="{{ route('home') }}" rel="home">BeDreamer</a>
                </h1>
            </div>
            <div class="col">
                <ul class="list-unstyled">
                    <li><a href="{{ route('loading-page') }}">Condiciones de Uso</a></li>
                    <li><a href="{{ route('loading-page') }}">Política de Privacidad</a></li>
                    <li><a href="{{ route('loading-page') }}">Cookies</a></li>
                </ul>
                <ul>
                    <li><p>© BeDreamer 2023-2024, Todo sobre Viajes</p></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
