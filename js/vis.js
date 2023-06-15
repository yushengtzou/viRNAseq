function tsnePlot(elementId, data, barcode, xValue, yValue, cluster) {
    // Color scale
    var color = d3.scaleOrdinal(d3.schemeCategory10);

    // Define a div for the tooltip
    var tooltip = d3.select("body").append("div")	
        .attr("class", "tooltip")				
        .style("opacity", 0);

    // Change the color scheme based on user selection
    d3.select("#colorSchemeSelect").on("change", function() {
        var selectedOption = d3.select(this).property("value");

        switch (selectedOption) {
            case "Category10":
                color = d3.scaleOrdinal(d3.schemeCategory10);
                break;
            case "Paired":
                color = d3.scaleOrdinal(d3.schemePaired);
                break;
            case "Set1":
                color = d3.scaleOrdinal(d3.schemeSet1);
                break;
            case "Set2":
                color = d3.scaleOrdinal(d3.schemeSet2);
                break;
            case "Set3":
                color = d3.scaleOrdinal(d3.schemeSet3);
                break;
            case "Tableau10":
                color = d3.scaleOrdinal(d3.schemeTableau10);
                break;
            default:
                color = d3.scaleOrdinal(d3.schemeCategory10);
        }
        
        // Redraw the plot with new color scheme
        drawPlot();
    });

    const drawPlot = () => {
        const margin = { top: 56, right: 29, bottom: 2, left: 29 };
        const size = 540; 
        const width = size - margin.left - margin.right;
        const height = size - margin.top - margin.bottom;

        const x = d3.scaleLinear().range([margin.left, width - margin.right]);
        const y = d3.scaleLinear().range([height - margin.bottom, margin.top]);

        const xAxis = g => g
        .attr("transform", `translate(0,${height - margin.bottom})`)
        .call(d3.axisBottom(x));
        const yAxis = g => g
        .attr("transform", `translate(${margin.left},0)`)
        .call(d3.axisLeft(y));

        x.domain(d3.extent(data, d => +d[xValue])).nice();
        y.domain(d3.extent(data, d => +d[yValue])).nice();

         const svgWidth = width + margin.left + margin.right + 168;  // extra 150 units for the legend
        const svg = d3.select(`#${elementId}`)
        .attr('width', svgWidth)
        .attr('height', height + margin.top + margin.bottom);


        svg.append("text")
        .attr("x", (width + margin.left + margin.right) / 2+10)
        .attr("y", margin.top / 2)
        .attr("text-anchor", "middle")
        .style("font-size", "20px") 
        .text("t-SNE Projection of Cells by Clustering"); 

        // Color gradient bar




        // End color gradient bar

        svg.append('g').call(xAxis);
        svg.append('g').call(yAxis);

        svg.append('g')
        .selectAll('circle')
        .data(data)
        .join('circle')
        .filter(d => !isNaN(+d[xValue]) && !isNaN(+d[yValue]))  
        .attr('cx', d => x(+d[xValue]))
        .attr('cy', d => y(+d[yValue]))
        .attr('r', 3.5)
        .attr('fill', d => color(d[cluster]))
        .on("mouseover", function(event, d) {
            d3.select(this).transition()
                .duration('100')
                .attr("r", 7);  // Increase the circle size
            tooltip.transition()
                .duration(200)
                .style("opacity", 1.0);
            tooltip.html(d[barcode])
                .style("left", (event.pageX) + "px")		
                .style("top", (event.pageY - 28) + "px");	
            tooltip.style("background-color", d3.select(this).style("fill"));
                
        })					
        .on("mouseout", function(d) {
            d3.select(this).transition()
                .duration('200')
                .attr("r", 3.5);  // Reset the circle size
            tooltip.transition()
                .duration(500)
                .style("opacity", 0);
        });

        // Get unique clusters and sort them in ascending order
        let clusters = Array.from(new Set(data.map(d => d[cluster]))).sort((a, b) => a - b);

        // Append a group to hold the legend items, positioned to the right of the plot
        let legend = svg.append("g")
            .attr("transform", `translate(${width + 66},${margin.top})`);

        // Create one legend item for each unique cluster
        clusters.forEach((c, i) => {
            let legendItem = legend.append("g")
                .attr("transform", `translate(0, ${i * 20})`);

            // Add the color square
            legendItem.append("rect")
                .attr("width", 10)
                .attr("height", 10)
                .attr("fill", color(c));

            // Add the text label
            legendItem.append("text")
                .attr("x", 15)
                .attr("y", 10)
                .text(c);
        });

    }



    // Initial draw
    drawPlot();
}

function saveAsPng() {
    // get the svg element
    let svg = document.querySelector('svg');  

    // store original background color and set it to white
    let originalBackground = svg.style.background;
    svg.style.background = "#FFFFFF";
    
    // specify the xml namespace in your SVG string
    let svgString = new XMLSerializer().serializeToString(svg);
    let svgXML = '<?xml version="1.0" standalone="no"?>\r\n' + svgString; 
    
    // create an empty canvas
    let canvas = document.createElement('canvas'); 
    let context = canvas.getContext('2d');

    let image = new Image();

    // set the src before the onload function
    image.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgXML);

    image.onload = function() {
        canvas.width = image.width;
        canvas.height = image.height;
        context.drawImage(image, 0, 0);
        // create an <a> element
        let a = document.createElement('a');  
        a.download = 't-SNE plot.png';  // set filename
        // convert canvas to PNG
        a.href = canvas.toDataURL('image/png');  
        a.click();  // simulate a click

        // reset SVG background color
        svg.style.background = originalBackground;
    };
}

document.getElementById('submit').addEventListener('click', function(e) {
    e.preventDefault();  // Prevent form from submitting
    let fileInput = document.getElementById('csvFile');
    let file = fileInput.files[0];

    let reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('svg').style.visibility = 'visible';
        document.getElementById('set_card').style.visibility = 'visible';
        let contents = e.target.result;
        let data = d3.csvParse(contents);

        tsnePlot("scatterplot", data, 'Barcode','TSNE-1', 'TSNE-2', 'Cluster');

        // Create a FormData object
        let formData = new FormData();
        // Add the file to the form data
        formData.append("files", file);
        formData.append("submit", "Upload File");  // add this line
        // Send the form data to the server using Fetch API
        fetch('../php/upload_file.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch((error) => {
          console.error('Error:', error);
        });

    };
    var introCard = document.getElementById('intro_card');
    document.getElementsByTagName('svg')[0].style.visibility = 'visible';
    introCard.style.display = 'none';

    reader.readAsText(file);
});


