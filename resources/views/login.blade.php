<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/logo.png') }}" />
    <!-- CSS files -->
        <link href="/tabler/demo/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
        <link
            href="/tabler/demo/dist/css/tabler-flags.min.css?1684106062"
            rel="stylesheet"
        />
        <link
            href="/tabler/demo/dist/css/tabler-payments.min.css?1684106062"
            rel="stylesheet"
        />
        <link
            href="/tabler/demo/dist/css/tabler-vendors.min.css?1684106062"
            rel="stylesheet"
        />
        <link href="/tabler/demo/dist/css/demo.min.css?1684106062" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="page page-center">
      <div class="container container-tight py-4">

        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login ke akun anda</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="login" method="post" autocomplete="off" novalidate="">
                @csrf
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="your@email.com" autocomplete="off">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password

                </label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" name="password" placeholder="Your password" autocomplete="off">

                </div>
              </div>
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input">
                  <span class="form-check-label">Remember me on this device</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
</body>
</html>
