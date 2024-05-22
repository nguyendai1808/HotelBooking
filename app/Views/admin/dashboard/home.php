<section class="main-section">
    <div class="overview-boxes">
        <div class="box-item">
            <div class="box-content">
                <div class="box-price">
                    <h5>Doanh thu thực tế</h5>
                    <h3>11.000.000</h3>
                </div>
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div class="up-down">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text">Trong 1 tháng</span>
            </div>
        </div>

        <div class="box-item">
            <div class="box-content">
                <div class="box-price">
                    <h5>Doanh thu dự tính</h5>
                    <h3>270.000.000</h3>
                </div>
                <i class="fa-solid fa-money-bill-transfer predict"></i>
            </div>
            <div class="up-down">
                <i class="fa-solid fa-angle-up"></i>
                <span class="text">Trong 1 tháng</span>
            </div>
        </div>

        <div class="box-item">
            <div class="box-content">
                <div class="box-price">
                    <h5>Các khoản giảm trừ</h5>
                    <h3>1.520.000</h3>
                </div>
                <i class="fa-solid fa-dollar-sign deduction"></i>
            </div>
            <div class="up-down">
                <i class="fa-solid fa-angle-down down"></i>
                <span class="text">Trong 1 tháng</span>
            </div>
        </div>
    </div>

    <div>

    <?php

$dataPoints = array(
  array("y" => 700, "label" => "Tháng 1"),
  array("y" => 300, "label" => "Tháng 2"),
  array("y" => 200, "label" => "Tháng 3"),
  array("y" => 900, "label" => "Tháng 4"),
  array("y" => 600, "label" => "Tháng 5"),
  array("y" => 400, "label" => "Tháng 6"),
  array("y" => 500, "label" => "Tháng 7"),
  array("y" => 359, "label" => "Tháng 8"),
  array("y" => 200, "label" => "Tháng 9"),
  array("y" => 232, "label" => "Tháng 10"),
  array("y" => 354, "label" => "Tháng 11"),
  array("y" => 456, "label" => "Tháng 12")
);

$dataPoints1 = array(
  array("y" => 7000000, "label" => "Tháng 1"),
  array("y" => 3000000, "label" => "Tháng 2"),
  array("y" => 2000000, "label" => "Tháng 3"),
  array("y" => 9000000, "label" => "Tháng 4"),
  array("y" => 6000000, "label" => "Tháng 5"),
  array("y" => 4000000, "label" => "Tháng 6"),
  array("y" => 5000000, "label" => "Tháng 7"),
  array("y" => 3590000, "label" => "Tháng 8"),
  array("y" => 2000000, "label" => "Tháng 9"),
  array("y" => 2320000, "label" => "Tháng 10"),
  array("y" => 3540000, "label" => "Tháng 11"),
  array("y" => 4560000, "label" => "Tháng 12")
);

$dataPoints2 = array(
  array("label" => "Phòng nhỏ", "y" => 10),
  array("label" => "Phòng thường", "y" => 20),
  array("label" => "Phòng lớn", "y" => 30),
  array("label" => "Phòng gia đình", "y" => 25),
  array("label" => "Phòng view", "y" => 15)
)

?>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script>
            window.onload = function() {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Thống kê đơn đặt phòng"
                    },
                    backgroundColor: "white",
                    data: [{
                        type: "column",
                        yValueFormatString: "#,##0.## đơn đặt",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();



                var chart1 = new CanvasJS.Chart("chartContainer1", {
                    animationEnabled: true,
                    title: {
                        text: "thống kê doanh thu"
                    },
                    backgroundColor: "white",
                    data: [{
                        type: "spline",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                    }]
                });

                chart1.render();


                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    animationEnabled: true,
                    title: {
                        text: "Thống kế số đơn theo danh mục phòng"
                    },
                    data: [{
                        type: "pie",
                        indexLabel: "{y}",
                        yValueFormatString: "#,##0.00\"%\"",
                        indexLabelPlacement: "inside",
                        indexLabelFontColor: "#36454F",
                        indexLabelFontSize: 15,
                        indexLabelFontWeight: "bolder",
                        showInLegend: true,
                        legendText: "{label}",
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart2.render();

            }
        </script>
        <style>
            .canvasjs-chart-credit {
                display: none;
            }
        </style>
        <h4 class="table-title ms-3 fw-bold">Thống kê</h4>
        <div class="row p-3">
            <div class="col-lg-7 mt-4" id="chartContainer" style="height: 370px;"></div>
            <div class="col-lg-5" id="chartContainer2" style="height: 370px;"></div>
            <div class="col-lg-12 mt-4" id="chartContainer1" style="height: 370px;"></div>
        </div>
        
    </div>

    <div class="table-warpper">
        <h4 class="table-title">Danh sách tài khoản</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="email"> Email <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Ngày tạo <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="#" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small> Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="stt">1</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu Chan Lee</td>
                        <td class="email">Zinzu@gmail.com</td>
                        <td class="date">20-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">2</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu Chan Lee</td>
                        <td class="email">Zinzu@gmail.com</td>
                        <td class="date">21-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">3</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu Chan Lee</td>
                        <td class="email">Zinzu@gmail.com</td>
                        <td class="date">22-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">4</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu Chan Lee</td>
                        <td class="email">Zinzu@gmail.com</td>
                        <td class="date">23-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">5</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu dsa Chan Lee</td>
                        <td class="email">Zinzu@gmail.com</td>
                        <td class="date">25-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivdsaered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">6</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu da Chan Lee</td>
                        <td class="email">Zidsanzu@gmail.com</td>
                        <td class="date">27-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivvvzzered</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">7</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzu Chan dsadas Lee</td>
                        <td class="email">Zindsaaazu@gmail.com</td>
                        <td class="date">20-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Deliverbbbed</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="stt">8</td>
                        <td class="name"><img src="<?= ADMIN_PATH ?>/images/profile.jpg" alt="">Zinzdá u Chan Lee</td>
                        <td class="email">Zindsazu@gmail.com</td>
                        <td class="date">27-03-2024</td>
                        <td class="status">
                            <p class="status delivered">Delivermmmed</p>
                        </td>
                        <td class="method">
                            <a href="#" class="btn btn-info text-white" style="margin: 0 5px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="btn btn-danger text-white" style="margin: 0 5px;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</section>