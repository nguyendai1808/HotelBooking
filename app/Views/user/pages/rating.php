<?php if (!empty($rating)) : ?>

    <div class="rating-room" id="rating">
        <form class="rating-form" action="<?= URLROOT ?>/history/rating" method="post">
            <h4 class="mb-3">Đánh giá của bạn</h4>
            <div class="row">

                <?php foreach ($rating as $item) : ?>
                    <div class="col-lg-6 mb-3">
                        <div class="rating-box">
                            <h6 class="m-0"><?= $item['tentieuchi'] ?></h6>
                            <p class="m-0"><span class="rating-value">10</span> điểm</p>
                        </div>
                        <input type="range" min="1" step="1" max="10" name="criteria[<?= $item['idtieuchi'] ?>]" value="10"/>
                    </div>
                <?php endforeach; ?>

                <div class="col-lg-6 mb-3">
                    <p>Tổng điểm đánh giá: <span class="score">10</span>/10</p>
                </div>
                <div class="star mb-3 col-lg-6">
                    <span class="fa-star text-warning"></span>
                    <span class="fa-star text-warning"></span>
                    <span class="fa-star text-warning"></span>
                    <span class="fa-star text-warning"></span>
                    <span class="fa-star text-warning"></span>
                </div>
                <div class="col-lg-12 mb-3">
                    <textarea role="3" placeholder="Nội dung đánh giá của bạn" id="content" name="content" required></textarea>
                </div>
            </div>
            <button class="btn btn-warning text-white me-2" type="submit" name="rating">Đánh giá</button>
            <button class="btn btn-danger ms-2" type="button" onclick="closeRating();">Hủy</button>

            <input type="hidden" name="idphong" id="idphong">
            <input type="hidden" name="idtaikhoan" id="idtaikhoan">
            <input type="hidden" name="iddatphong" id="iddatphong">
        </form>
    </div>


    <script>
        function openRating(idphong, idtaikhoan, iddatphong) {
            var rating = document.getElementById('rating');
            rating.style.display = 'inline-block';
            rating.querySelector('#idphong').value = idphong;
            rating.querySelector('#idtaikhoan').value = idtaikhoan;
            rating.querySelector('#iddatphong').value = iddatphong;
        }

        function closeRating() {
            var rating = document.getElementById('rating');
            rating.style.display = 'none';
            document.getElementById('content').value = '';
        }

        rating();

        function rating() {
            var ranges = document.querySelectorAll("input[type='range']");
            var ratingValues = document.querySelectorAll(".rating-value");
            var totalScoreElement = document.querySelector(".score");
            var starContainer = document.querySelector(".star");

            function updateScores() {
                let total = 0;
                ranges.forEach((range, index) => {
                    var value = range.value;
                    ratingValues[index].innerText = value;
                    total += parseInt(value);
                });

                var totalScore = total / ranges.length;
                totalScoreElement.innerText = totalScore % 1 === 0 ? totalScore : totalScore.toFixed(1);
                updateStars(totalScore);
            }

            function updateStars(score) {
                // Xóa các sao hiện có
                while (starContainer.firstChild) {
                    starContainer.removeChild(starContainer.firstChild);
                }

                score = score * 0.5;
                var fullStarsCount = Math.floor(score);
                var halfStarCount = (score - fullStarsCount) >= 0.5 ? 1 : 0;
                var emptyStarsCount = 5 - fullStarsCount - halfStarCount;

                // Thêm sao full
                for (let i = 0; i < fullStarsCount; i++) {
                    var star = document.createElement("span");
                    star.classList.add("fa", "fa-star", "text-warning");
                    starContainer.appendChild(star);
                }

                // Thêm nửa sao nếu có
                if (halfStarCount) {
                    var halfStar = document.createElement("span");
                    halfStar.classList.add("fa", "fa-star-half-stroke", "text-warning");
                    starContainer.appendChild(halfStar);
                }

                // Thêm sao trống
                for (let i = 0; i < emptyStarsCount; i++) {
                    var emptyStar = document.createElement("span");
                    emptyStar.classList.add("fa", "fa-regular", "fa-star", "text-warning");
                    starContainer.appendChild(emptyStar);
                }
            }

            ranges.forEach(range => {
                range.addEventListener("input", updateScores);
            });

            // Khởi tạo với các giá trị mặc định
            updateScores();
        }
    </script>

<?php endif; ?>