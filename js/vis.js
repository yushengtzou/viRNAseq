function tsnePlot(elementId, data, barcode, xValue, yValue, cluster) {
    const margin = { top: 56, right: 29, bottom: 2, left: 29 };
    const size = 600; 
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

    // Color scale
    const color = d3.scaleOrdinal()
    // Domain based on the number of clusters
    .domain(d3.range(1, d3.max(data, d => +d[cluster]) + 1)) 
    .range(d3.schemeSet3);  // 12-color scheme

    x.domain(d3.extent(data, d => +d[xValue])).nice();
    y.domain(d3.extent(data, d => +d[yValue])).nice();

    const svg = d3.select(`#${elementId}`)
    .attr('width', width + margin.left + margin.right)
    .attr('height', height + margin.top + margin.bottom);

    svg.append("text")
    .attr("x", (width + margin.left + margin.right) / 2+10)
    .attr("y", margin.top / 3)
    .attr("text-anchor", "middle")
    .style("font-size", "20px") 
    .text("t-SNE plot"); 

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
    // Set fill color based on cluster.
    .attr('fill', d => color(d[cluster]));  
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('submit').addEventListener('click', function(e) {
        e.preventDefault();  // Prevent form from submitting
        let fileInput = document.getElementById('csvFile');
        let file = fileInput.files[0];

        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('svg').style.visibility = 'visible';
            let contents = e.target.result;
            let data = d3.csvParse(contents);

            tsnePlot("scatterplot", data, 'Barcode','TSNE-1', 'TSNE-2', 'Cluster');
        };
        var introCard = document.getElementById('intro_card');
        document.getElementsByTagName('svg')[0].style.visibility = 'visible';
        introCard.style.display = 'none';

        reader.readAsText(file);
    });
});

