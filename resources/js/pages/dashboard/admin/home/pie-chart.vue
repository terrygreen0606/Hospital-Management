<script type="text/javascript">
	import { Pie } from 'vue-chartjs';
	export default {
	  extends: Pie,
	  props: ['chartData'],
	  data: () => ({
	    options: {
	      responsive: true,
	      maintainAspectRatio: false,
	      legend: {
	      	display: true,
	      	position: 'bottom',
	      },

	    }
	  }),

	  mounted () {
	    this.renderChart(
	    {
	      labels: this.chartData.labels,
	      datasets: [
	        {
	          label: '',
	          backgroundColor: this.chartData.backgroundColor,
	          data: this.chartData.data,
	        }
	      ]
	    }, this.options)
	  }
	}
</script>