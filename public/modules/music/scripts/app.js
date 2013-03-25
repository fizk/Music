
;(function(){
/*
var data = [4, 8, 15, 16, 23, 42];
var y = d3.scale.ordinal()
    .domain(data)
    .rangeBands([0, 120]);
var x = d3.scale.linear()
    .domain([0, d3.max(data)])
    .range(["0px", "420px"]);
var chart = d3.select("#chart").append("svg")
    .attr("class", "chart")
    .attr("width", 420)
    .attr("height", 120);

chart.selectAll("rect")
    .data(data)
  .enter().append("rect")
    .attr("y", y)
    .attr("width", x)
    .attr("height", y.rangeBand());

chart.selectAll("text")
    .data(data)
  .enter().append("text")
    .attr("class", "bar")
    .attr("x", x)
    .attr("y", function(d) { return y(d) + y.rangeBand() / 2; })
    .attr("dx", -3)
    .attr("dy", ".35em")
    .attr("text-anchor", "end")
    .text(String);
*/


	document.addEventListener("DOMContentLoaded",function(event){

		var xhr = new XMLHttpRequest();
			xhr.open('get','/music/' + encodeURIComponent("The Beatles"));
			xhr.setRequestHeader ("Accept", "application/json");
			xhr.addEventListener("load",function(event){

				var data = JSON.parse(event.target.responseText).collection;

				var y = d3.scale.ordinal()
    				.domain(data.map(function(d){return d.score*5;}))
				    .rangeBands([0, 960/2]);

				var x = d3.scale.linear()
				    .domain([0, d3.max( data.map(function(d){return d.score*5;}) )])
				    .range(["0px", "820px"]);

				var chart = d3.select("#chart").append("svg")
				    .attr("class", "chart")
				    .attr("width", 960/2)
				    .attr("height", data.length*20);

				chart.selectAll("rect")
				    .data(data)
				  .enter().append("rect")
				    .attr("y", function(d, i) { return i * 20; })
				    .attr("width", function(x,i){return x.score*5;}  )
				    .attr("height", y.rangeBand());
				   /*
				chart.selectAll("text")
				    .data(data)
				  .enter().append("text")
				    .attr("class", "bar")
				    .attr("x", function(x){return x.score*10;} )
				    .attr("y", function(d) { return y(d.score*10) + y.rangeBand() / 2; })
				    .attr("dx", -3)
				    .attr("dy", ".35em")
				    .attr("text-anchor", "end")
				    .text(function(d){return d.year});
				    */
			},false);
			xhr.send();

	},false);

/*
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

*/

})();