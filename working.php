<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="./css/style_theme.css" type="text/css">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <script src="./js/OpenLayers.js"></script>



<style>

            html, body, #map {
                margin: 0;
                width: 100%;
                height: 100%;
            }

</style> 

   <script type="text/javascript">
	var lon = 5;
        var lat = 40;
        var zoom = 5;
        var map, layer;

        function init(){








map = new OpenLayers.Map("map", {

    projection: new OpenLayers.Projection("EPSG:3857"),
    units: "m", 
    maxResolution: 156543.0339,
    maxExtent: new OpenLayers.Bounds(
        -20037508, -20037508, 20037508, 20037508.34),
    displayProjection: new OpenLayers.Projection("EPSG:4326"),
    controls: [
        new OpenLayers.Control.Navigation(),
        new OpenLayers.Control.KeyboardDefaults(),
        new OpenLayers.Control.PanZoomBar(),
        new OpenLayers.Control.Scale(),
        new OpenLayers.Control.Attribution()
    ]

});

  var style_green = {
                strokeColor: "#00FF00",
                strokeWidth: 3,
                strokeDashstyle: "dashdot",
                pointRadius: 6,
                pointerEvents: "visiblePainted",
                title: "this is a green line"
            };




 var layer1 = new OpenLayers.Layer.Vector("POIs", {
    projection: "EPSG:4326",
                    strategies: [new OpenLayers.Strategy.BBOX({resFactor: 1.1})],
                    protocol: new OpenLayers.Protocol.HTTP({
                        url: "textfile.txt",
                        format: new OpenLayers.Format.Text()
                    })
                });

 selectControl = new OpenLayers.Control.SelectFeature(layer1);
                map.addControl(selectControl);
selectControl.activate();
                layer1.events.on({
                    'featureselected': onFeatureSelect,
                    'featureunselected': onFeatureUnselect
                });


            osm_layer = new OpenLayers.Layer.OSM('Osm');




           var geojson_format = new OpenLayers.Format.GeoJSON(     
{
    internalProjection: new OpenLayers.Projection("EPSG:3857"),
                          externalProjection: new OpenLayers.Projection("EPSG:4326")
}
);

        //   var vector_layer = new OpenLayers.Layer.Vector(); 




        var defStyle = {strokeColor: "blue", strokeOpacity: "0.7", strokeWidth: 3, cursor: "pointer"};
        var sty = OpenLayers.Util.applyDefaults(defStyle, OpenLayers.Feature.Vector.style["default"]);
        var sm = new OpenLayers.StyleMap({
            'default': sty,
            'select': {strokeColor: "red", fillColor: "red"}
        });

var vector = new OpenLayers.Layer.Vector("GeoJSON", {
    projection: "EPSG:4326",
    strategies: [new OpenLayers.Strategy.Fixed()],
   styleMap: sm,
    protocol: new OpenLayers.Protocol.HTTP({
        url: "new.json",
        format: new OpenLayers.Format.GeoJSON()
    })
});






/*
	 var geojson_layer = new OpenLayers.Layer.Vector("GeoJSON", {
                projection: epsg4326,
                strategies: [new OpenLayers.Strategy.Fixed()],
                protocol: new OpenLayers.Protocol.HTTP({
                    url: "./sample.json",
                    format: geojson_format
                })
            });
*/

            map.addLayers([vector,layer1,osm_layer]);
    map.setCenter(
                new OpenLayers.LonLat( 78.5,17.5).transform(
                    new OpenLayers.Projection("EPSG:4326"),
                    map.getProjectionObject()
                ), 7
            );



      }

   function onPopupClose(evt) {
                // 'this' is the popup.
                var feature = this.feature;
                if (feature.layer) { // The feature is not destroyed
                    selectControl.unselect(feature);
                } else { // After "moveend" or "refresh" events on POIs layer all 
                         //     features have been destroyed by the Strategy.BBOX
                    this.destroy();
                }
            }
            function onFeatureSelect(evt) {
                feature = evt.feature;
                popup = new OpenLayers.Popup.FramedCloud("featurePopup",
                                         feature.geometry.getBounds().getCenterLonLat(),
                                         new OpenLayers.Size(100,100),
                                         "<h2>"+feature.attributes.title + "</h2>" +
                                         feature.attributes.description,
                                         null, true, onPopupClose);
                feature.popup = popup;
                popup.feature = feature;
                map.addPopup(popup, true);
            }
            function onFeatureUnselect(evt) {
                feature = evt.feature;
                if (feature.popup) {
                    popup.feature = null;
                    map.removePopup(feature.popup);
                    feature.popup.destroy();
                    feature.popup = null;
                }
            }


    </script>
  </head>
  <body onload="init()">
    <h1 id="title"  align="center">Shortest Path for Tourist Places :</h1>
    
    <div id="tags">
       JSON, GeoJSON, light
    </div>

      <p id="shortdesc"  align="center">
        Labs For Spatial Informatics , IIIT 
    </p>
    <div id="map" > </div>
    <div id="docs">
        <p>This example uses the GeoJSON format.</p>
    </div>
  </body>
</html>
