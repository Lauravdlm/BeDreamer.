<div id="searchbox">
    <form class="d-flex flex-column" role="search">
        @csrf
        <div class="search-box-input-select d-flex">
            <input class="search-box-input" type="text" id="searchInput" placeholder="¿Qué buscas?..." aria-label="Search" minlength="3">
            <i class="bi bi-send"></i>
        </div>
        <div id="searchOptionsContainer" style="display: none;"></div>
    </form>
</div>
