import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.events();
        this.openOverlay = false;
    }
    // 2. events
    events(){
        this.openButton.on("click",  this.openOveralay.bind(this));
        this.closeButton.on("click", this.closeOveralay.bind(this)  );
        $(document).on("keydown", this.keyPressDispacher.bind(this) );
    }


    // 3. merhods (function, action...)
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
        console.log("Search overlay opened");
        this.openOverlay = true;
    }
    closeOveralay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        console.log("Search overlay closed");  // or any other action you want to perform after close.  e.g., hide the search input field.
        this.openOverlay = false;
    }

}

export default Search;