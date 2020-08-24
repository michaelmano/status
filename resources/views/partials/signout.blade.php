<form id="js-overlay" class="Overlay" action="{{ route('store') }}" method="post">
    <div class="Overlay__backface">
        <button id="js-overlay-next" class="Overlay__next" type="submit">
            <span class="Overlay__btn-content">
                <span>Next</span>
                <img src="{{ asset('images/chev-right.svg') }}" alt="">
            </span>
        </button>
        <span id="js-overlay-error" class="Overlay__next--error">Please complete all the necessary steps</span>
        <a href="#" id="js-overlay-back" class="Overlay__back">
            <span class="Overlay__btn-content">
                <img src="{{ asset('images/chev-left.svg') }}" alt="">
                <span>Quit</span>
                <span>Back</span>
            </span>
        </a>
        <div id="js-overlay-scroller" class="Overlay__scroller">
            <div class="Overlay__panel">
                <div class="Overlay__content-wrapper">
                    <vue-camera v-if="type == 'camera'" :names="{{ json_encode($employees->pluck("name")) }}" />
                    <vue-namepad v-else :names="{{ json_encode($employees->pluck("name")) }}">
                </div>
            </div>
            <div class="Overlay__panel">
                <div class="Overlay__content-wrapper">
                    <vue-status />
                </div>
            </div>
            <div class="Overlay__panel">
                <div class="Overlay__content-wrapper">
                    <vue-timepad />
                </div>
            </div>
        </div>
        <div class="Overlay__finish-screen">👋 Signing out...</div>
    </div>
    <div class="Overlay__curtain"></div>
</form>