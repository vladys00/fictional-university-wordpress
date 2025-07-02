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
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchInput.val(), (results)=>{
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.generalInfo.length  ? '<ul class="link-list min-list">' : '<p class="no-results">No general information matches that search.</p>'}
                        ${results.generalInfo.map(post => `<li><a href="${post.permalink}">${post.title}</a> ${post.postType == 'post' ? `by ${post.authorName}` : "" }</li>`).join("")}
                        ${results.generalInfo.length  ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title" >Programs</h2>
                        ${results.programs.length  ? '<ul class="link-list min-list">' : `<p class="no-results">No programs matches that search.<a href="${universityData.root_url}/programs">View all programs</a></p>`}
                        ${results.programs.map(post => `<li><a href="${post.permalink}">${post.title}</a></li>`).join("")}
                        ${results.programs.length  ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title">Professors</h2>

                        ${results.professors.length  ? '<ul class="professor-cards">' : `<p class="no-results">No professors matches that search.</p>`}
                        ${results.professors.map(item => `
                            <li class="professor-card__list-item">
                                <a class="professor-card" href="${ item.permalink}">
                                <img class="professor-card__image" src="${item.image}" alt="">
                                <span class="professor-card__name">${item.title}</span>
                                </a>
                            </li>
                            `).join("")}
                        ${results.professors.length  ? '</ul>' : ''}

                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length  ? '<ul class="link-list min-list">' : `<p class="no-results">No campuses matches that search.<a href="${universityData.root_url}/campuses">View all campuses</a></p>`}
                        ${results.campuses.map(post => `<li><a href="${post.permalink}">${post.title}</a></li>`).join("")}
                        ${results.campuses.length  ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length  ? '' : `<p class="no-results">No events matches that search.<a href="${universityData.root_url}/events">View all events</a></p>`}
                        ${results.events.map(item => `
                        <div class="event-summary">
                            <a class="event-summary__date t-center" href="${item.permalink}">
                            <span class="event-summary__month">${item.month}</span>
                            <span class="event-summary__day">${item.day}</span>
                            </a>
                            <div class="event-summary__content">
                            <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                            <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
                            </div>
                        </div>
                        `).join("")}
                        

                    </div>
                </div>    
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