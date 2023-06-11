var margin = {
	top: 10,
	right: 30,
	bottom: 30,
	left: 60
}, 
width = 400;
height = 400;

svg = d3.select("#tsne")
	.append("svg")
	.attr("viewBox", [0, 0, width, height + margin.top + margin.bottom])
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
	.append("g")
	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
g = svg.append("g")
	.attr("fill", "none")
	.attr("stroke-linecap", "round");

// ref: http://stackoverflow.com/a/1293163/2343
// This will parse a delimited string into an array of
// arrays. The default delimiter is the comma, but this
// can be overriden in the second argument.
function CSVToArray(strData, strDelimiter) {
// Check to see if the delimiter is defined. If not,
// then default to comma.
strDelimiter = (strDelimiter || ",");
// Create a regular expression to parse the CSV values.
var objPattern = new RegExp(
    (
        // Delimiters.
        "(\\" + strDelimiter + "|\\r?\\n|\\r|^)" +
        // Quoted fields.
        "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
        // Standard fields.
        "([^\"\\" + strDelimiter + "\\r\\n]*))"
    ),
    "gi"
);
// Create an array to hold our data. Give the array
// a default empty first row.
var arrData = [
    []
];
// Create an array to hold our individual pattern
// matching groups.
var arrMatches = null;
// Keep looping over the regular expression matches
// until we can no longer find a match.
while (arrMatches = objPattern.exec(strData)) {
    // Get the delimiter that was found.
    var strMatchedDelimiter = arrMatches[1];
    // Check to see if the given delimiter has a length
    // (is not the start of string) and if it matches
    // field delimiter. If id does not, then we know
    // that this delimiter is a row delimiter.
    if (
        strMatchedDelimiter.length &&
        strMatchedDelimiter !== strDelimiter
    ) {
        // Since we have reached a new row of data,
        // add an empty row to our data array.
        arrData.push([]);
    }
    var strMatchedValue;
    // Now that we have our delimiter out of the way,
    // let's check to see which kind of value we
    // captured (quoted or unquoted).
    if (arrMatches[2]) {
        // We found a quoted value. When we capture
        // this value, unescape any double quotes.
        strMatchedValue = arrMatches[2].replace(
            new RegExp("\"\"", "g"),
            "\""
        );
    } else {
        // We found a non-quoted value.
        strMatchedValue = arrMatches[3];
    }
    // Now that we have our value string, let's add
    // it to the data array.
    arrData[arrData.length - 1].push(strMatchedValue);
}
// Return the parsed data.
return (arrData);
}

var data;
var xhr = new XMLHttpRequest();
xhr.open("GET", "https://raw.githubusercontent.com/Beiusxzw/Beiusxzw.github.io/master/src/tSNE.csv", true);
// xhr.setRequestHeader('Content-Type', 'application/json');

xhr.send()
xhr.onload = function() {
// console.log(this.responseText)
data = CSVToArray(this.responseText);
}

// Include <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script> in your code!
cell_type_scale_ordinal = d3.scaleOrdinal().domain(data.map(d => parseInt(d[3]))).range(d3.schemeCategory10);

var tsne_x = data.map(d => parseFloat(d[1]));
var tsne_y = data.map(d => parseFloat(d[2]));
var tsne_x_max = 0;
var tsne_y_max = 0;
tsne_x.map(function(d, i) {
if (Math.abs(d) > tsne_x_max) tsne_x_max = Math.abs(d);
})
console.log(tsne_x_max)
tsne_y.map(function(d, i) {
if (Math.abs(d) > tsne_y_max) tsne_y_max = Math.abs(d);
})
// Add X axis
x = d3.scaleLinear()
.domain([-tsne_x_max * 1.2, tsne_x_max * 1.2])
.range([0, width]);
y = d3.scaleLinear()
.domain([-tsne_y_max * 1.2, tsne_y_max * 1.2])
.range([height, 0]);

g.selectAll("path")
.data(data)
.join("path")
.attr("d", d => `M${x(parseFloat(d[1]))},${y(parseFloat(d[2]))}h0`)
.attr("stroke", d => z(parseFloat(d[d.length - 1]))) // expression. or,
.attr("stroke", d => cell_type_scale_ordinal(d[3])   // cell type.
.attr("stroke-width", function(d) { return 4; });
