


(function( $ ){
   $.fn.animatebgcolors = function() {
      this.toggleClass( "gradient-teal-blue gradient-lime-green", 2000, "easeOutSine");
      this.toggleClass( "gradient-lime-green gradient-darkblue-lightblue", 2000, "easeOutSine");
      this.toggleClass( "gradient-darkblue-lightblue gradient-yellow-blue", 2000, "easeOutSine");
      this.toggleClass( "gradient-yellow-blue gradient-blue-pink", 2000, "easeOutSine");
      this.toggleClass( "gradient-blue-pink gradient-red-purple", 2000, "easeOutSine");
      this.toggleClass( "gradient-red-purple gradient-teal-blue", 2000, "easeOutSine");
      return this;
   }; 
})( jQuery );

