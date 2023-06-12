function penguinPlot(elementId, data, xValue, yValue) {
        const margin = { top: 25, right: 20, bottom: 35, left: 40 };
        const width = (960 - margin.left - margin.right)*3/4;
        const height = (500 - margin.top - margin.bottom)*3/4;

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

        const svg = d3.select(`#${elementId}`)
        .attr('width', width + margin.left + margin.right)
        .attr('height', height + margin.top + margin.bottom);

        svg.append('g').call(xAxis);
        svg.append('g').call(yAxis);

        svg.append('g')
        .selectAll('circle')
        .data(data)
        .join('circle')
        .filter(d => !isNaN(+d[xValue]) && !isNaN(+d[yValue]))  // Skip invalid data objects.
        .attr('cx', d => x(+d[xValue]))
        .attr('cy', d => y(+d[yValue]))
        .attr('r', 3.5);
}

function tsnePlot(elementId, data, xValue, yValue) {
        console.log(data);
        const margin = { top: 25, right: 20, bottom: 35, left: 40 };
        const width = (960 - margin.left - margin.right)*3/4;
        const height = (500 - margin.top - margin.bottom)*3/4;

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

        const svg = d3.select(`#${elementId}`)
        .attr('width', width + margin.left + margin.right)
        .attr('height', height + margin.top + margin.bottom);

        svg.append('g').call(xAxis);
        svg.append('g').call(yAxis);

        svg.append('g')
        .selectAll('circle')
        .data(data)
        .join('circle')
        // Skip invalid data objects.
        .filter(d => !isNaN(+d[xValue]) && !isNaN(+d[yValue]))  
        .attr('cx', d => x(+d[xValue]))
        .attr('cy', d => y(+d[yValue]))
        .attr('r', 3.5);
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('submit').addEventListener('click', function(e) {
        e.preventDefault();  // Prevent form from submitting
        let fileInput = document.getElementById('csvFile');
        let file = fileInput.files[0];

        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('svg').style.display = 'visible';
            let contents = e.target.result;
            let data = d3.csvParse(contents);

            tsnePlot("scatterplot", data, 'TSNE-1', 'TSNE-2');
            // penguinPlot("scatterplot", data, 'flipper_length_mm', 'body_mass_g');
            // createScatterPlot("scatterplot2", data, 'culmen_length_mm', 'body_mass_g');
        };
        var introCard = document.getElementById('intro_card');
        document.getElementsByTagName('svg')[0].style.visibility = 'visible';
        introCard.style.display = 'none';

        reader.readAsText(file);
    });
});

// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById('submit').addEventListener('click', function(e) {
//     e.preventDefault();  // Prevent form from submitting
//     let fileInput = document.getElementById('csvFile');
//     let file = fileInput.files[0];
//
//     let reader = new FileReader();
//     reader.onload = function(e) {
//         let contents = e.target.result;
//         let data = d3.csvParse(contents);
//         console.log(data);
//
//         // tsnePlot("scatterplot", data, 'TSNE-1', 'TSNE-2');
//         penguinPlot("scatterplot", data, 'flipper_length_mm', 'body_mass_g');
//         // createScatterPlot("scatterplot2", data, 'culmen_length_mm', 'body_mass_g');
//
//         document.getElementById('svg').style.visibility = 'display'; // corrected from display to visibility
//         var introCard = document.getElementById('intro_card');
//         introCard.style.display = 'none';
//     };
//
//     reader.readAsText(file);
//     });
// });
//
