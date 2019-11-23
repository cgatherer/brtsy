(function ($) {

  $('.view-map.view-display-id-block_1').each(function( index ) {
    // This overrides the fitbounds prototype in leaflet.drupal.js, so as to add padding
    Drupal.Leaflet.prototype.fitbounds = function () {
      if (!this.settings.map_position_force && this.bounds.length > 0) {
        var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        var options = {};
        if (w > 767) {
          options = {'paddingTopLeft': [250, 0]};
        }
        this.lMap.fitBounds(new L.LatLngBounds(this.bounds), options);

        // In case of single result use the custom Map Zoom set.
        if (this.bounds.length === 1 && this.settings.zoom) {
          this.lMap.setZoom(this.settings.zoom);
        }

      }
    };

    // put the zoom on the right so as to not be behind the views attachment
    $(document).bind('leaflet.map', function (e, map, lMap) {
      lMap.zoomControl.setPosition('topright');
    });
  });

})(jQuery);