<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    .active {
        background: red !important;
    }
</style>

<body>
    <div class="pt-5">
        <div class="container" style="width:800px">
            <div class="" style="display: ruby-text">
                <div class="">
                    <div class="row pb-5" id="stepButtons">
                        <div class="col-3">
                            <button class="step-button g btn btn-secondary">Step1</button>
                        </div>
                        <div class="col-3">
                            <button class="step-button2 g btn btn-secondary">Step2</button>
                        </div>
                        <div class="col-3">
                            <button class="step-button3 g btn btn-secondary">Step3</button>
                        </div>
                        <div class="col-3">
                            <button class="step-button4 g btn btn-secondary">Review</button>
                        </div>
                    </div>
                </div>
            </div>
            <form id="mealForm" class="justify-content-center">
                @csrf
                <!-- Phần tử 1 -->
                <div class="step" id="step1">
                    <div class="mb-3">
                        <label for="meal" class="form-label">Meal Category </label>
                        <select class="form-select" id="meal" aria-label="Default select example">
                            <option value="">Chọn AvailableMeals</option>
                            @foreach ($availableMeals as $item)
                                <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="people " class="form-label">Number People</label>
                        <input type="number" class="form-control" max="10" min="0" id="people">
                        <div id="peopleError" class="text-danger"></div>
                        <div id="" class="form-text">Maximum 10.</div>
                    </div>
                    <button type="button" class="btn btn-success" id="nextButton">Next</button>
                </div>

                <!-- Phần tử 2 -->
                <div class="step" id="step2" style="display: none;">
                    <div class="mb-3">
                        <label for="restaurant" class="form-label">Please select a Restaurant </label>
                        <select id="restaurant" class="form-select" name="restaurant">
                            <option value="">Chọn nhà hàng</option>
                            <!-- Option values will be populated dynamically using JavaScript -->
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6"> <button type="button" class="btn btn-warning btn-back">Back</button></div>
                        <div class="col-6"> <button type="button" class="btn btn-success"
                                id="nextButton2">Next</button>
                        </div>
                    </div>
                </div>

                <!-- Phần tử 3 -->
                <div class="step" id="step3" style="display: none;">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6"> <label for="dish" class="form-label">Please Select a Dish</label>
                                <select class="form-select" id="dish" aria-label="Default select example">
                                    <option value="">Choose a Dish</option>
                                    <!-- Options will be populated dynamically using JavaScript -->
                                </select>
                            </div>
                            <div class="col-6"> <label for="dish" class="form-label">Please Select a Dish</label>
                                <input type="number" class="form-select" min="0" value="1">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-6"> <button type="button" class="btn btn-warning btn-back">Back</button>
                            </div>
                            <div class="col-6"> <button type="button" class="btn btn-success"
                                    id="nextButton3">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Phần tử 4 -->
                <div class="step" id="step4" style="display: none;">
                    <div class="mb-3">
                        <label for="dish" class="form-label">Please Select a Dish</label>

                        <p>Meal: <span id="selectedMeal"></span></p>
                        <p>Restaurant: <span id="selectedRestaurant"></span></p>
                        <p>numberOfPeople: <span id="numberOfPeople"></span></p>
                        <p>Dish: <span id="selectedDish"></span></p>
                        <div class="row">
                            <div class="col-6"> <button type="button"
                                    class="btn btn-warning btn-back">Back</button>
                            </div>
                            <div class="col-6"> <button type="submit" class="btn btn-success">submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.step-button').addClass('active');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var selectedMeal = "";
        var selectedRestaurant = "";
        var selectedDish = "";

        $('#mealForm').on('click', '#nextButton', function() {
            var currentStep = $(this).closest('.step');
            var meal = $('#meal').val();
            var people = $('#people').val();

            if (meal === '' || people === '') {
                $('#peopleError').text('Vui lòng chọn thông tin');
                return;
            }

            if (people <= 0 || people > 10) {
                $('#peopleError').text('Chỉ được số từ 1 và nhỏ hơn hoặc bằng 10');
                return;
            }

            selectedMeal = meal; // Lưu trữ món ăn đã chọn
            currentStep.hide();
            currentStep.next('.step').show();
            $('.step-button').removeClass('active');
            // Thêm lớp active cho nút tương ứng
            $('.step-button2').addClass('active');
        });

        $('#mealForm').on('click', '#nextButton2', function() {
            var currentStep = $(this).closest('.step');
            selectedRestaurant = $('#restaurant').val();

            // Gửi yêu cầu AJAX để lấy danh sách món ăn dựa trên suất ăn và nhà hàng đã chọn
            $.ajax({
                url: '/get-dishes',
                type: 'GET',
                data: {
                    restaurant: selectedRestaurant,
                    meal: selectedMeal
                },
                success: function(response) {
                    $('#dish').empty(); // Xóa các option hiện tại
                    $.each(response, function(key, value) {
                        $('#dish').append('<option value="' + value.id + '">' +
                            value.name + '</option>');
                    });
                    // Chuyển sang bước tiếp theo
                    $('#step2').hide();
                    $('#step3').show();
                    $('.step-button2').removeClass('active');
                    // Thêm lớp active cho nút tương ứng
                    $('.step-button3').addClass('active');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        var numberOfPeople = ""; // Biến để lưu giá trị "Number People"

        $(document).on('change', '#people', function() {
            numberOfPeople = $(this).val();
        });
        $('#mealForm').on('click', '#nextButton3', function() {
            var currentStep = $(this).closest('.step');
            currentStep.hide();
            currentStep.next('.step').show();
            $('.step-button3').removeClass('active');
            // Thêm lớp active cho nút tương ứng
            $('.step-button4').addClass('active');
            $('#selectedMeal').text(selectedMeal);
            $('#selectedRestaurant').text(selectedRestaurant);
            $('#numberOfPeople').text(numberOfPeople);
            $('#selectedDish').text($('#dish option:selected').text());
        });

        $('#mealForm').on('click', '.btn-warning', function() {
            var currentStep = $(this).closest('.step');
            var prevStep = currentStep.prev('.step');

            // Ẩn bước hiện tại và hiển thị bước trước đó
            currentStep.hide();
            prevStep.show();

            // Loại bỏ lớp "active" từ tất cả các nút
            $('.btn-secondary').removeClass('active');

            // Kích hoạt nút của bước trước đó bằng cách thêm lớp "active"
            prevStep.find('.btn-secondary').addClass('active');
        });

        $(document).on('change', '#meal', function() {
            var selectedMeal = $(this).val();
            console.log(selectedMeal);
            $.ajax({
                url: '/get-restaurants',
                type: 'GET',
                data: {
                    meal: selectedMeal
                },
                success: function(response) {
                    $('#restaurant').empty();
                    $.each(response, function(key, value) {
                        $('#restaurant').append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $(document).on('change', '#dish', function() {
            selectedDish = $(this).val();

        });

        $('#mealForm').submit(function(e) {
            e.preventDefault();

            var formData = {
                meal: selectedMeal,
                restaurant: selectedRestaurant,
                dish: $('#dish').val(),
                numberOfPeople: numberOfPeople
            };
            $.ajax({
                url: '/order_dishes',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>




</html>
