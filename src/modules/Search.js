import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.events();
    }
    // 2. events
    events(){
        this.openButton.on("click",  this.openOveralay.bind(this));
        this.closeButton.on("click", this.closeOveralay.bind(this)  );
    }


    // 3. merhods (function, action...)
    openOveralay(){
        this.searchOverlay.addClass("search-overlay--active");
    }
    closeOveralay(){
        this.searchOverlay.removeClass("search-overlay--active");
    }

}

export default Search;