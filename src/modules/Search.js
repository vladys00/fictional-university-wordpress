import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchInput = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        this.openOverlay = false;
        this.isSpinnerLoading = false;
        this.previousValue;
        this.typingTimer;
        this.events();
    }
    // 2. events
    events(){
        this.openButton.on("click",  this.openOveralay.bind(this));
        this.closeButton.on("click", this.closeOveralay.bind(this));
        $(document).on("keydown", this.keyPressDispacher.bind(this));
        this.searchInput.on("keyup", this.typingLogic.bind(this));
    }
    

    // 3. methods (function, action...)
    typingLogic(){
        if (this.searchInput.val() !=  this.previousValue){
            clearTimeout(this.typingTimer);
            if(this.searchInput.val()){
                if (!this.isSpinnerLoading){
                this.resultsDiv.html('<div class="spinner-loader"></div>'); 
                this.isSpinnerLoading = true;
            }
            this.typingTimer = setTimeout( this.getResults.bind(this), 2000);
            } else {
                this.resultsDiv.html("");
                this.isSpinnerLoading = false;
            }
        };
        this.previousValue = this.searchInput.val();
    }

    getResults(){
        this.resultsDiv.html("Some tset inner html");
        this.isSpinnerLoading = false;
    }
    keyPressDispacher(e){
        if (e.keyCode === 83 && !this.openOverlay && !$("input, textarea").is(":focus"))  {
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