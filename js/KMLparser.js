//Created by Fernando F. Gallego (ferdy182@gmail.com ~ www.forgottenprojects.com)
//You are free to use, modify and distribute this code.
//Mentioning the author would be appreciated :)

//usage: add the KMLparser.js file to the document. Call KMLparser(url,map); at the bottom of the script code of your map.

function createMarker2(point,place,desc){
 		var marker = new GMarker(point); 		
		var html = '<p><h1>'+place+'</h1></p><p>'+desc+'</p>'; //put here the contents of the HtmlInfoWindow		
		GEvent.addListener(marker, 'click', function() {		
			marker.openInfoWindowHtml(html,{maxWidth:500});
			map.setCenter(marker.getPoint());
		});		
		return marker;
	}

function KMLparser(path,map){ //path: url to the kml file. map: div where the map is
   var request = GXmlHttp.create();
   request.open('GET', path, true);
   request.onreadystatechange = function(){		
		if (request.readyState == 4){
			var data = request.responseXML;
			placemarks = data.documentElement.getElementsByTagName("Placemark");
			for(var i=0; i<placemarks.length; i++){
				
				var coordinates;
				coordinates = placemarks[i].getElementsByTagName("coordinates")[0].childNodes[0].nodeValue
				for(var chunk=1;  chunk<placemarks[i].getElementsByTagName("coordinates")[0].childNodes.length;chunk++){
					 coordinates+=placemarks[i].getElementsByTagName("coordinates")[0].childNodes[chunk].nodeValue;
				}
				coordinates = coordinates.split(" ");
				for(var j=0; j<coordinates.length;j++){
					coordinates[j] = coordinates[j].split(",");
				}
				if(coordinates.length == 1){
					var point = new GLatLng(parseFloat(coordinates[0][1]),parseFloat(coordinates[0][0]));
					var name = placemarks[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
					var desc = placemarks[i].getElementsByTagName("description")[0].childNodes[0].nodeValue;
										
					var marker = createMarker2(point,name,desc);
					
					map.addOverlay(marker);
				}
				else{
					var points = new Array();					
					for(var j=0; j<coordinates.length; j++){
						points.push(new  GLatLng(parseFloat(coordinates[j][1]),parseFloat(coordinates[j][0])));	
					}
					map.addOverlay(new GPolyline(points,"#FF0000", 4 ,0.8));
				}								
			}			
		}		
	}
     request.send(null);	
};