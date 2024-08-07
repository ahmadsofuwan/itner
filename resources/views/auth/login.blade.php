<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>Rocker - Multipurpose Bootstrap5 Admin Template</title>
</head>

<body class="bg-lock-screen">
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-lock-screen d-flex align-items-center justify-content-center">
            <div class="card bg-transparent shadow-none">
                <div class="card-body p-md-5 text-center">
                    <h2 class="text-white">{{ \Carbon\Carbon::now()->format('h:i A') }}</h2>
                    <h5 class="text-white">{{ \Carbon\Carbon::now()->format('l, F d, Y') }}</h5>
                    <div class="">
                        <img src="assets/images/icons/user.png" class="mt-5" width="120" alt="" />
                    </div>
                    <p class="mt-2 text-white">Itner</p>
                    <form action="{{ route('auth.postLogin') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-3">
                            <input type="text" class="form-control" placeholder="Username" name="username" />
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-white">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>

</html>
