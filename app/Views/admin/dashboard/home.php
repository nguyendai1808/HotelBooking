<section class="main-section">
    <div class="dash">
        <div class="row m-2">
            <div class="col-12">
                <div class="overview-boxes">
                    <div class="box-item">
                        <div class="box-content">
                            <div class="box-price">
                                <h5>Doanh thu thực tế</h5>
                                <h3><?= !empty($data['actual']) ? number_format($data['actual'], 0, ',', '.') : 0; ?></h3>
                            </div>
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                        <div class="up-down">

                            <?php if (!empty($data['updownActual']) && $data['updownActual'] == 'up') : ?>

                                <i class="fa-solid fa-angle-up"></i>

                            <?php else : ?>

                                <i class="fa-solid fa-angle-down down"></i>

                            <?php endif; ?>

                            <span class="text">Trong 1 tháng</span>
                        </div>
                    </div>

                    <div class="box-item">
                        <div class="box-content">
                            <div class="box-price">
                                <h5>Doanh thu dự tính</h5>
                                <h3><?= !empty($data['estimated']) ? number_format($data['estimated'], 0, ',', '.') : 0; ?></h3>
                            </div>
                            <i class="fa-solid fa-money-bill-transfer predict"></i>
                        </div>
                        <div class="up-down">

                            <?php if (!empty($data['updownEstimated']) && $data['updownEstimated'] == 'up') : ?>

                                <i class="fa-solid fa-angle-up"></i>

                            <?php else : ?>

                                <i class="fa-solid fa-angle-down down"></i>

                            <?php endif; ?>

                            <span class="text">Trong 1 tháng</span>
                        </div>
                    </div>

                    <div class="box-item">
                        <div class="box-content">
                            <div class="box-price">
                                <h5>Các đơn hủy đặt</h5>
                                <h3><?= !empty($data['deductible']) ? number_format($data['deductible'], 0, ',', '.') : 0; ?></h3>
                            </div>
                            <i class="fa-solid fa-dollar-sign deduction"></i>
                        </div>
                        <div class="up-down">

                            <?php if (!empty($data['updownDeductible']) && $data['updownDeductible'] == 'up') : ?>

                                <i class="fa-solid fa-angle-up"></i>

                            <?php else : ?>

                                <i class="fa-solid fa-angle-down down"></i>

                            <?php endif; ?>

                            <span class="text">Trong 1 tháng</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 mt-4">
                <div id="chartContainer1" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="col-lg-5 mt-4">
                <div id="chartContainer2" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="col-12 mt-5">
                <div id="chartContainer3" style="height: 400px; width: 100%;"></div>
            </div>

        </div>

    </div>
</section>

<style>
    .canvasjs-chart-credit {
        display: none;
    }
</style>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    window.onload = function() {
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            title: {
                text: "Thống kê đơn đặt trong năm",
                fontFamily: "Poppins, sans-serif",
                fontSize: 25
            },
            backgroundColor: "white",
            axisX: {
                interval: 2
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## đơn đặt",
                dataPoints: <?php echo json_encode($data['dataPoints1'], JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart1.render();

        var chart2 = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            title: {
                text: "Thống kê số đơn đặt trong tháng",
                fontFamily: "Poppins, sans-serif",
                fontSize: 25
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,###\" đơn\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bolder",
                fontFamily: "Poppins, sans-serif",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($data['dataPoints2'], JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart2.render();

        var chart3 = new CanvasJS.Chart("chartContainer3", {
            animationEnabled: true,
            title: {
                text: "Thống kê doanh thu trong năm",
                fontFamily: "Poppins, sans-serif",
                fontSize: 25
            },
            backgroundColor: "white",
            axisX: {
                interval: 2
            },
            data: [{
                type: "spline",
                yValueFormatString: "#,##0.##",
                dataPoints: <?php echo json_encode($data['dataPoints3'], JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart3.render();
    }
</script>