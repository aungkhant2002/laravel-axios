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
                    <form action="{{ route('article.store') }}" method="post" id="fruitForm"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <input type="file" name="photo" class="form-control">
                            </div>
                            <div class="col-3">
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="col-3">
                                <input type="number" name="price" class="form-control">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-primary">
                                    <span class="spinner-grow spinner-grow-sm d-none btn-loader" role="status"
                                          aria-hidden="true"></span>
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table mt-5 align-middle" id="rows">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Controls</th>
                            <th>Created_at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Models\Article::all() as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>
                                    <a class="my-link" href="{{ asset("storage/photo/".$article->photo) }}">
                                        <img src="{{ asset("storage/thumbnail/".$article->photo) }}" width="50"
                                             alt="image alt"/>
                                    </a>
                                </td>
                                <td>{{ $article->name }}</td>
                                <td>{{ $article->price }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="del({{ $article->id }})">
                                            <i class="fas fa-trash-alt fa-fw"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="edit({{ $article->id }})">
                                            <i class="fas fa-pencil-alt fa-fw"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $article->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editBox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBoxLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBoxLabel">Edit Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="editForm" method="post">
                    @csrf
                    <img src="" class="w-50 d-block mx-auto" id="editImg" alt="">
                    <input type="text" name="name" value="" id="editName" class="form-control">
                    <input type="text" name="price" value="" id="editPrice" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset("js/app.js") }}"></script>
<script>

    let rows = document.getElementById("rows");
    let btnLoaderUi = document.querySelector(".btn-loader");


    // with jquery ajax

    // $("#fruitForm").on("submit", function (e) {
    //     e.preventDefault();
    //     $.post($(this).attr("action"), $(this).serialize(), function (data) {
    //         if (data.status === "success") {
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Data Insert Successful',
    //                 text: 'ဒေတာ ထည့်ခြင်း အောင်မြင်ပါသည်။',
    //             })
    //         } else {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Fails',
    //                 text: 'Something went wrong!',
    //             })
    //         }
    //     })
    // })

    // with js axios

    let fruitForm = document.querySelector("#fruitForm");
    fruitForm.addEventListener("submit", function (e) {
        // loading start
        btnLoaderUi.classList.toggle("d-none");

        e.preventDefault();
        let formData = new FormData(this);
        axios.post(fruitForm.getAttribute("action"), formData).then(function (response) {
            if (response.data.status === "success") {
                console.log(response.data);
                let info = response.data.info;
                let tr = document.createElement("tr");
                tr.classList.add("animate__animated", "animate__slideInDown");
                tr.innerHTML = `
                    <td>${info.id}</td>
                    <td>
                        <a class="my-link" href="${info.original_photo}">
                            <img src="${info.thumbnail}" width="50" alt="image alt"/>
                        </a>
                    </td>
                    <td>${info.name}</td>
                    <td>${info.price}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-trash-alt fa-fw"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-pencil-alt fa-fw"></i>
                            </button>
                        </div>
                    </td>
                    <td>${info.time}</td>
                `;

                rows.append(tr);
                fruitForm.reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Fails',
                    text: 'Something went wrong!',
                })
            }

            // loading stop
            btnLoaderUi.classList.toggle("d-none");
        })

    });

    new VenoBox({
        selector: ".my-link"
    });

    function del(id) {
        console.log(id);
    }

    function edit(id) {
        axios.get("article/"+id).then(function (response) {
            console.log(response.data);
            let info = response.data;
            document.getElementById("editName").value = info.name;
            document.getElementById("editPrice").value = info.price;
            document.getElementById("editImg").src = info.original_photo;
            let currentModal = new bootstrap.Modal(document.getElementById("editBox"));
            currentModal.show();
        })
    }

</script>
</body>
</html>
