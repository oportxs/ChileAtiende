(function(){
    var chae = {
        init : function(){
            var scripts = document.getElementsByTagName('script'),
                selfScriptTag = scripts[scripts.length-1],
                url = "http://dev.chileatiende.cl/embed/";

            this.type = selfScriptTag.attributes['data-cha-embed'].value;
            this.iframe = document.createElement('iframe');

            this.iframe.style.width = "100%";
            this.iframe.style.margin = "0px";
            this.iframe.style.padding = "0px";
            this.iframe.style.border = "0px";
            this.iframe.style.overflow = "hidden";
            this.iframe.style.display = "block";
            this.iframe.frameborder = "0";
            this.iframe.marginheight = "0";
            this.iframe.scrolling = "no";
            this.iframe.src = url + this.type;

            if(this.type == "header"){
                this.resizeHeader(this);
            } else {
                this.resizeFooter(this);
            }
            selfScriptTag.parentNode.insertBefore(this.iframe, selfScriptTag);
            this.bindEvents();
        },
        bindEvents : function(){
            var self = this;
            if(this.type == "header"){
                window.addEventListener('resize', function(){
                    self.resizeHeader(self);
                });
            } else {
                window.addEventListener('resize', function(){
                    self.resizeFooter(self);
                });
            }
        },
        resizeHeader : function(self){
            if(window.innerWidth >= 300 && window.innerWidth <= 480)
                self.iframe.style.height = "367px";
            if(window.innerWidth > 480 && window.innerWidth <= 720)
                self.iframe.style.height = "299px";
            if(window.innerWidth > 720 && window.innerWidth <= 800)
                self.iframe.style.height = "294px";
            if(window.innerWidth > 800 && window.innerWidth <= 980)
                self.iframe.style.height = "212px";
            if(window.innerWidth > 980 && window.innerWidth <= 1023)
                self.iframe.style.height = "236px";
            if(window.innerWidth > 1023 && window.innerWidth <= 1199)
                self.iframe.style.height = "232px";
            if(window.innerWidth > 1199)
                self.iframe.style.height = "212px";
        },
        resizeFooter : function(self){
            if(window.innerWidth >= 300 && window.innerWidth <= 480)
                self.iframe.style.height = "382px";
            if(window.innerWidth > 480 && window.innerWidth <= 579)
                self.iframe.style.height = "382px";
            if(window.innerWidth > 579 && window.innerWidth <= 751)
                self.iframe.style.height = "351px";
            if(window.innerWidth > 751 && window.innerWidth <= 800)
                self.iframe.style.height = "377px";
            if(window.innerWidth > 800 && window.innerWidth <= 979)
                self.iframe.style.height = "456px";
            if(window.innerWidth > 979 && window.innerWidth <= 1199)
                self.iframe.style.height = "315px";
            if(window.innerWidth > 1199)
                self.iframe.style.height = "295px";
        }
    }
    chae.init();
})();