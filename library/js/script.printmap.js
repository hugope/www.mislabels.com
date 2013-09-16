(function($){

  var map

  ;map = {
      get_map_options : function(google){
        var o = {
          scrollwheel : false,
          disableDefaultUI : true,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        return o;
      },
      get_maps : function(selector){
        return $(selector, document);
      },
      set_map: function(map, google, options){
        return new google.maps.Map( map, options );
      },
      get_position:function(map, google){
        return new google.maps.LatLng( $(map).data().lat || 0, $(map).data().lon || 0 );
      },
      render_map:function(google, map, position){
        var marker = new google.maps.Marker({
          position: position,
          map: map
        });
        map.panTo(position);
      },
      init: function(google, selector){
        if (google && selector) {
          var gmap = this,
          $maps    = gmap.get_maps(selector);
          // render all maps that match this selector
          $.each($maps, function(i, o){
            var gmapo = gmap.set_map(o, google, gmap.get_map_options(google) ),
            pos = gmap.get_position(o, google);
            gmap.render_map(google, gmapo, pos);
          });
        }
      }
    };
    /* podes reemplazar .map-display por otro selector CSS que le pongas a tus DIVs que queres se renderizen con un mapa
     * En el CSS agreega un height estatico a los .map-display, porque si no le pondes height, la capa se pondra con una altura
     * de 0, entonces no se mostrara el mapa.
     *
     * Las opcines del mapa, como desactivar el drag, el zoom en el mapa y todo eso, lo podes modificar en el metodo
     * map.get_map_options
     * Espero te sirva :)
    */
    $(document).on("ready", function(){
      map.init(google, '.map-display');
    });
})(window.jQuery);