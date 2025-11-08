//   ----- monthly sales chart ----

var productsChartOptions = {
  chart: {
    type: "bar",
    height: 400,
    toolbar: {
      show: false,
    },
  },

  legend: {
    show: false,
  },

  series: [
    {
      name: "sales",
      data: [100, 80, 40, 60, 20],
    },
  ],

  xaxis: {
    categories: [
      "Hair Shampoo",
      "Hair Oil",
      "Moisturizing Cream",
      "Hair Conditioner",
      "Tatoo Healing Balm",
    ],
  },

  colors: ["#00aedaff", "#d60000ff", "#19d600ff", "#dda900ff", "#7700e6ff"],

  plotOptions: {
    bar: {
      distributed: true,
      borderRadius: 3,
      borderRadiusApplication: "end",
      columnWidth: "40%",
    },
  },

  dataLabels: {
    enabled: false,
  },
};

var productsChart = new ApexCharts(
  document.getElementById("bar-chart"),
  productsChartOptions
);
productsChart.render();

// ---- orders and bookings chart

var areaChartOptions = {
  chart: {
    height: 400,
    type: "area",
    toolbar: {
      show: false,
    },
  },

  series: [
    {
      name: "Orders",
      type: "line",
      data: [300, 265, 323, 330, 201, 206, 220],
    },
    {
      name: "Bookings",
      type: "line",
      data: [250, 220, 176, 163, 187, 201, 240],
    },
  ],

  colors: ["#ff5050ff", "#00a388ff"],
  dataLabels: {
    enabled: false,
  },
  fill: {
    type: "solid",
  },
  labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
  yaxis: [
    {
      title: {
        text: "Quantity",
      },
    },
  ],
};

var areaChart = new ApexCharts(
  document.querySelector("#area-chart"),
  areaChartOptions
);
areaChart.render();
