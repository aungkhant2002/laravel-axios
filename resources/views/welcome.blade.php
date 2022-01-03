<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel-Axios</title>
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-body">
                    <form action="{{ route('article.store') }}" method="post" id="fruitForm">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="col-3">
                                <input type="number" name="price" class="form-control">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset("js/app.js") }}"></script>
<script>

    $("#fruitForm").on("submit", function (e) {
        e.preventDefault();
        $.post($(this).attr("action"), $(this).serialize(), function (data) {
            if (data.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Data Insert Successful',
                    text: 'ဒေတာ ထည့်ခြင်း အောင်မြင်ပါသည်။',
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Fails',
                    text: 'Something went wrong!',
                })
            }
        })
    })

</script>
</body>
</html>
