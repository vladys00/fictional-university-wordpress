import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchInput = $("#search-term");
        this.events();
        this.openOverlay = false;
    }
    // 2. events
    events(){
        this.openButton.on("click",  this.openOveralay.bind(this));
        this.closeButton.on("click", this.closeOveralay.bind(this));
        $(document).on("keydown", this.keyPressDispacher.bind(this));
        this.searchInput.on("keydown", this.typingLogic);
    }
    

    // 3. methods (function, action...)
    typingLogic(){
        
    }
    keyPressDispacher(e){
        if (e.keyCode === 83 && !this.openOverlay) {
            this.openOveralay();
        }
        if (e.keyCode === 27 && this.openOverlay) {
            this.closeOveralay();
        }
    }
    openOveralay(){
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.openOverlay = true;
    }
    closeOveralay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.openOverlay = false;
    }

}

export default Search;