function createScatterPlot(elementId, data, xValue, yValue) {
      const margin = { top: 25, right: 20, bottom: 35, left: 40 };
      const width = 960 - margin.left - margin.right;
      const height = 500 - margin.top - margin.bottom;

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

d3.csv("../uploads/data.csv").then(data => {
  createScatterPlot("scatterplot", data, 'flipper_length_mm', 'body_mass_g');
});
d3.csv("../uploads/data.csv").then(data => {
  createScatterPlot("scatterplot2", data, 'culmen_length_mm', 'body_mass_g');
});
