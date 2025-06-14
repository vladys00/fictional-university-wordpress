import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.addSearchHTML();
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
            this.typingTimer = setTimeout( this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.html("");
                this.isSpinnerLoading = false;
            }
        };
        this.previousValue = this.searchInput.val();
    }

    getResults(){
        $.when(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchInput.val(),
        universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchInput.val() )
        .then((posts, pages)=>{
            let results = posts.concat(pages);
                this.resultsDiv.html(`
                    <h2 class="search-overlay__section-title">Search Results:</h2>
                        ${results.length  ? '<ul class="link-list min-list">' : '<p class="no-results">No general information matches that search.</p>'}
                            ${results.map(post => `<li><a href="${post.link}">${post.title.rendered}</a></li>`).join("")}
                            ${results.length  ? '</ul>' : ''}
                            `);
                this.isSpinnerLoading = false;
        })
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
        this.searchInput.val("");
        setTimeout(()=>this.searchInput.focus(), 305)
        this.openOverlay = true;
    }
    closeOveralay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.openOverlay = false;
    }

    addSearchHTML(){
        $("body").append(`
    <div class="search-overlay">
      <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="what are you looking for?"
            id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
      </div>
      <div class="container">
        <div id="search-overlay__results"></div>
      </div>
    </div>`);
    }

}

export default Search;