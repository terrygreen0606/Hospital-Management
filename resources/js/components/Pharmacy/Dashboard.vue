<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <!-- <div class="row">
						<div class="col-md-4 col-sm-6 col-12 dashboard-users-success">
							<div class="card text-center">
								<div class="card-content">
									<div class="card-body py-1 card-dashboard">
										<div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
											<i class="bx bx-group font-medium-5"></i>
										</div>
										<div class="text-muted line-ellipsis">Prescribers</div>
										<h3 class="mb-0">{{ data.doctors }}</h3>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 dashboard-users-success">
							<div class="card text-center">
								<div class="card-content">
									<div class="card-body py-1 card-dashboard">
										<div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
											<i class="bx bx-plus-medical font-medium-5"></i>
										</div>
										<div class="text-muted line-ellipsis">Pharmacies</div>
										<h3 class="mb-0">{{ data.pharmacies }}</h3>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-12 dashboard-users-success">
							<div class="card text-center">
								<div class="card-content">
									<div class="card-body py-1 card-dashboard">
										<div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
											<i class="bx bx-bed font-medium-5"></i>
										</div>
										<div class="text-muted line-ellipsis">Patients</div>
										<h3 class="mb-0">{{ data.patients }}</h3>
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<div class="row">
						<div class="col-md-12">
                            <div class="card card-dashboard">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Adherence</h4>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pb-1" style="position: relative;">
                                        <div class="d-flex justify-content-around align-items-center flex-wrap">
                                            <div class="user-analytics">
                                                <i class="bx bx-user mr-25 align-middle"></i>
                                                <span class="align-middle text-muted">Prescribed</span>
                                                <div class="d-flex" style="position: relative;">
                                                    <div id="radial-success-chart" style="min-height: 91.4146px;"><div id="apexcharts5fvmjqgsi" class="apexcharts-canvas apexcharts5fvmjqgsi light" style="width: 40px; height: 91.4146px;"><svg id="SvgjsSvg1558" width="40" height="91.41463414634147" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1560" class="apexcharts-inner apexcharts-graphical" transform="translate(-12.5, 0)"><defs id="SvgjsDefs1559"><clipPath id="gridRectMask5fvmjqgsi"><rect id="SvgjsRect1561" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMask5fvmjqgsi"><rect id="SvgjsRect1562" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1568" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1569" stop-opacity="1" stop-color="rgba(242,242,242,1)" offset="0"></stop><stop id="SvgjsStop1570" stop-opacity="0.8" stop-color="rgba(57,218,138,0.8)" offset="0.7"></stop><stop id="SvgjsStop1571" stop-opacity="0.8" stop-color="rgba(57,218,138,0.8)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1577" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1578" stop-opacity="1" stop-color="rgba(57,218,138,1)" offset="0"></stop><stop id="SvgjsStop1579" stop-opacity="0.8" stop-color="rgba(57,218,138,0.8)" offset="0.7"></stop><stop id="SvgjsStop1580" stop-opacity="0.8" stop-color="rgba(57,218,138,0.8)" offset="1"></stop></linearGradient></defs><g id="SvgjsG1564" class="apexcharts-radialbar"><g id="SvgjsG1565"><g id="SvgjsG1566" class="apexcharts-tracks"><g id="SvgjsG1567" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.877634146341464" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487"></path></g></g><g id="SvgjsG1573"><g id="SvgjsG1576" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1581" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 0 1 46.49096921471761 37.04594146724999" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient1577)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.9975609756097565" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="108" data:value="30" index="0" j="0" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 0 1 46.49096921471761 37.04594146724999"></path></g><circle id="SvgjsCircle1574" r="7.772158536585366" cx="32.5" cy="32.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1575" class="apexcharts-datalabels-group" transform="translate(0, 0)" style="opacity: 1;"></g></g></g></g><line id="SvgjsLine1582" x1="0" y1="0" x2="65" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1583" x1="0" y1="0" x2="65" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-legend"></div></div></div>
                                                    <h3 class="mt-1 ml-50">{{ data.invoice ? data.invoice.t_invoice : 0 }}</h3>
                                                <div class="resize-triggers"><div class="expand-trigger"><div style="width: 91px; height: 92px;"></div></div><div class="contract-trigger"></div></div></div>
                                            </div>
                                            <div class="sessions-analytics">
                                                <i class="bx bx-trending-up align-middle mr-25"></i>
                                                <span class="align-middle text-muted">Filled</span>
                                                <div class="d-flex" style="position: relative;">
                                                    <div id="radial-warning-chart" style="min-height: 91.4146px;"><div id="apexchartszpd68wt1" class="apexcharts-canvas apexchartszpd68wt1 light" style="width: 40px; height: 91.4146px;"><svg id="SvgjsSvg1586" width="40" height="91.41463414634147" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1588" class="apexcharts-inner apexcharts-graphical" transform="translate(-12.5, 0)"><defs id="SvgjsDefs1587"><clipPath id="gridRectMaskzpd68wt1"><rect id="SvgjsRect1589" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskzpd68wt1"><rect id="SvgjsRect1590" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1596" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1597" stop-opacity="1" stop-color="rgba(242,242,242,1)" offset="0"></stop><stop id="SvgjsStop1598" stop-opacity="0.8" stop-color="rgba(253,172,65,0.8)" offset="0.7"></stop><stop id="SvgjsStop1599" stop-opacity="0.8" stop-color="rgba(253,172,65,0.8)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1605" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1606" stop-opacity="1" stop-color="rgba(253,172,65,1)" offset="0"></stop><stop id="SvgjsStop1607" stop-opacity="0.8" stop-color="rgba(253,172,65,0.8)" offset="0.7"></stop><stop id="SvgjsStop1608" stop-opacity="0.8" stop-color="rgba(253,172,65,0.8)" offset="1"></stop></linearGradient></defs><g id="SvgjsG1592" class="apexcharts-radialbar"><g id="SvgjsG1593"><g id="SvgjsG1594" class="apexcharts-tracks"><g id="SvgjsG1595" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.877634146341464" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487"></path></g></g><g id="SvgjsG1601"><g id="SvgjsG1604" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1609" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 18.509030785282395 27.954058532750008" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient1605)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.9975609756097565" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="288" data:value="80" index="0" j="0" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 18.509030785282395 27.954058532750008"></path></g><circle id="SvgjsCircle1602" r="7.772158536585366" cx="32.5" cy="32.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1603" class="apexcharts-datalabels-group" transform="translate(0, 0)" style="opacity: 1;"></g></g></g></g><line id="SvgjsLine1610" x1="0" y1="0" x2="65" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1611" x1="0" y1="0" x2="65" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-legend"></div></div></div>
                                                    <h3 class="mt-1 ml-50">{{ data.invoice ? data.invoice.t_completed : 0 }}</h3>
                                                <div class="resize-triggers"><div class="expand-trigger"><div style="width: 95px; height: 92px;"></div></div><div class="contract-trigger"></div></div></div>
                                            </div>
                                            <div class="bounce-rate-analytics">
                                                <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                                <span class="align-middle text-muted">Adherence</span>
                                                <div class="d-flex" style="position: relative;">
                                                    <div id="radial-danger-chart" style="min-height: 91.4146px;"><div id="apexchartsvyvway14" class="apexcharts-canvas apexchartsvyvway14 light" style="width: 40px; height: 91.4146px;"><svg id="SvgjsSvg1614" width="40" height="91.41463414634147" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1616" class="apexcharts-inner apexcharts-graphical" transform="translate(-12.5, 0)"><defs id="SvgjsDefs1615"><clipPath id="gridRectMaskvyvway14"><rect id="SvgjsRect1617" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskvyvway14"><rect id="SvgjsRect1618" width="67" height="7" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1624" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1625" stop-opacity="1" stop-color="rgba(242,242,242,1)" offset="0"></stop><stop id="SvgjsStop1626" stop-opacity="0.8" stop-color="rgba(255,91,92,0.8)" offset="0.7"></stop><stop id="SvgjsStop1627" stop-opacity="0.8" stop-color="rgba(255,91,92,0.8)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1633" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1634" stop-opacity="1" stop-color="rgba(255,91,92,1)" offset="0"></stop><stop id="SvgjsStop1635" stop-opacity="0.8" stop-color="rgba(255,91,92,0.8)" offset="0.7"></stop><stop id="SvgjsStop1636" stop-opacity="0.8" stop-color="rgba(255,91,92,0.8)" offset="1"></stop></linearGradient></defs><g id="SvgjsG1620" class="apexcharts-radialbar"><g id="SvgjsG1621"><g id="SvgjsG1622" class="apexcharts-tracks"><g id="SvgjsG1623" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.877634146341464" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 1 1 32.497432450407324 17.78902461430487"></path></g></g><g id="SvgjsG1629"><g id="SvgjsG1632" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1637" d="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 0 1 32.5 47.2109756097561" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient1633)" stroke-opacity="1" stroke-linecap="round" stroke-width="3.9975609756097565" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="180" data:value="50" index="0" j="0" data:pathOrig="M 32.5 17.789024390243902 A 14.710975609756098 14.710975609756098 0 0 1 32.5 47.2109756097561"></path></g><circle id="SvgjsCircle1630" r="7.772158536585366" cx="32.5" cy="32.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1631" class="apexcharts-datalabels-group" transform="translate(0, 0)" style="opacity: 1;"></g></g></g></g><line id="SvgjsLine1638" x1="0" y1="0" x2="65" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1639" x1="0" y1="0" x2="65" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-legend"></div></div></div>
                                                    <h3 class="mt-1 ml-50">{{ data.invoice ? data.invoice.per.toFixed(2) : 0 }}%</h3>
                                                <div class="resize-triggers"><div class="expand-trigger"><div style="width: 120px; height: 92px;"></div></div><div class="contract-trigger"></div></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-dashboard">
								<div class="card-header d-flex align-items-center justify-content-between">
									<h4 class="card-title">Total List</h4>
									<i class="bx bx-dots-vertical-rounded font-medium-3 align-middle cursor-pointer"></i>
								</div>
								<div class="card-content">
									<div class="card-body" style="position: relative;">
										<div class="row">
										<div class="col-md-3">
											<div class="card">
												<div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
													<div class="d-flex align-items-center">
														<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
															<div class="avatar-content">
																<i class="bx bx-user text-primary font-medium-2"></i>
															</div>
														</div>
														<div class="total-amount">
															<h5 class="mb-0">{{data.week}}</h5>
															<small class="text-muted">Week</small>
														</div>
													</div>
												<div class="resize-triggers"><div class="expand-trigger"><div style="width: 422px; height: 96px;"></div></div><div class="contract-trigger"></div></div></div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="card">
												<div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
													<div class="d-flex align-items-center">
														<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
															<div class="avatar-content">
																<i class="bx bx-user text-primary font-medium-2"></i>
															</div>
														</div>
														<div class="total-amount">
															<h5 class="mb-0">{{data.month}}</h5>
															<small class="text-muted">Month</small>
														</div>
													</div>
												<div class="resize-triggers"><div class="expand-trigger"><div style="width: 422px; height: 96px;"></div></div><div class="contract-trigger"></div></div></div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="card">
												<div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
													<div class="d-flex align-items-center">
														<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
															<div class="avatar-content">
																<i class="bx bx-user text-primary font-medium-2"></i>
															</div>
														</div>
														<div class="total-amount">
															<h5 class="mb-0">{{data.quarter}}</h5>
															<small class="text-muted">Quarter</small>
														</div>
													</div>
												<div class="resize-triggers"><div class="expand-trigger"><div style="width: 422px; height: 96px;"></div></div><div class="contract-trigger"></div></div></div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="card">
												<div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
													<div class="d-flex align-items-center">
														<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
															<div class="avatar-content">
																<i class="bx bx-user text-primary font-medium-2"></i>
															</div>
														</div>
														<div class="total-amount">
															<h5 class="mb-0">{{data.year}}</h5>
															<small class="text-muted">Year</small>
														</div>
													</div>
												<div class="resize-triggers"><div class="expand-trigger"><div style="width: 422px; height: 96px;"></div></div><div class="contract-trigger"></div></div></div>
											</div>
										</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
    data() {
        return {
            data: {},
            user: {}
        };
    },

    mounted() {
        this.user = this.$auth.user()

        this.axios.get(`/api/prescriberReports/${this.$auth.user().id}`).then(response => {
            this.data = response.data
            console.log(response.data)
        });
    },

    methods: {
        
    }
};
</script>

<style lang="scss">
	.card-dashboard {
		background-color: #F2F4F4;
	}

</style>