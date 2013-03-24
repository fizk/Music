
;(function(){



	document.addEventListener("DOMContentLoaded",function(event){


		document.getElementById("main-search-form").addEventListener("submit",function(event){

			event.preventDefault();

			var xhr = new XMLHttpRequest();
				xhr.open('get','/music/' + encodeURIComponent(event.target.getElementsByTagName('input')[0].value));
				xhr.addEventListener("load",function(event){
					var data = {};
					try{
						data = JSON.parse(event.target.responseText);
					}catch(e){ alert(e) }


					document.getElementById("index-artist-name").innerText = data.value.decoded;
					var scorelist = document.getElementById("index-artist-score");
					while( scorelist.childNodes.length > 0 ){
						scorelist.removeChild(scorelist.firstChild);
					}
					data.collection.forEach(function(item,index,collection){
						var listItem = document.createElement("li");
							listItem.appendChild( document.createTextNode(item.year + " - "+ item.score) );
						scorelist.appendChild(listItem);
					});
					console.log(data);
				},false);
				xhr.setRequestHeader ("Accept", "application/json");
				xhr.send();

			console.log(event.target);

		},false);

		console.log(event);
	},false);



})();